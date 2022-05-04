<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import FormRegistroEventoDepartamental from './FormRegistroEventoDepartamental'

    export let errors
    export let nodo
    export let eventoRredsiDepartamental
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

    $: $title = 'Registro ' + eventoRredsiDepartamental.titulo

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        primer_ponente_id: null,
        segundo_ponente_id: null,
        programa_academico_primer_ponente_id: null,
        programa_academico_segundo_ponente_id: null,
        proyecto_id: null,
        semillero_investigacion_id: null,
        tipo_presentacion: null,
        modalidad_proyecto: null,
        carta_aval: null,
        carta_poster: null,
        documento_proyecto_finalizado: null,
        autorizacion_memorias: '',
        autorizacion_tratamiento_datos: '',
        area_conocimiento: '',
    })

    function submit() {
        $form.post(route('nodos.eventos-rredsi-departamental.registrarse', [nodo.id, eventoRredsiDepartamental.id]), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
        })
    }
</script>

<AuthenticatedLayout>
    <h1 class="mt-40 text-3xl font-medium text-center">Registro al {eventoRredsiDepartamental.titulo}</h1>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información requerida</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para hacer el registro en el evento.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <FormRegistroEventoDepartamental {errors} {submit} {form} {sending} {estudiantes} {programasAcademicos} {semillerosInvestigacion} {areasConocimiento} {tiposPresentacion} {modalidadesProyecto} />
        </div>
    </div>
</AuthenticatedLayout>
