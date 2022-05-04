<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let convocatoria

    $: $title = 'Detalles de la convocatoria'

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
                    <a use:inertia href={route('convocatorias.index')} class="text-gray-500 hover:text-gray-600"> Convocatorias </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    {#if authUser.empresa_id}
        <NavEmpresarial />
    {/if}

    <h1 class="mt-20 text-3xl font-medium text-center">{convocatoria.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la convocatoria</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información de la convocatoria.</p>
            {#if isSuperAdmin || (authUser.id == convocatoria.autor_id && checkPermission(authUser, [19]))}
                <a use:inertia href={route('convocatorias.edit', [convocatoria.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Detalles de la convocatoria</p>
                <p class="whitespace-pre-line">{convocatoria.detalles}</p>
            </div>
            {#if convocatoria.image}
                <div class="py-8">
                    <p class="font-medium">Imagen</p>
                    <figure>
                        <img src={'/storage/' + convocatoria.image} alt={'Imagen ' + convocatoria.nombre} />
                    </figure>
                </div>
            {/if}

            <div class="py-8">
                <p class="font-medium">Enlace para más información</p>
                <a href={convocatoria.link_mas_informacion} class="underline" target="_blank">{convocatoria.link_mas_informacion}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Fecha de inicio</p>
                <p class="whitespace-pre-line">{convocatoria.fecha_inicio}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Fecha de finalización</p>
                <p class="whitespace-pre-line">{convocatoria.fecha_finalizacion}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
