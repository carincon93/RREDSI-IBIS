<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Pagination from '@/Shared/Pagination'
    import DataTable from '@/Shared/DataTable'
    import DataTableMenu from '@/Shared/DataTableMenu'
    import { Item, Text } from '@smui/list'

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let ideasEmpresa

    $title = 'Ideas y retos'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let filters = {}
</script>

<AuthenticatedLayout>
    <NavEmpresarial />

    <div class="my-20 ml-20">
        <DataTable>
            <div slot="title">Ideas y retos</div>

            <tbody slot="tbody" class="grid grid-cols-3 gap-3">
                {#each ideasEmpresa.data as ideaEmpresa (ideaEmpresa.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                        <td>
                            <div class="grid grid-cols-4">
                                <div class="col-span-3">
                                    <p class="p-4 focus:text-gray-500 first-letter-uppercase fomt-black">
                                        <strong>{ideaEmpresa.nombre}</strong>
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
</AuthenticatedLayout>
