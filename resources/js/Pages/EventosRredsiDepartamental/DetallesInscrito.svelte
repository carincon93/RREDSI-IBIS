<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'

    import { page, inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let nodo
    export let eventoRredsiDepartamental
    export let inscrito

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
                    <a use:inertia href={route('nodos.eventos-rredsi-departamental.inscritos', [nodo.id, eventoRredsiDepartamental.id])} class="text-gray-500 hover:text-gray-600"> Inscritos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de las personas inscritas</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información de las personas inscritas.</p>
            {#if isSuperAdmin || checkPermission(authUser, [21])}
                <a use:inertia href={route('nodos.eventos-rredsi-departamental.inscritos.editar', [nodo.id, eventoRredsiDepartamental.id, inscrito.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium mt-4">Institución educativa</p>
                <div class="flex items-center mt-2">
                    <figure class="mr-2">
                        <img src="/storage/{inscrito.semillero_investigacion.grupo_investigacion.facultad.institucion_educativa.logo}" class="h-8" alt="Logo {inscrito.semillero_investigacion.grupo_investigacion.facultad.institucion_educativa.nombre}" />
                    </figure>
                    <p>{inscrito.semillero_investigacion.grupo_investigacion.facultad.institucion_educativa.nombre}</p>
                </div>
            </div>

            <div class="py-8">
                <p class="font-medium">Primer ponente</p>
                <p class="whitespace-pre-line">{inscrito.primer_ponente.name}</p>
                <p class="whitespace-pre-line">Tipo de documento: {inscrito.primer_ponente.tipo_documento}</p>
                <p class="whitespace-pre-line">Número de documento: {inscrito.primer_ponente.numero_documento}</p>
                <p class="whitespace-pre-line">Número de celular: {inscrito.primer_ponente.numero_celular}</p>
                <p class="whitespace-pre-line">Correo electrónico: {inscrito.primer_ponente.email}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Programa académico del primer ponente</p>
                <p class="whitespace-pre-line">{inscrito.programa_academico_primer_ponente.nombre}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Segundo ponente</p>
                <p class="whitespace-pre-line">{inscrito.segundo_ponente.name}</p>
                <p class="whitespace-pre-line">Tipo de documento: {inscrito.segundo_ponente.tipo_documento}</p>
                <p class="whitespace-pre-line">Número de documento: {inscrito.segundo_ponente.numero_documento}</p>
                <p class="whitespace-pre-line">Número de celular: {inscrito.segundo_ponente.numero_celular}</p>
                <p class="whitespace-pre-line">Correo electrónico: {inscrito.segundo_ponente.email}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Programa académico del segundo ponente</p>
                <p class="whitespace-pre-line">{inscrito.programa_academico_segundo_ponente.nombre}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Semillero en que participan los estudiantes</p>
                <p class="whitespace-pre-line">{inscrito.semillero_investigacion.nombre}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Tipo de presentación</p>
                <p class="whitespace-pre-line">{inscrito.tipo_presentacion}</p>
            </div>

            {#if inscrito.modalidad_proyecto}
                <div class="py-8">
                    <p class="font-medium">Modalidad del proyecto</p>
                    <p class="whitespace-pre-line">{inscrito.modalidad_proyecto}</p>
                </div>
            {/if}

            <div class="py-8">
                <p class="font-medium">Área de conocimiento en la que esta enmarcada el proyecto</p>
                <p class="whitespace-pre-line">{inscrito.area_conocimiento}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Carta de aval del tutor</p>
                <a href={'/storage/' + inscrito.carta_aval} class="underline" target="_blank">Ver carta de aval del tutor</a>
            </div>

            {#if inscrito.carta_poster}
                <div class="py-8">
                    <p class="font-medium">Documento del Póster para la evaluación de la inscripción</p>
                    <a href={'/storage/' + inscrito.carta_poster} class="underline" target="_blank">Ver documento del póster para la evaluación de la inscripción</a>
                </div>
            {/if}

            {#if inscrito.documento_proyecto_finalizado}
                <div class="py-8">
                    <p class="font-medium">Documento de proyecto en curso/finalizado</p>
                    <a href={'/storage/' + inscrito.documento_proyecto_finalizado} class="underline" target="_blank">Ver documento de proyecto en curso/finalizado</a>
                </div>
            {/if}

            <div class="py-8">
                <p class="font-medium">Autorización de publicación de memorias en la página de RREDSI</p>
                <p>{inscrito.autorizacion_memorias ? 'Si' : 'No'}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Autoriza de tratamiento de datos</p>
                <p>{inscrito.autorizacion_tratamiento_datos ? 'Si' : 'No'}</p>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
