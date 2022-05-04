<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let facultades
    export let programaAcademico
    export let institucionEducativa

    let modalidades = [
        { value: 'Presencial', label: 'Presencial' },
        { value: 'Virtual', label: 'Virtual' },
        { value: 'A distancia', label: 'A distancia' },
    ]

    let jornadas = [
        { value: 'Mixta', label: 'Mixta' },
        { value: 'Nocturna', label: 'Nocturna' },
    ]

    let nivelesAcademicos = [
        { value: 'Técnico profesional', label: 'Técnico profesional' },
        { value: 'Tecnólogo', label: 'Tecnólogo' },
        { value: 'Profesional', label: 'Profesional' },
        { value: 'Especialización técnica profesional', label: 'Especialización técnica profesional' },
        { value: 'Especialización tecnológica', label: 'Especialización tecnológica' },
        { value: 'Maestría', label: 'Maestría' },
        { value: 'Doctorado', label: 'Doctorado' },
    ]

    $: $title = 'Editar programa académico'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        facultad_id: { value: programaAcademico.facultad_id, label: facultades.find((item) => item.value == programaAcademico.facultad_id)?.label },
        nombre: programaAcademico.nombre,
        nivel_academico: { value: programaAcademico.nivel_academico, label: nivelesAcademicos.find((item) => item.value == programaAcademico.nivel_academico)?.label },
        modalidad: { value: programaAcademico.modalidad, label: modalidades.find((item) => item.value == programaAcademico.modalidad)?.label },
        jornada: { value: programaAcademico.jornada, label: jornadas.find((item) => item.value == programaAcademico.jornada)?.label },
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [9])) {
            $form.put(route('instituciones-educativas.programas-academicos.update', [institucionEducativa.id, programaAcademico.id]), {
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
                    <a use:inertia href={route('instituciones-educativas.programas-academicos.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Programas académicos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del programa académico</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el programa académico.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {facultades} {modalidades} {jornadas} {nivelesAcademicos} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
