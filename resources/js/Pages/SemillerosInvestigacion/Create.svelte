<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let gruposInvestigacion
    export let disciplinasSubareaConocimiento
    export let programasAcademicos
    export let lineasInvestigacion

    $: $title = 'Crear semillero de investigación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        nombre: '',
        nombre_mentor: '',
        correo_mentor: '',
        celular_mentor: '',
        objetivo_general: '',
        mision: '',
        vision: '',
        proyeccion_regional: '',
        estrategia_produccion_conocimiento: '',
        tematica_investigacion: '',
        fecha_creacion: '',
        grupo_investigacion_id: null,
        programa_academico_id: null,
        disciplina_subarea_conocimiento_id: null,
        linea_investigacion_id: null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [7])) {
            $form.post(route('instituciones-educativas.semilleros-investigacion.store', institucionEducativa.id), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
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
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del semillero de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo semillero de investigación.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {gruposInvestigacion} {programasAcademicos} {lineasInvestigacion} {disciplinasSubareaConocimiento} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
