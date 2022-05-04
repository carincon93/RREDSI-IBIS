<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let nodo
    export let departamentos

    $: $title = 'Editar nodo'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        departamento: { value: nodo.departamento, label: departamentos.find((item) => item.value == nodo.departamento)?.label },
        logo: null,
        administrador_id: null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            $form.post(route('nodos.update', [nodo.id]), {
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
                    <a use:inertia href={route('nodos.index')} class="text-gray-500 hover:text-gray-600"> Nodos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del nodo</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el nodo.</p>
            <figure>
                <img class="mx-auto" src={'/storage/' + nodo.logo} alt="Logo {nodo.departamento}" />
            </figure>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} method="put" {departamentos} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
