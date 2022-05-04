<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let nodo
    export let institucionesEducativas

    $: $title = 'Crear evento'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        titulo: '',
        areas_conocimiento: null,
        institucion_educativa_id: null,
        fecha_inicio: '',
        fecha_finalizacion: '',
        afiche: '',
        objetivos: '',
        cronograma: '',
        formato_guia_ponencia: null,
        carta_aval_ponencia: null,
        plantilla_presentacion_ponencia: null,
        formato_guia_poster: null,
        carta_aval_poster: null,
        plantilla_presentacion_poster: null,
        introduccion: '',
        estado: false,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [21])) {
            $form.post(route('nodos.eventos-rredsi-departamental.store', [nodo.id]), {
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
                    <a use:inertia href={route('nodos.show', [nodo.id])} class="text-gray-500 hover:text-gray-600"> Nodo {nodo.departamento} </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del evento</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo evento.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {institucionesEducativas} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
