<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let nodos

    $: $title = 'Crear institución educativa'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        nodo_id: null,
        nombre: '',
        logo: null,
        nit: '',
        direccion: '',
        ciudad: '',
        numero_telefono: '',
        sitio_web: '',
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [33])) {
            $form.post(route('instituciones-educativas.store'), {
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
                    <a use:inertia href={route('instituciones-educativas.index')} class="text-gray-500 hover:text-gray-600"> Instituciones educativas </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la institución educativa</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear una nueva institución educativa.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {nodos} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
