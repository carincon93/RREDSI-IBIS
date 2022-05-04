<table class="table table-bordered table-asignaciones dataTable">
    <thead class="text-center">
        <tr>
            <th style="background-color:#fc7323"><b>Hora</b></th>
            <th style="background-color:#fc7323"><b>Lunes</b></th>
            <th style="background-color:#fc7323"><b>Martes</b></th>
            <th style="background-color:#fc7323"><b>Miércoles</b></th>
            <th style="background-color:#fc7323"><b>Jueves</b></th>
            <th style="background-color:#fc7323"><b>Viernes</b></th>
            <th style="background-color:#fc7323"><b>Sábado</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($franjas as $key => $franja)
            <tr>
                <td style="background-color:#238276; color: #FFffff">
                    <div>
                        {{ $franja->horaInicio . ' - ' . $franja->horaFin }}
                    </div>
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'lunes')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'martes')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'miercoles')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'jueves')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'viernes')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($asignaciones as $key => $asignacion)
                        @if ($asignacion->franja->id == $franja->id && $asignacion->dia == 'sabado')
                            <strong>Ambiente</strong> <br>
                            {{ $asignacion->nombreAmbiente }}
                            <br>
                            <strong>Instructor</strong> <br>
                            {{ $asignacion->nombreInstructor }}
                            <br>
                            <strong>Resultado</strong> <br>
                            {{ $asignacion->resultado_aprendizaje != null ? $asignacion->resultado_aprendizaje->descripcion : '' }}
                            {{-- Competencia <br>
                            {{ $asignacion->competencia->resumen }}
                            <br>
                            Resultados de aprendizaje <br>
                            <ul>
                                @foreach ($asignacion->competencia->resultadosAprendizaje as $resultadoAprendizaje)
                                    <li>{{ $resultadoAprendizaje->descripcion }}</li>
                                @endforeach
                            </ul> --}}
                            <br>
                            <strong>Grupo</strong> <br>
                            {{ $asignacion->programaFormacionNombre . ' (' . $asignacion->numeroFicha . ')' }}
                            <br>
                            <br>
                            @if ($asignacion->fechaInicio)
                                Fechas <br>
                                Del {{ $asignacion->fechaInicio }} al {{ $asignacion->fechaFin }}
                            @endif
                            <br>
                            {{-- Municipio <br>
                            {{ $asignacion->programacion->municipio->nombre }} --}}
                        @endif
                    @endforeach
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No hay franjas horarias definidas aún</td>
            </tr>
        @endforelse
    </tbody>
</table>
