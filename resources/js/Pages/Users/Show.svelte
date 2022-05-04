<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import DetallesUser from './DetallesUser'

    export let institucionEducativa
    export let semilleroInvestigacion
    export let user

    $: $title = 'Detalles del usuario'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('users.index', ['institucionEducativaId=' + institucionEducativa?.id])} class="text-gray-500 hover:text-gray-600"> Usuarios </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <div class="my-20">
        <DetallesUser {user} />
    </div>
</AuthenticatedLayout>
