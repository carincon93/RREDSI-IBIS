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

    export let experiencias

    $title = 'Buscar experiencias'

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
            <div slot="title">Buscar experiencias</div>

            <tbody slot="tbody" class="grid grid-cols-3 gap-3">
                {#each experiencias.data as experiencia (experiencia.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                        <td>
                            <div class="grid grid-cols-4">
                                <div class="col-span-3">
                                    <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                        {experiencia.titulo}
                                    </p>
                                </div>
                                <div class="flex justify-center items-center">
                                    <DataTableMenu class={experiencias.data.length < 4 ? 'z-50' : ''}>
                                        {#if isSuperAdmin || checkPermission(authUser, [30])}
                                            <Item on:SMUI:action={() => Inertia.visit(route('experiencias.show', [experiencia.id]))}>
                                                <Text>Ver detalles</Text>
                                            </Item>
                                        {/if}
                                    </DataTableMenu>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/each}

                {#if experiencias.data.length === 0}
                    <tr>
                        <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
                    </tr>
                {/if}
            </tbody>
        </DataTable>
        <Pagination links={experiencias.links} />
    </div>
</AuthenticatedLayout>
