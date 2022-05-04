<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page, useForm } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Shared/Input'
    import InfoMessage from '@/Shared/InfoMessage'

    export let currentYear
    export let nodo
    export let eventoRredsiDepartamental
    export let areasConocimiento

    $title = 'Explorer'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let formBusquedaProyecto = useForm({
        searchInputProyecto: '',
    })
    function buscarProyectos() {
        $formBusquedaProyecto.get(route('nodos.explorer.busqueda-proyectos', nodo))
    }

    let formBusquedaAmbientes = useForm({
        searchInputAmbiente: '',
    })
    function buscarAmbientesFormacion() {
        $formBusquedaAmbientes.get(route('nodos.explorer.busqueda-ambientes', nodo))
    }

    let formBusquedaEquipos = useForm({
        searchInputEquipo: '',
    })
    function buscarEquiposFormacion() {
        $formBusquedaEquipos.get(route('nodos.explorer.busqueda-equipos', nodo))
    }
</script>

<AuthenticatedLayout>
    <div class="overflow-hidden">
        <section class="snap-start relative h-screen">
            <div class="max-w-7xl mx-auto pb-14 pt-4">
                <div class="grid grid-cols-2 min-h-[32.6rem] relative">
                    <div class="flex flex-col justify-center pr-10">
                        <h1 class="mt-[-2rem] text-4xl text-left font-extrabold">
                            <span class="block text-blue-900 xl:inline">
                                RREDSI-Ibis: La plataforma para el fortalecimiento de la investigación académica de
                                {nodo.departamento}
                            </span>
                        </h1>
                        <p class="mt-10">
                            Con la nueva plataforma RREDSI-Ibis ahora puede buscar proyectos de su interés que se esten trabajando en los semilleros de investigación de las {nodo.instituciones_educativas?.length} instituciones educativas de RREDSI {nodo.departamento} y colaborar en su desarrollo o registre su proyecto y conecte con jóvenes investigadores de otras instituciones.
                        </p>
                    </div>
                    <figure class="absolute right-[-17rem] top-[-4rem]" style="clip-path: polygon(21% 0%, 100% 0%, 100% 100%, 0% 100%);">
                        <img src="/storage/images/AdobeStock_hero.jpeg" alt="" class="w-[1000px] h-[667px] object-cover" />
                    </figure>
                </div>
            </div>
        </section>

        <section class="snap-start h-screen" style="background: url(/storage/images/net.png)">
            <div class="max-w-7xl mx-auto pb-14 pt-4">
                <div style="background: url(/storage/images/dots.png); background-size: cover; background-position: right; background-repeat: no-repeat;">
                    <div class="pt-[6rem]">
                        <h1 class="text-3xl ml-1/6 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 20 20" class="inline mb-2">
                                <path
                                    d="M14.03,12.914l-5.82,2.66a1.288,1.288,0,0,0-.636.636l-2.66,5.82A.8.8,0,0,0,5.97,23.086l5.82-2.66a1.288,1.288,0,0,0,.636-.636l2.66-5.82a.8.8,0,0,0-1.056-1.056Zm-3.119,6a1.288,1.288,0,1,1,0-1.821A1.288,1.288,0,0,1,10.91,18.91ZM10,8A10,10,0,1,0,20,18,10,10,0,0,0,10,8Zm0,18.065A8.065,8.065,0,1,1,18.065,18,8.074,8.074,0,0,1,10,26.065Z"
                                    transform="translate(0 -8)"
                                    fill="#000"
                                />
                            </svg>
                            Connect: ¿Necesita apoyo para el desarrollo de su proyecto?
                        </h1>

                        <img src="/storage/images/connect-estudiantes.png" class="mx-auto my-12" alt="" />
                        <div class="flex justify-center items-center flex-col px-[10rem]">
                            <p class="text-center">Fortalezca los resultados de su proyecto conectando con jóvenes investigadores de otras áreas de conocimiento y de diferentes instituciones educativas.</p>
                            <div class="mt-10">
                                <a use:inertia href={route('nodos.explorer.roles', nodo)} class="bg-blue-900 text-white p-4 rounded inline-block"> Más información </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="snap-start h-screen">
            <div class="max-w-7xl mx-auto">
                <div class="pt-[6rem]">
                    <h1 class="text-3xl text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 20 20" class="inline mb-2">
                            <path
                                d="M14.03,12.914l-5.82,2.66a1.288,1.288,0,0,0-.636.636l-2.66,5.82A.8.8,0,0,0,5.97,23.086l5.82-2.66a1.288,1.288,0,0,0,.636-.636l2.66-5.82a.8.8,0,0,0-1.056-1.056Zm-3.119,6a1.288,1.288,0,1,1,0-1.821A1.288,1.288,0,0,1,10.91,18.91ZM10,8A10,10,0,1,0,20,18,10,10,0,0,0,10,8Zm0,18.065A8.065,8.065,0,1,1,18.065,18,8.074,8.074,0,0,1,10,26.065Z"
                                transform="translate(0 -8)"
                                fill="#000"
                            />
                        </svg>
                        ¿Qué se está trabajando en los semilleros de RREDSI NODO {nodo.departamento}?
                    </h1>

                    <img src="/storage/images/proyectos.png" class="mx-auto my-8" alt="" />

                    <p class="text-center mb-8 text-2xl">Encuentre proyectos de su interés y trabaje de forma colaborativa con otros semilleros de investigación</p>
                    <div>
                        <div class="max-w-3xl mx-auto">
                            <form class="shadow" on:submit|preventDefault={buscarProyectos}>
                                <div>
                                    <Input id="search" class="block w-full" type="search" bind:value={$formBusquedaProyecto.searchInputProyecto} label="Busque proyectos por: título, palabras clave" />
                                </div>
                            </form>
                        </div>

                        <div class="justify-around mt-10 text-center text-sm text-gray-500 grid grid-cols-5">
                            {#each areasConocimiento as areaConocimiento}
                                <a use:inertia href={route('nodos.explorer.busqueda-proyectos', [nodo, 'searchInputProyecto=' + areaConocimiento.nombre])} class="ml-1 mb-10 underline">
                                    {areaConocimiento.nombre}
                                </a>
                            {/each}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="snap-start h-screen">
            <div class="max-w-7xl mx-auto">
                <div class="pt-[6rem]">
                    <h1 class="text-3xl text-center mb-20">Proyectos registrados</h1>
                    <div class="grid grid-cols-{nodo.proyectosAleatorios.length <= 3 ? nodo.proyectosAleatorios.length : 3} justify-around gap-3">
                        {#each nodo.proyectosAleatorios as proyecto}
                            <a use:inertia href={route('nodos.explorer.busqueda-proyectos.ver-proyecto', [nodo, proyecto.id])} class="text-white block m-2 shadow-xl">
                                <div class="text-white">
                                    <img src="/storage/{proyecto.main_image}" class="w-full h-64 object-cover" alt="" />
                                    <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6">
                                        <div class="flex items-center relative z-10">
                                            <div class="text-lg leading-7 font-semibold">
                                                {proyecto.titulo}
                                            </div>
                                        </div>
                                        <div class="relative z-10 text-white">
                                            <p class="mt-2 text-white text-sm paragraph-ellipsis">
                                                {proyecto.resumen}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        {/each}
                    </div>

                    {#if nodo.proyectosAleatorios.length == 0}
                        <InfoMessage alertMsg={true} class="w-full">Sin información registrada.</InfoMessage>
                    {/if}
                </div>
            </div>
        </section>

        <section class="snap-start h-screen">
            <div class="max-w-7xl mx-auto">
                <div class="pt-[6rem]">
                    <h1 class="text-4xl text-gray-400  text-center">Infraestructura / Ambientes</h1>

                    <img src="/storage/images/infraestructura.png" class="mx-auto my-8" alt="" />

                    <p class="text-center mb-8 text-2xl">Realice una consulta de la infraestructura o ambientes que se disponen en las instituciones educativas de la red.</p>

                    <div>
                        <div class="max-w-3xl mx-auto">
                            <form class="shadow" on:submit|preventDefault={buscarAmbientesFormacion} action={route('nodos.explorer.busqueda-ambientes', [nodo])}>
                                <div>
                                    <Input id="search-educational-tool" class="block w-full" type="search" bind:value={$formBusquedaAmbientes.searchInputAmbiente} label="Busque la infraestructura por: palabras clave" />
                                </div>
                            </form>
                        </div>

                        <div class="justify-around mt-10 text-center text-sm text-gray-500 grid grid-cols-5">
                            {#each areasConocimiento as areaConocimiento}
                                <a use:inertia href={route('nodos.explorer.busqueda-ambientes', [nodo, 'searchInputAmbiente=' + areaConocimiento.nombre])} class="ml-1 mb-10 underline">
                                    {areaConocimiento.nombre}
                                </a>
                            {/each}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="snap-start h-screen">
            <div class="max-w-7xl mx-auto">
                <div class="pt-[6rem]">
                    <h1 class="text-4xl text-gray-400 text-center">Equipos especializados</h1>

                    <img src="/storage/images/equipos.png" class="mx-auto my-8" alt="" />

                    <p class="text-center mb-8 text-2xl">Realice una búsqueda de herramientas / equipos especializados que se disponen en las instituciones educativas de la red.</p>

                    <div>
                        <div class="max-w-3xl mx-auto">
                            <form class="shadow" on:submit|preventDefault={buscarEquiposFormacion} action={route('nodos.explorer.busqueda-equipos', [nodo])}>
                                <div>
                                    <Input id="search-equipo" class="block w-full" type="search" bind:value={$formBusquedaEquipos.searchInputEquipo} label="Busque herramientas / equipos especializados por: palabras clave" />
                                </div>
                            </form>
                        </div>

                        <div class="justify-around mt-10 text-center text-sm text-gray-500 grid grid-cols-5">
                            {#each areasConocimiento as areaConocimiento}
                                <a use:inertia href={route('nodos.explorer.busqueda-equipos', [nodo, 'searchInputEquipo=' + areaConocimiento.nombre])} class="ml-1 mb-10 underline">
                                    {areaConocimiento.nombre}
                                </a>
                            {/each}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="snap-start h-screen">
            <div class="pt-[6rem]">
                <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                    <div class="text-center mb-8">
                        <h1 class="text-xl md:text-4xl text-gray-400 leading-10">#EventosRREDSI<strong>{nodo.departamento}{currentYear}</strong></h1>
                        <img src="/storage/images/conference.png" class="mx-auto my-12 w-2/5 pt-8" alt="" />

                        <p class="text-gray-800 leading-10">Consulte los eventos <strong /> de las diferentes instituciones educativas, inscriba sus proyectos y divulgue los resultados.</p>
                        <a use:inertia href={route('nodos.explorer.eventos', [nodo])} class="bg-blue-900 p-4 rounded text-white inline-block mt-10">Más información de próximos eventos</a>
                    </div>
                </div>
            </div>
            {#if eventoRredsiDepartamental?.estado}
                <div class="text-left py-8 px-[16.67%] bg-gray-100 shadow" style="background: #f7f7f7 url(/storage/images/dots.png);background-size: cover;background-position: right;background-repeat: no-repeat;">
                    <h1 class="text-2xl md:text-4xl mb-4 text-gray-900 leading-10">
                        {eventoRredsiDepartamental.titulo}
                        {eventoRredsiDepartamental.year}
                    </h1>
                    <p class="mb-10">{eventoRredsiDepartamental.datesForHumans}</p>
                    <a use:inertia href={route('nodos.explorer.eventos.ver-evento-departamental', [nodo.id, eventoRredsiDepartamental.id])} class="inline-block rounded text-gray-500 bg-white p-4">Más información</a>
                </div>
            {:else}
                <div class="text-left py-8 px-[16.67%] bg-gray-100 shadow" style="background: #f7f7f7 url(/storage/images/dots.png);background-size: cover;background-position: right;background-repeat: no-repeat;">
                    <InfoMessage class="" alertMsg={true}>Aún no hay un evento departamental activo.</InfoMessage>
                </div>
            {/if}
            <!-- <div class="grid grid-cols-2">
                {#each nodo.EventosInstitucionEducativa as evento}
                    <div class="h-auto md:h-64 bg-cool-gray-600 p-9 md:p-11" style="background: #475569 url(/storage/images/rectangles.png); background-repeat: no-repeat; background-position: 400px; background-blend-mode: color-burn;">
                        <h1 class="text-2xl md:text-4xl text-gray-300 leading-10">
                            {evento.nombre}
                        </h1>
                        <p class="text-white leading-10">
                            {evento.datesForHumans}
                        </p>
                        <a use:inertia href={route('nodos.explorer.showEvento', [nodo, evento.id])} class="inline-block rounded text-gray-500 bg-white p-4">Más información</a>
                    </div>
                {/each}
            </div> -->
        </section>

        <section class="snap-start h-screen">
            <div class="max-w-7xl mx-auto h-full">
                <div class="flex flex-col h-full items-center justify-center">
                    <h1 class="text-4xl text-gray-400 text-center mb-20 mt-[-2rem]">Instituciones educativas participantes</h1>
                    <div class="grid grid-cols-{nodo.instituciones_educativas.length <= 12 ? nodo.instituciones_educativas.length : 12} gap-2 justify-around">
                        {#each nodo.instituciones_educativas as institucionEducativa}
                            <figure>
                                <img src="/storage/{institucionEducativa.logo}" class="h-16" alt="Logo {institucionEducativa.nombre}" />
                            </figure>
                        {/each}
                    </div>
                </div>
            </div>
        </section>
    </div>
</AuthenticatedLayout>
