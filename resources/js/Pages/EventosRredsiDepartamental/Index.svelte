<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
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
    export let eventosRredsiDepartamental

    $title = 'Eventos RREDSI departamental'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let filters = {}
    let dialogOpen = false
    let eventoId

    function destroy() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            Inertia.delete(route('nodos.eventos-rredsi-departamental.destroy', [nodo.id, eventoId]), {
                onSuccess: () => (dialogOpen = false),
            })
        }
    }
</script>

<AuthenticatedLayout>
    <DataTable routeParams={[nodo.id]}>
        <div slot="title">Eventos RREDSI departamental</div>

        <div slot="actions">
            {#if isSuperAdmin || checkPermission(authUser, [21])}
                <Button on:click={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.create', [nodo.id]))} variant="raised" class="bg-gray-500">Crear evento</Button>
            {/if}
        </div>

        <tbody slot="tbody" class="grid grid-cols-3 gap-3">
            {#each eventosRredsiDepartamental.data as evento (evento.id)}
                <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                    <td>
                        <div class="grid grid-cols-4">
                            <div class="col-span-3">
                                <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                    {evento.titulo}
                                </p>
                            </div>
                            <div class="flex justify-center items-center">
                                <DataTableMenu class={eventosRredsiDepartamental.data.length < 4 ? 'z-50' : ''}>
                                    {#if isSuperAdmin || checkPermission(authUser, [21, 22])}
                                        <Item on:SMUI:action={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.show', [nodo.id, evento.id]))}>
                                            <Text>Ver detalles</Text>
                                        </Item>
                                    {/if}
                                    {#if isSuperAdmin || checkPermission(authUser, [21])}
                                        <Item on:SMUI:action={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.edit', [nodo.id, evento.id]))}>
                                            <Text>Editar</Text>
                                        </Item>
                                    {/if}
                                    {#if isSuperAdmin || checkPermission(authUser, [21])}
                                        <Item on:SMUI:action={() => ((eventoId = evento.id), (dialogOpen = true))}>
                                            <Text>Eliminar</Text>
                                        </Item>
                                    {/if}
                                </DataTableMenu>
                            </div>
                        </div>
                    </td>
                </tr>
            {/each}

            {#if eventosRredsiDepartamental.data.length === 0}
                <tr>
                    <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
                </tr>
            {/if}
        </tbody>
    </DataTable>
    <Pagination links={eventosRredsiDepartamental.links} />

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
