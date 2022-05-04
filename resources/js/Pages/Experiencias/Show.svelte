<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let experiencia

    $: $title = 'Detalles de la experiencia'

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
                    <a use:inertia href={route('experiencias.index')} class="text-gray-500 hover:text-gray-600"> Experiencias </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <NavEmpresarial />

    <h1 class="mt-20 text-3xl font-medium text-center">{experiencia.titulo}</h1>
    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la experiencia</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información de la experiencia.</p>
            {#if isSuperAdmin || checkPermission(authUser, [29])}
                <a use:inertia href={route('experiencias.edit', [experiencia.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Descripción</p>
                <p class="whitespace-pre-line">{experiencia.descripcion}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Imagen</p>
                <figure>
                    <img src={'/storage/' + experiencia.image} alt={'Imagen ' + experiencia.titulo} />
                </figure>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
