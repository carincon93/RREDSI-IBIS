<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let estudio

    $: $title = 'Detalles del estudio'

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
                    <a use:inertia href={route('instituciones-educativas.grupos-investigacion.index')} class="text-gray-500 hover:text-gray-600"> Mis estudios </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mt-20 text-3xl font-medium text-center">{estudio.user.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del estudio</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información del estudio.</p>
            <a use:inertia href={route('instituciones-educativas.grupos-investigacion.edit', [estudio.id])} class="text-sm underline text-gray-500">Editar la información</a>
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Institución educativa</p>
                <p>{estudio.institucion_educativa}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Programa académico</p>
                <p>{estudio.programa_academico}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Graduado</p>
                <p>{estudio.graduado}</p>
            </div>

            {#if estudio.graduado}
                <div class="py-8">
                    <p class="font-medium">Año del grado</p>
                    <p>{estudio.year}</p>
                </div>
            {/if}
        </div>
    </div>
</AuthenticatedLayout>
