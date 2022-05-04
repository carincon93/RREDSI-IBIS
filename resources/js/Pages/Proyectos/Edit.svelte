<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let proyecto
    export let facultades
    export let users
    export let tiposProyecto
    export let semillerosInvestigacion
    export let lineasInvestigacion
    export let disciplinasSubareaConocimiento
    export let programasAcademicos
    export let disciplinasRelacionadas
    export let lineasInvestigacionRelacionadas
    export let programasAcademicosRelacionados
    export let semillerosInvestigacionRelacionados
    export let usersRelacionados

    $: $title = 'Editar proyecto'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        titulo: proyecto.titulo,
        fecha_inicio: proyecto.fecha_inicio,
        fecha_finalizacion: proyecto.fecha_finalizacion,
        resumen: proyecto.resumen,
        palabras_clave: proyecto.palabras_clave,
        file: null,
        objetivo_general: proyecto.objetivo_general,
        privado: proyecto.privado,
        descripcion_requerimiento_rol: proyecto.descripcion_requerimiento_rol,
        requerimientos_roles: proyecto.requerimientos_roles,
        requerimientos_equipos_descripcion: proyecto.requerimientos_equipos_descripcion,
        requerimientos_equipos: proyecto.requerimientos_equipos,
        main_image: null,
        tipo_proyecto_id: { value: proyecto.tipo_proyecto_id, label: tiposProyecto.find((item) => item.value == proyecto.tipo_proyecto_id)?.label },
        semillero_investigacion_id: semillerosInvestigacionRelacionados.length > 0 ? semillerosInvestigacionRelacionados : null,
        linea_investigacion_id: lineasInvestigacionRelacionadas.length > 0 ? lineasInvestigacionRelacionadas : null,
        programa_academico_id: programasAcademicosRelacionados.length > 0 ? programasAcademicosRelacionados : null,
        facultad_id: { value: proyecto.facultad_id, label: facultades.find((item) => item.value == proyecto.facultad_id)?.label },
        disciplina_subarea_conocimiento_id: disciplinasRelacionadas.length > 0 ? disciplinasRelacionadas : null,
        user_id: usersRelacionados.length > 0 ? usersRelacionados : null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [13])) {
            $form.post(route('instituciones-educativas.proyectos.update', [institucionEducativa.id, proyecto.id]), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
                preserveScroll: true,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('instituciones-educativas.proyectos.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Proyectos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del proyecto</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el proyecto.</p>
            <figure class="mt-10 mb-10">
                <span class="font-medium">Imagen principal</span>
                <img class="mx-auto" src={'/storage/' + proyecto.main_image} alt="Imagen principal {proyecto.titulo}" />
            </figure>
            <a href={'/storage/' + proyecto.file} class="underline" target="_blank">Visualizar archivo pdf</a>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} method="put" {facultades} {users} {tiposProyecto} {semillerosInvestigacion} {lineasInvestigacion} {disciplinasSubareaConocimiento} {programasAcademicos} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
