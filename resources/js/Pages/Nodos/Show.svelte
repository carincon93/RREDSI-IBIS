<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import DataTable from '@/Shared/DataTable'
    import Button from '@/Shared/Button'
    import DataTableMenu from '@/Shared/DataTableMenu'
    import { Item, Text } from '@smui/list'
    import Dialog from '@/Shared/Dialog'
    import { Inertia } from '@inertiajs/inertia'

    export let nodo

    let eventoId
    let dialogOpen = false

    $: $title = 'Detalles del nodo'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    function destroy() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            Inertia.delete(route('nodos.eventos-rredsi-departamental.destroy', [nodo.id, eventoId]), {
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
                    <a use:inertia href={route('nodos.index')} class="text-gray-500 hover:text-gray-600"> Nodos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mt-40 text-3xl font-medium text-center mb-10">
        Nodo {nodo.departamento}
        {#if isSuperAdmin || checkPermission(authUser, [21])}
            <Button on:click={() => Inertia.visit(route('nodos.edit', nodo.id))} variant="raised" class="ml-4 bg-gray-500">Editar</Button>
        {/if}
    </h1>
    <figure>
        <img class="mx-auto" src={'/storage/' + nodo.logo} alt="Logo {nodo.departamento}" />
    </figure>

    <div class="py-12 mb-20">
        <h2 class="mt-10 text-3xl font-medium text-center">Instituciones educativas</h2>
        <div class="grid grid-cols-3 gap-10 mt-8">
            {#each nodo.instituciones_educativas as institucionEducativa}
                {#if isSuperAdmin || checkPermission(authUser, [34])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.show', institucionEducativa.id)}>
                        <figure class="">
                            <img src="/storage/{institucionEducativa.logo}" class="h-16 m-auto" alt="Logo {institucionEducativa.nombre}" />
                        </figure>
                        {institucionEducativa.nombre}
                    </a>
                {/if}
            {/each}
            {#if nodo.instituciones_educativas.length == 0}
                <p>Sin información registrada</p>
            {/if}
        </div>
        {#if isSuperAdmin || checkPermission(authUser, [33])}
            <div class="flex items-center justify-center mt-10">
                <Button on:click={() => Inertia.visit(route('instituciones-educativas.index'))} variant="raised" class="bg-gray-500 mt-10">Ver listado completo de instituciones educativas</Button>
            </div>
        {/if}

        <hr class="block my-36" id="eventos=" />

        <DataTable showSearchInput={false}>
            <div slot="title">
                Eventos departamentales
                {#if isSuperAdmin || checkPermission(authUser, [21])}
                    <Button on:click={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.create', nodo.id))} variant="raised" class="ml-4 bg-gray-500">Nuevo evento</Button>
                {/if}
            </div>

            <tbody slot="tbody" class="grid grid-cols-3 gap-3">
                {#each nodo.eventos_rredsi_departamental as evento (evento.id)}
                    <tr class="hover:bg-gray-100 focus-within:bg-gray-100 shadow flex items-center">
                        <td>
                            <div class="grid grid-cols-4">
                                <div class="col-span-3">
                                    <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                        {evento.titulo}
                                        <br />
                                        {evento.institucion_educativa.nombre}
                                        <br />
                                        {evento.year}
                                    </p>
                                </div>
                                <div class="flex justify-center items-center">
                                    <DataTableMenu class={nodo.eventos_rredsi_departamental.length < 4 ? 'z-50' : ''}>
                                        {#if isSuperAdmin || checkPermission(authUser, [22])}
                                            <Item on:SMUI:action={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.inscritos', [nodo.id, evento.id]))}>
                                                <Text>Inscritos</Text>
                                            </Item>
                                        {/if}
                                        {#if isSuperAdmin || checkPermission(authUser, [22])}
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
                                            <Item on:SMUI:action={() => ((eventoId = nodo.id), (dialogOpen = true))}>
                                                <Text>Eliminar</Text>
                                            </Item>
                                        {/if}
                                    </DataTableMenu>
                                </div>
                            </div>
                        </td>
                    </tr>
                {/each}

                {#if nodo.eventos_rredsi_departamental.length === 0}
                    <tr>
                        <td class="px-6 py-4" colspan="4"> Sin información registrada </td>
                    </tr>
                {/if}
            </tbody>
        </DataTable>
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
