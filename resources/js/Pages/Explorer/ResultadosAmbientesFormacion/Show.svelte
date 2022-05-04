<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import DetallesAmbiente from '../../AmbientesFormacion/DetallesAmbiente'

    export let ambienteFormacion

    $: $title = 'Detalles del ambiente'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <DetallesAmbiente {ambienteFormacion} />
</AuthenticatedLayout>
