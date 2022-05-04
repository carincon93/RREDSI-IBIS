<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import DetallesAmbiente from './DetallesAmbiente'

    export let institucionEducativa
    export let ambienteFormacion

    $: $title = 'Detalles de la ambiente de formación'

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
                    <a use:inertia href={route('instituciones-educativas.ambientes-formacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Ambientes de formación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <div class="mt-[8rem]">
        <DetallesAmbiente {ambienteFormacion} />
    </div>
</AuthenticatedLayout>
