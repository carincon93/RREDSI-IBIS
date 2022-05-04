<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let institucionEducativa

    $: $title = institucionEducativa.nombre

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <h1 class="mt-10 text-3xl font-medium text-center">{institucionEducativa.nombre}</h1>
    <figure class="mr-2">
        <img src="/storage/{institucionEducativa.logo}" class="h-20 mx-auto mt-10" alt="Logo {institucionEducativa.nombre}" />
    </figure>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la institución educativa</h3>
            <p class="mt-1 text-sm text-gray-600">Revise toda la información del institución educativa.</p>
            {#if isSuperAdmin || checkPermission(authUser, [33])}
                <a use:inertia href={route('instituciones-educativas.edit', institucionEducativa.id)} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-2">
                <p class="font-medium">Ciudad</p>
                <p>{institucionEducativa.ciudad}</p>
            </div>
            <div class="py-2">
                <p class="font-medium">Nodo</p>
                <p>{institucionEducativa.nodo.departamento}</p>
            </div>
            <div class="py-2">
                <p class="font-medium">NIT</p>
                <p>{institucionEducativa.nit}</p>
            </div>
            <div class="py-2">
                <p class="font-medium">Dirección</p>
                <p>{institucionEducativa.direccion}</p>
            </div>
            <div class="py-2">
                <p class="font-medium">Número de teléfono</p>
                <p>{institucionEducativa.numero_telefono}</p>
            </div>
            <div class="py-2">
                <p class="font-medium">Sitio web</p>
                <a href={institucionEducativa.sitio_web} target="_blank">{institucionEducativa.sitio_web}</a>
            </div>
        </div>
    </div>

    {#if isSuperAdmin || checkPermission(authUser, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 35, 36, 13, 14, 15, 16, 17, 18])}
        <div class="py-12 my-20">
            <h2 class="my-10 text-3xl font-medium text-center">Menú</h2>
            <div class="grid grid-cols-3 gap-10 mt-8">
                {#if isSuperAdmin || checkPermission(authUser, [1, 2])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.facultades.index', institucionEducativa.id)}>Facultades / Centros de formación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [3, 4])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.grupos-investigacion.index', institucionEducativa.id)}>Grupos de investigación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [5, 6])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.lineas-investigacion.index', institucionEducativa.id)}>Líneas de investigación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [7, 8])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.semilleros-investigacion.index', institucionEducativa.id)}>Semilleros de investigación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [9, 10])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.programas-academicos.index', institucionEducativa.id)}>Programas académicos</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [11, 12])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.ambientes-formacion.index', institucionEducativa.id)}>Ambientes de formación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [35, 36])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.equipos-formacion.index', institucionEducativa.id)}>Equipos de formación</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [13, 14])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.proyectos.index', institucionEducativa.id)}>Proyectos</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [15, 16])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('instituciones-educativas.eventos.index', institucionEducativa.id)}>Eventos</a>
                {/if}

                {#if isSuperAdmin || checkPermission(authUser, [17, 18])}
                    <a use:inertia class="bg-white overflow-hidden sm:rounded-lg px-6 py-2 hover:bg-blue-900 hover:text-white h-52 flex justify-around items-center flex-col shadow-md" href={route('users.index', ['institucionEducativaId=' + institucionEducativa.id])}>Usuarios</a>
                {/if}
            </div>
        </div>
    {/if}
</AuthenticatedLayout>
