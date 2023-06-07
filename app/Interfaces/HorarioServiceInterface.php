<?php namespace App\Interfaces;

use Carbon\Carbon;

interface HorarioServiceInterface {
    public function isAvailableInterval($date, $doctorId, Carbon $start);
    public function getAvilableIntervals($date, $doctorId);
}