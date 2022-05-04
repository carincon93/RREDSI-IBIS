<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { Inertia } from '@inertiajs/inertia'

    import InfoMessage from '@/Shared/InfoMessage'
    import Dialog from '@/Shared/Dialog'
    import Button from '@/Shared/Button'

    let dialogOpen = false

    export let proyecto

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user

    let interesActivo
    $: interesActivo = proyecto.proyectos_empresa?.find((item) => item.empresa_id == authUser.empresa_id)
</script>

<div class="mb-20">
    <div class="grid grid-cols-2 min-h-[32.6rem] relative">
        <div class="flex flex-col justify-center">
            <p class="mb-2 text-xs">Fechas de desarrollo del proyecto {proyecto.datesForHumans}</p>

            <h1 class="text-3xl text-left font-extrabold pr-8">
                <span class="block text-blue-900 xl:inline">
                    {proyecto.titulo}
                </span>
            </h1>
        </div>
        <figure class="absolute right-[-14rem] top-[-4rem]" style="clip-path: polygon(21% 0%, 100% 0%, 100% 100%, 0% 100%);">
            <img src={'/storage/' + proyecto.main_image} alt="" style="max-width: 1000px;height: 667px;" class="object-cover" />
        </figure>
    </div>

    <hr class="block my-20" />

    <p class="font-medium">Facultad</p>
    <p class="mt-2">{proyecto.facultad.nombre}</p>

    <p class="font-medium mt-4">Institución educativa</p>
    <div class="flex items-center mt-2">
        <figure class="mr-2">
            <img src="/storage/{proyecto.facultad.institucion_educativa.logo}" class="h-8" alt="Logo {proyecto.facultad.institucion_educativa.nombre}" />
        </figure>
        <p>{proyecto.facultad.institucion_educativa.nombre}</p>
    </div>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Resumen</h1>
    <p class="whitespace-pre-line text-justify">{proyecto.resumen}</p>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Palabras clave</h1>
    <div class="mt-4 text-gray-400">
        {#each proyecto.palabras_clave_format as palabra}
            <a use:inertia href={route('nodos.explorer.busqueda-proyectos', [proyecto.facultad.institucion_educativa.nodo_id, 'searchInputProyecto=' + palabra.value])} class="ml-1 underline">{palabra.value}</a>
        {/each}
    </div>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Objetivo general</h1>
    <p class="whitespace-pre-line text-justify">{proyecto.objetivo_general}</p>

    <hr class="block my-20" />

    <div class="grid grid-cols-2 gap-3 mt-20">
        <div>
            <h1 class="font-medium">Ficha técnica del proyecto</h1>
        </div>

        <div class="bg-white rounded shadow p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Tipo de proyecto</p>
                <p>{proyecto.tipo_proyecto.tipo}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Archivo PDF</p>
                <a href={'/storage/' + proyecto.file} target="_blank" class="underline">Ver archivo PDF del proyecto</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Semilleros de investigación asociados</p>
                <ul>
                    {#each proyecto.semilleros_investigacion as semilleroInvestigacion}
                        <li>{semilleroInvestigacion.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Líneas de investigación asociadas</p>
                <ul>
                    {#each proyecto.lineas_investigacion as lineaInvestigacion}
                        <li>{lineaInvestigacion.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Programas académicos asociados</p>
                <ul>
                    {#each proyecto.programas_academicos as programaAcademico}
                        <li>{programaAcademico.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Disciplinas asociadas</p>
                <ul>
                    {#each proyecto.disciplinas_subarea_conocimiento as disciplina}
                        <li>{disciplina.nombre}</li>
                    {/each}
                </ul>
            </div>
        </div>
    </div>

    {#if proyecto.requerimientos_roles_format?.length > 0}
        <hr class="block my-20" />

        <div>
            <h1 class="text-center text-3xl font-medium">El proyecto requiere de los siguientes perfiles de jóvenes investigadores</h1>
            <figure class="flex items-center justify-center my-14">
                <img src="/storage/images/connect-estudiantes.png" class="h-52" alt="" />
            </figure>

            <div class="py-8">
                <p class="font-medium">Perfiles requeridos</p>
                <ul>
                    {#each proyecto.requerimientos_roles_format as rol}
                        <li>{rol.value}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Descripción de los perfiles requeridos (actividades a realizar)</p>
                <p class="whitespace-pre-line text-justify">{proyecto.descripcion_requerimiento_rol}</p>
            </div>
        </div>
    {/if}

    {#if proyecto.requerimientos_equipos_format?.length > 0}
        <hr class="block my-20" />

        <div>
            <h1 class="text-center text-3xl font-medium">El proyecto requiere de los siguientes equipos especializados</h1>
            <figure class="flex items-center justify-center my-14">
                <img src="/storage/images/infraestructura.png" class="h-52" alt="" />
            </figure>

            <div class="py-8">
                <p class="font-medium">Equipos requeridos</p>
                <ul>
                    {#each proyecto.requerimientos_equipos_format as equipo}
                        <li>{equipo.value}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Descripción de los equipos requeridos (¿Que se requiere y para qué?)</p>
                <p class="whitespace-pre-line text-justify">{proyecto.requerimientos_equipos_descripcion}</p>
            </div>
        </div>
    {/if}

    {#if authUser.empresa_id}
        <button
            type="button"
            on:click={() =>
                Inertia.visit(route('proyectos-empresa.store'), {
                    method: 'post',
                    data: {
                        proyecto_id: proyecto.id,
                    },
                })}
            class="fixed right-8 bottom-4 bg-blue-900 text-white p-4 rounded-full shadow flex"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <p class="ml-2">{interesActivo ? 'Quitar' : 'Generar'} alerta de interés</p>
        </button>
    {:else}
        <button type="button" on:click={() => (dialogOpen = true)} class="fixed right-8 bottom-4 bg-blue-900 text-white p-4 rounded-full shadow flex">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
            </svg>
            <p class="ml-2">Quiero participar</p>
        </button>
    {/if}
</div>

<Dialog bind:open={dialogOpen}>
    <div slot="title" class="flex items-center mb-8">
        <InfoMessage>Por favor póngase en contacto con los siguientes participantes y/o mentores de los semilleros de investigación asociados al proyecto</InfoMessage>
    </div>
    <div slot="content">
        <h1 class="font-black mb-4">Mentores de los semilleros de investigación</h1>

        <ul>
            {#each proyecto.semilleros_investigacion as semilleroInvestigacion}
                <li class="mb-4">
                    <div>
                        <span>Semillero de investigación: </span>{semilleroInvestigacion.nombre}
                        <br />
                        <span>Mentor(a): </span>
                        {semilleroInvestigacion.nombre_mentor}
                        <br />
                        <span>Correo electrónico: </span>
                        <a href="mailto:{semilleroInvestigacion.correo_mentor}" class="underline">{semilleroInvestigacion.correo_mentor}</a>
                    </div>
                </li>
            {/each}
        </ul>

        <hr class="block my-4" />

        <h1 class="font-black mb-4">Participantes</h1>
        <ul>
            {#each proyecto.autores as autor}
                <li class="mb-4">
                    <div>
                        <span>Nombre del participante: </span>{autor.name}
                        <br />
                        <span class="font-medium">Correo electrónico: </span>
                        <a href="mailto:{autor.email}" class="underline">{autor.email}</a>
                    </div>
                </li>
            {/each}
        </ul>
    </div>
    <div slot="actions">
        <div class="p-4">
            <Button on:click={(event) => (dialogOpen = false)} variant={null}>Salir</Button>
        </div>
    </div>
</Dialog>
