<script>
    export let franjas
    export let asignaciones

    let dias = ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado']
</script>

<div class="bg-white">
    {#each franjas as franja}
        <div class="franja">
            <div class="grid grid-cols-6">
                <div class="flex items-center border-t">
                    <p class="hora">
                        <small>{franja.horaInicio + ' - ' + franja.horaFin}</small>
                    </p>
                </div>
                <div class="col-span-5">
                    <div class="grid grid-cols-6 divide-y divide-x">
                        {#each dias as dia, index}
                            <div class="dia-wrapper{index == 0 ? ' border-t border-l ' : ' '}relative">
                                <h6 class="dia flex justify-around items-center">
                                    {dia}
                                </h6>

                                {#if asignaciones.length > 0}
                                    <div class="asignacion p-2 rounded-br-lg{asignaciones.find((item) => item.franja_id == franja.id && item.dia == dia) ? ' mt-4 mb-2 bg-lime-300 shadow' : ''}">
                                        {#each asignaciones as asignacion}
                                            {#if asignacion.franja_id == franja.id && asignacion.dia == dia}
                                                <div class="lowercase text-xs">
                                                    <span class="font-bold">{asignacion.nombreAmbiente}</span>
                                                    <br />
                                                    <span>{asignacion.nombreInstructor}</span>
                                                </div>
                                                <div class="area">
                                                    __
                                                    {#if asignacion.fechaInicio}
                                                        <div>
                                                            <p class="mb-0">
                                                                <span class="fecha">{asignacion.fechaInicio}</span> al <span class="fecha">{asignacion.fechaFin}</span>
                                                            </p>
                                                        </div>
                                                    {/if}
                                                </div>
                                                {#if asignacion.fechaInicio}
                                                    {asignacion.fechaInicio}
                                                {/if}
                                            {/if}
                                        {/each}
                                    </div>
                                {/if}
                            </div>
                        {/each}
                    </div>
                </div>
            </div>
        </div>
    {/each}
</div>

<style>
    .dia-wrapper {
        min-height: 76.5px;
        padding: 0.2rem;
    }
</style>
