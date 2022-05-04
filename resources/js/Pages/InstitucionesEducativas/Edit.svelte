<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let nodos

    $: $title = 'Editar institución educativa'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        nombre: institucionEducativa.nombre,
        logo: null,
        nit: institucionEducativa.nit,
        direccion: institucionEducativa.direccion,
        ciudad: institucionEducativa.ciudad,
        numero_telefono: institucionEducativa.numero_telefono,
        sitio_web: institucionEducativa.sitio_web,
        nodo_id: {
            value: institucionEducativa.nodo_id,
            label: nodos.find((item) => item.value == institucionEducativa.nodo_id)?.label,
        },
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [33])) {
            $form.post(route('instituciones-educativas.update', institucionEducativa.id), {
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
                    <a use:inertia href={route('instituciones-educativas.index')} class="text-gray-500 hover:text-gray-600"> Instituciones educativas </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la institución educativa</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar la institución educativa.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} method="put" {institucionEducativa} {nodos} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
