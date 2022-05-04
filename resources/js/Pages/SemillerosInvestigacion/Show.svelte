<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let institucionEducativa
    export let semilleroInvestigacion

    $: $title = 'Detalles de la ll semillero investigación'

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
                    <a use:inertia href={route('instituciones-educativas.semilleros-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Semilleros de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <h1 class="mt-20 text-3xl font-medium text-center">{semilleroInvestigacion.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del semillero de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información del semillero de investigación.</p>
            {#if isSuperAdmin || checkPermission(authUser, [7])}
                <a use:inertia href={route('instituciones-educativas.semilleros-investigacion.edit', [institucionEducativa.id, semilleroInvestigacion.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Nombre del mentor</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.nombre_mentor}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Correo electrónico del mentor</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.correo_mentor}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Celular del mentor</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.celular_mentor}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Objetivo general</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.objetivo_general}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Misión</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.mision}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Visión</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.vision}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Fecha de creación</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.fecha_creacion}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Proyección regional</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.proyeccion_regional}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Estrategia de producción de conocimiento regional</p>
                <p class="whitespace-pre-line">{semilleroInvestigacion.estrategia_produccion_conocimiento}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Temáticas de investigación</p>
                <ul>
                    {#each semilleroInvestigacion.tematica_investigacion as tematica}
                        <li>{tematica.value}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Líneas de investigación asociadas</p>
                <ul>
                    {#each semilleroInvestigacion.lineas_investigacion as lineInvestigacion}
                        <li>{lineInvestigacion.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Programas académicos asociados</p>
                <ul>
                    {#each semilleroInvestigacion.programas_academicos as programaAcademico}
                        <li>{programaAcademico.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Disciplinas asociadas</p>
                <ul>
                    {#each semilleroInvestigacion.disciplinas_subarea_conocimiento as disciplina}
                        <li>{disciplina.nombre}</li>
                    {/each}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Grupo de investigación</p>
                <p>{semilleroInvestigacion.grupo_investigacion.nombre}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
