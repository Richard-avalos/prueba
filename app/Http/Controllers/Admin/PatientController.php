<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\controllers\Controller;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patiens = User::patients()->paginate(10);
        return view('patiens.index', compact('patiens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patiens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'name.required' => 'El nombre del paciente es obligatorio',
            'name.min' => 'El nombre del paciente debe tener más de 3 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'name.email' => 'Ingresa una dirección de correo electrónico válido',
            'cedula.required' => 'La cedula es obligatorio',
            'cedula.digits' => 'La cedula debe de tener 10 digitos',
            'address.min' => 'La dirección debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];
        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name','email','cedula','address','phone')
            +[
                'role' => 'paciente',
                'password'=>bcrypt($request->input('password'))
            ]
        );
        $notification = 'El paciente se ha registrado correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = User::Patients()->findOrFail($id);
        return view('Patiens.edit', compact('patient'));
    }

    function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];
        
        $messages = [
            'name.required' => 'El nombre del paciente es obligatorio',
            'name.min' => 'El nombre del paciente debe tener más de 3 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'name.email' => 'Ingresa una dirección de correo electrónico válido',
            'cedula.required' => 'La cedula es obligatorio',
            'cedula.digits' => 'La cedula debe de tener 10 digitos',
            'address.min' => 'La dirección debe tener al menos 6 caracteres',
            'phone.required' => 'El numero de telefono es obligatorio'
        ];
        $this->validate($request, $rules, $messages);
        $user = User::Patients()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
        
        $notification = 'La informacion del paciente se actualizo correctamente.';
        return redirect('/pacientes')->with(compact('notification'));
    }

    
    public function destroy(string $id)
    {
        $user = User::Patients()->findOrFail($id);
        $PacienteName = $user->name;
        $user->delete();

        $notification = "El paciente $PacienteName ha sido eliminado correctamente";

        return redirect('/pacientes')->with(compact('notification'));

    }
}
