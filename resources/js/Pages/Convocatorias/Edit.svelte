<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'
    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let errors
    export let convocatoria

    $: $title = 'Editar convocatoria'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        nombre: convocatoria.nombre,
        entidad: convocatoria.entidad,
        detalles: convocatoria.detalles,
        image: null,
        link_mas_informacion: convocatoria.link_mas_informacion,
        fecha_inicio: convocatoria.fecha_inicio,
        fecha_finalizacion: convocatoria.fecha_finalizacion,
    })

    function submit() {
        if (isSuperAdmin || (authUser.id == convocatoria.autor_id && checkPermission(authUser, [19]))) {
            $form.post(route('convocatorias.update', [convocatoria.id]), {
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
                    <a use:inertia href={route('convocatorias.index')} class="text-gray-500 hover:text-gray-600"> Convocatorias </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    {#if authUser.empresa_id}
        <NavEmpresarial />
    {/if}

    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la convocatoria</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar la convocatoria.</p>
            {#if convocatoria.image}
                <figure class="mt-10 mb-10">
                    <span class="font-medium">Imagen</span>
                    <img class="mx-auto" src={'/storage/' + convocatoria.image} alt="Foto {convocatoria.image}" />
                </figure>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {sending} method="put" {form} />
        </div>
    </div>
</AuthenticatedLayout>
