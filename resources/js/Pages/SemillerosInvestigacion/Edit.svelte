<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let semilleroInvestigacion
    export let disciplinasSubareaConocimiento
    export let gruposInvestigacion
    export let disciplinasRelacionadas
    export let programasAcademicos
    export let programasAcademicosRelacionados
    export let lineasInvestigacion
    export let lineasInvestigacionRelacionadas

    $: $title = 'Editar semillero de investigación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        nombre: semilleroInvestigacion.nombre,
        objetivo_general: semilleroInvestigacion.objetivo_general,
        mision: semilleroInvestigacion.mision,
        vision: semilleroInvestigacion.vision,
        logros: semilleroInvestigacion.logros,
        nombre_mentor: semilleroInvestigacion.nombre_mentor,
        correo_mentor: semilleroInvestigacion.correo_mentor,
        celular_mentor: semilleroInvestigacion.celular_mentor,
        proyeccion_regional: semilleroInvestigacion.proyeccion_regional,
        estrategia_produccion_conocimiento: semilleroInvestigacion.estrategia_produccion_conocimiento,
        tematica_investigacion: semilleroInvestigacion.tematica_investigacion,
        fecha_creacion: semilleroInvestigacion.fecha_creacion,
        grupo_investigacion_id: { value: semilleroInvestigacion.grupo_investigacion_id, label: gruposInvestigacion.find((item) => item.value == semilleroInvestigacion.grupo_investigacion_id)?.label },
        programa_academico_id: programasAcademicosRelacionados.length > 0 ? programasAcademicosRelacionados : null,
        disciplina_subarea_conocimiento_id: disciplinasRelacionadas.length > 0 ? disciplinasRelacionadas : null,
        linea_investigacion_id: lineasInvestigacionRelacionadas.length > 0 ? lineasInvestigacionRelacionadas : null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [7])) {
            $form.put(route('instituciones-educativas.semilleros-investigacion.update', [institucionEducativa.id, semilleroInvestigacion.id]), {
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
                    <a use:inertia href={route('instituciones-educativas.semilleros-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Semilleros de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del semillero de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el semillero de investigación.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {gruposInvestigacion} {programasAcademicos} {lineasInvestigacion} {disciplinasSubareaConocimiento} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
