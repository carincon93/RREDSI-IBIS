<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\User;
use App\Models\Franja;

class ExportarProgramacionInstructor implements FromView, ShouldAutoSize
{
    private $instructor_id;

    public function __construct($instructor_id)
    {
        $this->instructor_id = $instructor_id;
    }

    public function view(): View
    {
        $user       = User::findOrFail($this->instructor_id);
        $franjas    = Franja::orderBy('horaFin')->get();

        $asignaciones    = $user->asignacion()->get();
        return view('exportables.programacion', compact('asignaciones', 'franjas'));
    }
}
