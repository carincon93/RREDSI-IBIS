<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import ApplicationLogo from '@/Shared/ApplicationLogo'
    import Pagination from '@/Shared/Pagination'
    import InfoMessage from '@/Shared/InfoMessage'
    import NavEmpresarial from './NavEmpresarial'

    export let proyectos

    $: $title = 'Módulo empresarial'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <NavEmpresarial />

    <div class="bg-white my-20 overflow-hidden shadow-xl sm:rounded-lg ml-20">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <ApplicationLogo />
            </div>

            <div class="mt-8 text-2xl">Bienvenido a la aplicación RREDSI!</div>

            <div class="mt-6 text-gray-500">Con la plataforma RREDSI puede buscar proyectos de su interés que se esten desarrollando en los semilleros de investigación de las 2 instituciones educativas de RREDSI nodo(s) Caldas , colaborar en su desarrollo o registrar una idea empresarial y conectarse con jóvenes investigadores de dichas instituciones.</div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        <span>Eventos académicos</span>
                    </div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 mb-2 text-sm text-gray-500">Revise cuales son los próximos eventos que las instituciones educativas van a celebrar. Si tiene proyectos que coincidan con el área de conocimiento del evento por favor participe, de esta manera se contribuye a la investigación académica. Valide la información y por favor haga el proceso de inscripción.</div>
                    <a use:inertia href={route('eventos-academicos.index')} class="text-blue-900">Visualiza los eventos aquí</a>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        <span>Retos e ideas empresariales</span>
                    </div>
                </div>
                <div class="ml-12">
                    <div class="mt-2 mb-2 text-sm text-gray-500">Propone retos e ideas, comunica tus necesidades y problemas y de forma cooperativa otras empresas e investigadores podrán plantear respuesta a tus retos, ideas, problemas y necesidades. También podrás responder a otras empresas que requieran el apoyo para sus ideas y sus retos, explora las opciones:</div>
                    {#if isSuperAdmin || checkPermission(authUser, [31, 32])}
                        <a use:inertia href={route('ideas-empresa.index')} class="text-blue-900">Crear retos e ideas de tu empresa</a>
                        <br />
                        <a use:inertia href={route('ideas-empresa.ideas-retos')} class="text-blue-900">Visualiza retos e ideas de otras empresas</a>
                    {/if}
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="40" viewBox="0 0 38 40" class="w-8 h-8 text-gray-400">
                        <g transform="translate(-1654 -467)">
                            <path d="M406-333.194h8.645V-344H406v10.806Zm0,8.645h8.645v-6.484H406v6.484Zm10.806,0h8.645v-10.806h-8.645v10.806Zm0-19.452v6.484h8.645V-344Z" transform="translate(1660 465) translate(-399.516 350.484)" fill="none" stroke="#9fa6b2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            <text transform="translate(1654 504)" fill="#707070" font-size="11" font-family="SegoeUI, Segoe UI">
                                <tspan x="0" y="0">Proyectos</tspan>
                            </text>
                        </g>
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        <span>Proyectos de investigación e innovación</span>
                    </div>
                </div>
                <div class="ml-12">
                    <div class="mt-2 mb-2 text-sm text-gray-500">Consulta y visualiza los proyectos de investigación e innovación desarrollados por los semilleros y sus investigadores; genera alertas sobre aquellos proyectos que sean de tu interés y asi podrás contactar a los investigadores para generar redes de apropiación del conocimiento en tu empresa articulando a la academia.</div>
                    <a use:inertia href={route('observatorio-empresarial')} class="text-blue-900">Visualiza los proyectos</a>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="38" height="40" viewBox="0 0 38 40" class="w-8 h-8 text-gray-400">
                        <g transform="translate(-1654 -467)">
                            <path d="M8.556,7.444V3m8.889,4.444V3m-10,8.889H18.556M5.222,23H20.778A2.222,2.222,0,0,0,23,20.778V7.444a2.222,2.222,0,0,0-2.222-2.222H5.222A2.222,2.222,0,0,0,3,7.444V20.778A2.222,2.222,0,0,0,5.222,23Z" transform="translate(1660 465)" fill="none" stroke="#9fa6b2" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                            <text transform="translate(1654 504)" fill="#707070" font-size="11" font-family="SegoeUI, Segoe UI">
                                <tspan x="0" y="0">I+D+i</tspan>
                            </text>
                        </g>
                    </svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                        <span>Convocatorias de I+D+i</span>
                    </div>
                </div>
                <div class="ml-12">
                    <div class="mt-2 mb-2 text-sm text-gray-500">Identifica las convocatorias de I+D+i abiertas por las diferentes entidades para la presentación y postulación de proyectos de carácter investigativo y de innovación.</div>
                    {#if isSuperAdmin || checkPermission(authUser, [19, 20])}
                        <a use:inertia href={route('convocatorias.index')} class="text-blue-900">Consulta las convocatorias de I+D+i</a>
                    {/if}
                </div>
            </div>
        </div>
    </div>

    <div class="py-[6rem]">
        <h1 class="text-3xl text-center mb-20">Proyectos registrados</h1>
        <div class="grid grid-cols-{proyectos.data.length <= 3 ? proyectos.data.length : 3} justify-around gap-3">
            {#each proyectos.data as proyecto}
                <a use:inertia href={route('nodos.explorer.busqueda-proyectos.ver-proyecto', [proyecto.facultad.institucion_educativa.nodo_id, proyecto.id])} class="text-white block m-2 shadow-xl">
                    <div class="text-white">
                        <img src="/storage/{proyecto.main_image}" class="w-full h-64 object-cover" alt="" />
                        <div class="bg-gradient-to-r from-blue-700 to-blue-900 p-6 min-h-full">
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

            {#if proyectos.data.length == 0}
                <InfoMessage alertMsg={true} class="w-full mb-20">Sin información registrada.</InfoMessage>
            {/if}
        </div>
        <Pagination links={proyectos.links} />
    </div>
</AuthenticatedLayout>
