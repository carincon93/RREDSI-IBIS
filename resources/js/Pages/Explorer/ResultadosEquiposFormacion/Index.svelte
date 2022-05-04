<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page, inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import InfoMessage from '@/Shared/InfoMessage'

    export let nodo
    export let equiposFormacion
    export let search

    $title = 'Resultados de búsqueda de equipos'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <div class="p-24 mt-10" style="background: #fff url(/storage/images/dots.png);background-size: cover;background-position: right;background-repeat: no-repeat;">
        <h1 class="text-3xl text-center sm:text-3xl tracking-tight font-extrabold leading-none">
            <span class="block text-blue-900 xl:inline">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 20 20" class="inline mb-2">
                    <path
                        d="M14.03,12.914l-5.82,2.66a1.288,1.288,0,0,0-.636.636l-2.66,5.82A.8.8,0,0,0,5.97,23.086l5.82-2.66a1.288,1.288,0,0,0,.636-.636l2.66-5.82a.8.8,0,0,0-1.056-1.056Zm-3.119,6a1.288,1.288,0,1,1,0-1.821A1.288,1.288,0,0,1,10.91,18.91ZM10,8A10,10,0,1,0,20,18,10,10,0,0,0,10,8Zm0,18.065A8.065,8.065,0,1,1,18.065,18,8.074,8.074,0,0,1,10,26.065Z"
                        transform="translate(0 -8)"
                        fill="#1e3a8a"
                    />
                </svg>
                Explorer: Consulte equipos especializados que se disponen en las instituciones educativas de la red
            </span>
        </h1>
        <p class="pre-line-initial mt-3  text-gray-500 sm:mt-5 md:mt-5 lg:mx-0 text-center text-2xl w-full">
            {equiposFormacion.length} resultado(s) para: {search}
        </p>
    </div>
    <div class="mt-8">
        <div class="max-w-7xl mx-auto">
            <div class="py-[6rem]">
                <h1 class="text-3xl text-center mb-20">Resultados</h1>
                <div class="grid grid-cols-{equiposFormacion.length <= 3 ? equiposFormacion.length : 3} justify-around gap-3">
                    {#each equiposFormacion as equipoFormacion}
                        <a use:inertia href={route('nodos.explorer.busqueda-equipos.ver-equipo', [nodo, equipoFormacion.id])} class="text-white block m-2 shadow-xl">
                            <div class="text-white">
                                <img src="/storage/{equipoFormacion.foto}" class="w-full h-64 object-cover" alt="" />
                                <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6">
                                    <div class="flex items-center relative z-10">
                                        <div class="text-lg leading-7 font-semibold">
                                            {equipoFormacion.nombre}
                                        </div>
                                    </div>
                                    <div class="relative z-10 text-white">
                                        <p class="mt-2 text-white text-sm paragraph-ellipsis">
                                            {equipoFormacion.descripcion}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    {/each}
                </div>
                {#if equiposFormacion.length == 0}
                    <InfoMessage alertMsg={true} class="w-full">Sin información registrada.</InfoMessage>
                {/if}
            </div>
        </div>
    </div>
</AuthenticatedLayout>
