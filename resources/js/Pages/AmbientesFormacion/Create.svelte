<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let facultades
    export let disciplinasSubareaConocimiento

    $: $title = 'Crear ambiente de formación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        nombre: '',
        foto: null,
        nombre_responsable: '',
        correo_responsable: '',
        celular_responsable: '',
        tipo: '',
        capacidad_aprox: '',
        descripcion: '',
        facultad_id: null,
        disciplina_subarea_conocimiento_id: null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [11])) {
            $form.post(route('instituciones-educativas.ambientes-formacion.store', institucionEducativa.id), {
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
                    <a use:inertia href={route('instituciones-educativas.ambientes-formacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Ambientes de formación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del ambiente de formación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo ambiente de formación.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {facultades} {disciplinasSubareaConocimiento} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
