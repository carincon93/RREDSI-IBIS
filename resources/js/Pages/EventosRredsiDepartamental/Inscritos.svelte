<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page, inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Button from '@/Shared/Button'
    import Pagination from '@/Shared/Pagination'
    import DataTable from '@/Shared/DataTable'
    import DataTableMenu from '@/Shared/DataTableMenu'
    import Dialog from '@/Shared/Dialog'
    import { Item, Text } from '@smui/list'

    export let nodo
    export let eventoRredsiDepartamental
    export let inscritos

    $title = 'Inscritos al' + eventoRredsiDepartamental.titulo

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let filters = {}
    let dialogOpen = false
    let inscritoId

    function destroy() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            Inertia.delete(route('inscritos.destroy', inscritoId), {
                onSuccess: () => (dialogOpen = false),
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('nodos.show', [nodo.id, '#eventos'])} class="text-gray-500 hover:text-gray-600"> Eventos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Inscritos
                </h1>
            </div>
        </div>
    </header>

    <DataTable class="mt-40" showSearchInput={false}>
        <div slot="title">Inscritos al {eventoRredsiDepartamental.titulo}</div>

        <thead slot="thead">
            <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Institución educativa </th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Primer ponente </th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Segundo ponente </th>
                <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full text-center"> Acciones </th>
            </tr>
        </thead>
        <tbody slot="tbody">
            {#each inscritos.data as inscrito (inscrito.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                    <td class="border-t">
                        <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                            {inscrito.semillero_investigacion.grupo_investigacion.facultad.institucion_educativa.nombre}
                        </p>
                    </td>

                    <td class="border-t">
                        <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                            {inscrito.primer_ponente.name}
                        </p>
                    </td>

                    <td class="border-t">
                        <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                            {inscrito.segundo_ponente.name}
                        </p>
                    </td>

                    <td class="border-t td-actions">
                        <DataTableMenu class={inscritos.data.length < 4 ? 'z-50' : ''}>
                            {#if isSuperAdmin || checkPermission(authUser, [21])}
                                <Item on:SMUI:action={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.inscritos.detalles', [nodo.id, eventoRredsiDepartamental.id, inscrito.id]))}>
                                    <Text>Ver detalles</Text>
                                </Item>
                                <Item on:SMUI:action={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.inscritos.editar', [nodo.id, eventoRredsiDepartamental.id, inscrito.id]))}>
                                    <Text>Editar</Text>
                                </Item>
                                <Item on:SMUI:action={() => ((inscritoId = inscrito.id), (dialogOpen = true))}>
                                    <Text>Eliminar</Text>
                                </Item>
                            {/if}
                        </DataTableMenu>
                    </td>
                </tr>
            {/each}

            {#if inscritos.data.length === 0}
                <tr>
                    <td class="border-t px-6 py-4" colspan="4"> Sin información registrada </td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={inscritos.links} />

    <Dialog bind:open={dialogOpen}>
        <div slot="title" class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Eliminar recurso
        </div>
        <div slot="content">
            <p>
                ¿Está seguro(a) que desea eliminar este recurso?
                <br />
                Todos los datos se eliminarán de forma permanente.
                <br />
                Está acción no se puede deshacer.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={(event) => (dialogOpen = false)} variant={null}>Cancelar</Button>
                <Button variant="raised" on:click={destroy}>Confirmar</Button>
            </div>
        </div>
    </Dialog>
</AuthenticatedLayout>
