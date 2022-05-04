<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let facultades

    let categoriasMinciencias = [
        { value: 'A', label: 'A' },
        { value: 'A1', label: 'A1' },
        { value: 'B', label: 'B' },
        { value: 'C', label: 'C' },
        { value: 'Reconocido', label: 'Reconocido' },
        { value: 'No reconocido', label: 'No reconocido' },
    ]

    $: $title = 'Crear grupo de investigación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        facultad_id: null,
        nombre: '',
        email: '',
        lider: '',
        gruplac: '',
        codigo_minciencias: '',
        categoria_minciencias: '',
        sitio_web: '',
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [3])) {
            $form.post(route('instituciones-educativas.grupos-investigacion.store', institucionEducativa.id), {
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
                    <a use:inertia href={route('instituciones-educativas.grupos-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Grupos de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del grupo de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo grupo de investigación.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {categoriasMinciencias} {facultades} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
