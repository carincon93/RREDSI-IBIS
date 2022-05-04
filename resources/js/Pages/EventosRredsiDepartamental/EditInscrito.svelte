<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from '../Explorer/Eventos/FormRegistroEventoDepartamental'

    export let errors
    export let nodo
    export let eventoRredsiDepartamental
    export let proyectoEventoDepartamental
    export let estudiantes
    export let programasAcademicos
    export let semillerosInvestigacion
    export let areasConocimiento

    let tiposPresentacion = [
        { value: 'póster', label: 'póster' },
        { value: 'ponencia', label: 'ponencia' },
    ]

    let modalidadesProyecto = [
        { value: 'proyecto finalizado', label: 'proyecto finalizado' },
        { value: 'proyecto en curso', label: 'proyecto en curso' },
    ]

    $: $title = 'Editar evento'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        primer_ponente_id: { value: proyectoEventoDepartamental.primer_ponente_id, label: estudiantes.find((item) => item.value == proyectoEventoDepartamental.primer_ponente_id)?.label },
        segundo_ponente_id: { value: proyectoEventoDepartamental.segundo_ponente_id, label: estudiantes.find((item) => item.value == proyectoEventoDepartamental.segundo_ponente_id)?.label },
        programa_academico_primer_ponente_id: { value: proyectoEventoDepartamental.programa_academico_primer_ponente_id, label: programasAcademicos.find((item) => item.value == proyectoEventoDepartamental.programa_academico_primer_ponente_id)?.label },
        programa_academico_segundo_ponente_id: { value: proyectoEventoDepartamental.programa_academico_segundo_ponente_id, label: programasAcademicos.find((item) => item.value == proyectoEventoDepartamental.programa_academico_segundo_ponente_id)?.label },
        semillero_investigacion_id: { value: proyectoEventoDepartamental.semillero_investigacion_id, label: semillerosInvestigacion.find((item) => item.value == proyectoEventoDepartamental.semillero_investigacion_id)?.label },
        tipo_presentacion: { value: proyectoEventoDepartamental.tipo_presentacion, label: tiposPresentacion.find((item) => item.value == proyectoEventoDepartamental.tipo_presentacion)?.label },
        modalidad_proyecto: { value: proyectoEventoDepartamental.modalidad_proyecto, label: modalidadesProyecto.find((item) => item.value == proyectoEventoDepartamental.modalidad_proyecto)?.label },
        carta_aval: null,
        carta_poster: null,
        documento_proyecto_finalizado: null,
        autorizacion_memorias: proyectoEventoDepartamental.autorizacion_memorias,
        autorizacion_tratamiento_datos: proyectoEventoDepartamental.autorizacion_tratamiento_datos,
        area_conocimiento: { value: proyectoEventoDepartamental.area_conocimiento, label: areasConocimiento.find((item) => item.value == proyectoEventoDepartamental.area_conocimiento)?.label },
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            $form.post(route('nodos.eventos-rredsi-departamental.inscritos.actualizar-registro', [nodo.id, eventoRredsiDepartamental.id, proyectoEventoDepartamental.id]), {
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
                    <a use:inertia href={route('nodos.eventos-rredsi-departamental.inscritos', [nodo.id, eventoRredsiDepartamental.id])} class="text-gray-500 hover:text-gray-600"> Inscritos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del evento</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el evento.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {submit} {form} {sending} {estudiantes} {programasAcademicos} {semillerosInvestigacion} method="put" {proyectoEventoDepartamental} {eventoRredsiDepartamental} {areasConocimiento} {tiposPresentacion} {modalidadesProyecto} />
        </div>
    </div>
</AuthenticatedLayout>
