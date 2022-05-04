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

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let ideasEmpresa

    $title = 'Mis ideas'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let filters = {}
    let dialogOpen = false
    let ideaEmpresaId

    function destroy() {
        if (isSuperAdmin || checkPermission(authUser, [31])) {
            Inertia.delete(route('ideas-empresa.destroy', [ideaEmpresaId]), {
                onSuccess: () => (dialogOpen = false),
            })
        }
    }
</script>

<AuthenticatedLayout>
    <NavEmpresarial />

    <div class="my-20 ml-20">
        <DataTable>
            <div slot="title">Mis ideas</div>

            <div slot="actions">
                {#if isSuperAdmin || checkPermission(authUser, [31])}
                    <Button on:click={() => Inertia.visit(route('ideas-empresa.create'))} variant="raised" class="bg-gray-500">Publicar idea</Button>
                {/if}
            </div>

            <tbody slot="tbody" class="grid grid-cols-3 gap-3">
                {#each ideasEmpresa.data as ideaEmpresa (ideaEmpresa.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                        <td>
                            <div class="grid grid-cols-4">
                                <div class="col-span-3">
                                    <p class="p-4 focus:text-gray-500 first-letter-uppercase font-black">
                                        {ideaEmpresa.nombre}
                                    </p>
                                    <p class="py-2 pl-4 text-sm paragraph-ellipsis text-justify">
                                        <strong>Descripción:</strong>
                                        <br />
                                        {ideaEmpresa.descripcion}
                                    </p>
                                </div>
                                <div class="flex justify-center items-center">
                                    <DataTableMenu class={ideasEmpresa.data.length < 4 ? 'z-50' : ''}>
                                        {#if isSuperAdmin || checkPermission(authUser, [32])}
                                            <Item on:SMUI:action={() => Inertia.visit(route('ideas-empresa.show', [ideaEmpresa.id]))}>
                                                <Text>Ver detalles</Text>
                                            </Item>
                                        {/if}
                                        {#if isSuperAdmin || (checkPermission(authUser, [31]) && authUser.empresa_id == ideaEmpresa.empresa_id)}
                                            <Item on:SMUI:action={() => Inertia.visit(route('ideas-empresa.edit', [ideaEmpresa.id]))}>
                                                <Text>Editar</Text>
                                            </Item>
                                        {/if}
                                        {#if isSuperAdmin || (checkPermission(authUser, [31]) && authUser.empresa_id == ideaEmpresa.empresa_id)}
                                            <Item on:SMUI:action={() => ((ideaEmpresaId = ideaEmpresa.id), (dialogOpen = true))}>
                                                <Text>Eliminar</Text>
                                            </Item>
                                        {/if}
                                    </DataTableMenu>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/each}

                {#if ideasEmpresa.data.length === 0}
                    <tr>
                        <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
                    </tr>
                {/if}
            </tbody>
        </DataTable>
        <Pagination links={ideasEmpresa.links} />
    </div>

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
