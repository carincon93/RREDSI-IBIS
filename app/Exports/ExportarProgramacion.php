<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\Programacion;
use App\Models\Franja;

class ExportarProgramacion implements FromView, ShouldAutoSize
{
    private $programacion_id;

    public function __construct($programacion_id)
    {
        $this->programacion_id = $programacion_id;
    }

    public function view(): View
    {
        $programacion   = Programacion::findOrFail($this->programacion_id);
        $franjas        = Franja::orderBy('horaFin')->get();

        $asignaciones   = $programacion->asignacion()->get();
        return view('exportables.programacion', compact('asignaciones', 'franjas'));
    }
}
