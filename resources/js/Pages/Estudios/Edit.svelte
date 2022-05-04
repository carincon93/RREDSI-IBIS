<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let estudio

    $: $title = 'Editar estudio'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        institucion_educativa: estudio.institucion_educativa,
        programa_academico: estudio.programa_academico,
        graduado: estudio.graduado,
        year: estudio.year,
    })

    function submit() {
        $form.put(route('estudios.update', [estudio.id]), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
            preserveScroll: true,
        })
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('estudios.index')} class="text-gray-500 hover:text-gray-600"> Mis estudios </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del estudio</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el estudio.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
