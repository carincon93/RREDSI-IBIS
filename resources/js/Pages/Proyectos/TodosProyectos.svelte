<script>
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { inertia } from '@inertiajs/inertia-svelte'

    import Pagination from '@/Shared/Pagination'
    import DataTable from '@/Shared/DataTable'

    export let proyectos
</script>

<DataTable>
    <tbody slot="tbody" class="grid grid-cols-3 gap-3">
        {#each proyectos.data as proyecto (proyecto.id)}
            <tr class="flex items-center">
                <td>
                    <div>
                        <a use:inertia href={route('nodos.explorer.busqueda-proyectos.ver-proyecto', [proyecto.facultad.institucion_educativa.nodo_id, proyecto.id])} class="text-white block m-2 shadow-xl">
                            <div class="text-white">
                                <img src="/storage/{proyecto.main_image}" class="w-full h-64 object-cover" alt="" />
                                <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6">
                                    <div class="flex items-center relative z-10">
                                        <div class="text-lg leading-7 font-semibold">
                                            {proyecto.titulo}
                                        </div>
                                    </div>
                                    <div class="relative z-10 text-white">
                                        <p class="mt-2 text-white text-sm paragraph-ellipsis">
                                            {proyecto.resumen}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </td>
            </tr>
        {/each}

        {#if proyectos.data.length === 0}
            <tr>
                <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
            </tr>
        {/if}
    </tbody>
</DataTable>
<Pagination links={proyectos.links} />
