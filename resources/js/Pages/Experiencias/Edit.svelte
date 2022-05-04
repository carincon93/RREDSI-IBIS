<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'
    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let errors
    export let experiencia

    $: $title = 'Editar experiencia'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        titulo: experiencia.titulo,
        descripcion: experiencia.descripcion,
        image: null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [29])) {
            $form.post(route('experiencias.update', [experiencia.id]), {
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
                    <a use:inertia href={route('experiencias.index')} class="text-gray-500 hover:text-gray-600"> Experiencias </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <NavEmpresarial />

    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la experiencia</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar la experiencia.</p>
            <figure class="mt-10 mb-10">
                <span class="font-medium">Imagen</span>
                <img class="mx-auto" src={'/storage/' + experiencia.image} alt="Foto {experiencia.image}" />
            </figure>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {sending} method="put" {form} />
        </div>
    </div>
</AuthenticatedLayout>
