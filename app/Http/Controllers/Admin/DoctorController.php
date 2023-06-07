<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\controllers\Controller;
use App\Models\Specialty;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::doctors()->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];
        
        $messages = [
            'name.required' => 'El nombre del medico es obligatorio',
            'name.min' => 'El nombre del medico debe tener más de 3 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'name.email' => 'Ingresa una dirección de correo electrónico válido',
            'cedula.required' => 'La cedula es obligatorio',
            'cedula.digits' => 'La cedula debe de tener 10 digitos',
            'address.min' => 'La dirección debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];
        $this->validate($request, $rules, $messages);

        $user= User::create(
            
            $request->only('name','email','cedula','address','phone')
            +[
                'role' => 'doctor',
                'password'=>bcrypt($request->input('password'))
            ]
        );

        $user->specialties()->attach($request->input('specialties'));
        
        $notification = 'El medico se ha registrado correctamente.';
        return redirect('/medicos')->with(compact('notification'));
    }

  
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);

        $specialties = Specialty::all();
        $specialty_ids = $doctor->specialties()->pluck('specialties.id');

        return view('doctors.edit', compact('doctor', 'specialties', 'specialty_ids'));
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];
        
        $messages = [
            'name.required' => 'El nombre del medico es obligatorio',
            'name.min' => 'El nombre del medico debe tener más de 3 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'name.email' => 'Ingresa una dirección de correo electrónico válido',
            'cedula.required' => 'La cedula es obligatorio',
            'cedula.digits' => 'La cedula debe de tener 10 digitos',
            'address.min' => 'La dirección debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];
        $this->validate($request, $rules, $messages);
        $user = User::doctors()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        $user->specialties()->sync($request->input('specialties'));
        
        $notification = 'La informacion del medico se actualizo correctamente.';
        return redirect('/medicos')->with(compact('notification'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::doctors()->findOrFail($id);
        $doctorName = $user->name;
        $user->delete();

        $notification = "El medico $doctorName ha sido eliminado correctamente";

        return redirect('/medicos')->with(compact('notification'));


    }
}
