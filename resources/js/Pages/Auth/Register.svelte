<script>
    import GuestLayout from '@/Layouts/Guest'
    import { useForm } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'
    import { Inertia } from '@inertiajs/inertia'

    import Form from '../Users/Form'
    import InfoMessage from '@/Shared/InfoMessage'
    import Button from '@/Shared/Button'

    export let errors
    export let institucionesEducativas
    export let tipoUsuario

    let tiposDocumento = [
        { value: 'cc', label: 'Cédula de ciudadanía' },
        { value: 'ti', label: 'Tarjeta de identidad' },
        { value: 'ce', label: 'Cédula de extranjería' },
    ]

    let sending = false

    let form = useForm({
        institucion_educativa_id: null,
        name: '',
        email: '',
        password: null,
        password_confirmation: null,
        tipo_documento: '',
        numero_documento: '',
        numero_celular: '',
        intereses: '',
        cv: null,
        perfil: '',
        cvlac: '',
        autorizacion_tratamiento_datos: true,
        nit: '',
        nombre_empresa: '',
        direccion_empresa: '',
        numero_celular_empresa: '',
        email_empresa: '',
        tipo_usuario: tipoUsuario,
    })

    function submitEstudiante() {
        if ($form.autorizacion_tratamiento_datos) {
            $form.post(route('register'))
        }
    }

    $: if (tipoUsuario) {
        $form.tipo_usuario = tipoUsuario
    }
</script>

<GuestLayout class="mt-20">
    <InfoMessage>
        Por favor seleccione el tipo de usuario:
        <div class="grid grid-cols-2 gap-2 mt-4">
            <Button on:click={() => Inertia.visit(route('register', 'tipoUsuario=rredsi'))} variant={tipoUsuario == 'rredsi' ? 'raised' : 'outlined'} class="p-2 w-full">Estudiante</Button>

            <Button on:click={() => Inertia.visit(route('register', 'tipoUsuario=empresario'))} variant={tipoUsuario == 'empresario' ? 'raised' : 'outlined'} class="p-2 w-full">Empresario</Button>
        </div>
    </InfoMessage>
    <div>
        <Form {errors} authUser={null} submit={submitEstudiante} {tiposDocumento} roles={null} method="register" bind:tipoUsuario {institucionesEducativas} {sending} {form} />
    </div>
</GuestLayout>
