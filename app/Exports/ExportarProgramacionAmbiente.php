<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\Models\Ambiente;
use App\Models\Franja;

class ExportarProgramacionAmbiente implements FromView, ShouldAutoSize
{
    private $ambiente;

    public function __construct($ambiente)
    {
        $this->ambiente = $ambiente;
    }

    public function view(): View
    {
        $franjas  = Franja::orderBy('horaFin')->get();

        $asignaciones = $this->ambiente->asignacion()->get();

        return view('exportables.programacion', compact('asignaciones', 'franjas'));
    }
}
