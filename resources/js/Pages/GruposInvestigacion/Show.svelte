<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let institucionEducativa
    export let grupoInvestigacion

    $: $title = 'Detalles del grupo de investigación'

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
                    <a use:inertia href={route('instituciones-educativas.grupos-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Grupos de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mt-20 text-3xl font-medium text-center">{grupoInvestigacion.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del grupo de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información del grupo de investigación.</p>
            {#if isSuperAdmin || checkPermission(authUser, [3])}
                <a use:inertia href={route('instituciones-educativas.grupos-investigacion.edit', [institucionEducativa.id, grupoInvestigacion.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Correo electrónico</p>
                <p>{grupoInvestigacion.email}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Nombre del líder de grupo</p>
                <p>{grupoInvestigacion.lider}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Enlace del GrupLAC</p>
                <a href={grupoInvestigacion.gruplac} target="_blank">{grupoInvestigacion.gruplac}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Código Minciencias</p>
                <p>{grupoInvestigacion.codigo_minciencias}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Categoría Minciencias</p>
                <p>{grupoInvestigacion.categoria_minciencias}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Sitio web</p>
                <a href={grupoInvestigacion.sitio_web} target="_blank">{grupoInvestigacion.sitio_web}</a>
            </div>
            <div class="py-8">
                <p class="font-medium">Facultad</p>
                <p>{grupoInvestigacion.facultad.nombre}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
