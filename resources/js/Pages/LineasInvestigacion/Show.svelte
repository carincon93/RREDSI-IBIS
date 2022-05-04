<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let institucionEducativa
    export let lineaInvestigacion

    $: $title = 'Detalles de la línea de investigación'

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
                    <a use:inertia href={route('instituciones-educativas.lineas-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Líneas de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mt-20 text-3xl font-medium text-center">{lineaInvestigacion.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la línea de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información de la línea de investigación.</p>
            {#if isSuperAdmin || checkPermission(authUser, [5])}
                <a use:inertia href={route('instituciones-educativas.lineas-investigacion.edit', [institucionEducativa.id, lineaInvestigacion.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Objetivos</p>
                <p class="whitespace-pre-line">{lineaInvestigacion.objetivos}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Misión</p>
                <p class="whitespace-pre-line">{lineaInvestigacion.mision}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Visión</p>
                <p class="whitespace-pre-line">{lineaInvestigacion.vision}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Logros</p>
                <p class="whitespace-pre-line">{lineaInvestigacion.logros}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Grupo de investigación</p>
                <p>{lineaInvestigacion.grupo_investigacion.nombre}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
