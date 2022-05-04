<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page, inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from './NavEmpresarial'
    import Pagination from '@/Shared/Pagination'
    import DataTable from '@/Shared/DataTable'
    import DataTableMenu from '@/Shared/DataTableMenu'
    import { Item, Text } from '@smui/list'
    import { Inertia } from '@inertiajs/inertia'

    export let eventos

    $: $title = 'Eventos de nodo'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <NavEmpresarial />

    <div class="ml-20 mt-20">
        <h1 class="mt-10 text-3xl font-medium text-center">Eventos académicos</h1>
        <DataTable>
            <tbody slot="tbody" class="grid grid-cols-3 gap-3">
                {#each eventos.data as evento (evento.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                        <td>
                            <div class="grid grid-cols-4">
                                <div class="col-span-3">
                                    <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                        {evento.nombre}
                                    </p>
                                </div>
                                <div class="flex justify-center items-center">
                                    <DataTableMenu class={eventos.data.length < 4 ? 'z-50' : ''}>
                                        <Item on:SMUI:action={() => Inertia.visit(route('eventos-academicos.show', [evento.id]))}>
                                            <Text>Ver detalles</Text>
                                        </Item>
                                    </DataTableMenu>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/each}

                {#if eventos.data.length === 0}
                    <tr>
                        <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
                    </tr>
                {/if}
            </tbody>
        </DataTable>
        <Pagination links={eventos.links} />
    </div>
</AuthenticatedLayout>
