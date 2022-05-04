<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'
    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let errors
    export let ideaEmpresa

    let tiposIdea = [
        { value: 'reto', label: 'reto' },
        { value: 'idea', label: 'idea' },
        { value: 'necesidad', label: 'necesidad' },
        { value: 'problematica', label: 'problematica' },
    ]

    let condiciones = [
        { value: 'abierta', label: 'abierta' },
        { value: 'sin respuesta', label: 'sin respuesta' },
        { value: 'atendida', label: 'atendida' },
        { value: 'resuelta', label: 'resuelta' },
    ]

    $: $title = 'Editar idea'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        nombre: ideaEmpresa.nombre,
        descripcion: ideaEmpresa.descripcion,
        tipo: { value: ideaEmpresa.tipo, label: tiposIdea.find((item) => item.value == ideaEmpresa.tipo)?.label },
        tiene_equipos: ideaEmpresa.tiene_equipos,
        equipos: ideaEmpresa.equipos,
        tiene_recursos: ideaEmpresa.tiene_recursos,
        recursos: ideaEmpresa.recursos,
        condicion: { value: ideaEmpresa.condicion, label: condiciones.find((item) => item.value == ideaEmpresa.condicion)?.label },
        es_publica: ideaEmpresa.es_publica,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [31])) {
            $form.put(route('ideas-empresa.update', [ideaEmpresa.id]), {
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
                    <a use:inertia href={route('ideas-empresa.index')} class="text-gray-500 hover:text-gray-600"> Ideas </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <NavEmpresarial />

    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la idea</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar la idea.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {tiposIdea} {condiciones} {sending} method="put" {form} />
        </div>
    </div>
</AuthenticatedLayout>
