<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import DetallesEventoRredsiDepartamental from '../../EventosRredsiDepartamental/DetallesEventoRredsiDepartamental'

    export let eventoRredsiDepartamental

    $: $title = 'Detalles del evento RREDSI Departamental'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <DetallesEventoRredsiDepartamental {eventoRredsiDepartamental} />
    <button type="button" on:click={() => Inertia.visit(route('nodos.eventos-rredsi-departamental.registro', [eventoRredsiDepartamental.nodo_id, eventoRredsiDepartamental.id]))} class="fixed right-8 bottom-4 bg-blue-900 text-white p-4 rounded-full shadow flex">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
        </svg>

        <p class="ml-2">Quiero registrarme</p>
    </button>
</AuthenticatedLayout>
