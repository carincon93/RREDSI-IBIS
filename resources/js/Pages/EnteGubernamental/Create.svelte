<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'
    import InfoMessage from '@/Shared/InfoMessage'
    import Button from '@/Shared/Button'

    export let errors
    /*
    export let institucionEducativa
    export let institucionesEducativas
    export let roles
    export let semilleroInvestigacion
    */
    export let municipios
    export let delegados

    /*
    let tiposDocumento = [
        { value: 'cc', label: 'Cédula de ciudadanía' },
        { value: 'ti', label: 'Tarjeta de identidad' },
        { value: 'ce', label: 'Cédula de extranjería' },
    ]
    */

    $: $title = 'Crear usuario'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        name: '',
        direction:'',
        phone: '',
        nit:'',
        city:'',
        id_delegado_entidad:''
    })

    function submit() {

        if (isSuperAdmin || checkPermission(authUser, [17, 23])) {
            $form.post(route('ente-gubernamental.store'), {
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
                    <a use:inertia href={route('users.index', /* ['institucionEducativaId=' + institucionEducativa?.id] */)} class="text-gray-500 hover:text-gray-600"> Usuarios </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del usuario</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo usuario.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">


            <Form {errors} {authUser} {submit} {municipios} {delegados} method="create" {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
