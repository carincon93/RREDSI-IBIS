<script context="module">
    import GuestLayout, { title } from '@/Layouts/Guest'
    export const layout = GuestLayout
</script>

<script>
    import { inertia, useForm } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Shared/Input'
    import LoadingButton from '@/Shared/LoadingButton'
    import Checkbox from '@smui/checkbox'
    import FormField from '@smui/form-field'
    import Password from '@/Shared/Password'
    import InfoMessage from '@/Shared/InfoMessage'

    export let status
    export let errors

    $title = 'Iniciar sesión'

    let canResetPassword
    let selection = []
    let sending = false

    let form = useForm({
        email: '',
        password: '',
        remember: false,
    })

    function handleSubmit() {
        $form.post(route('ente-gubernamental'), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
        })
    }
</script>

<svelte:head>
    <title>Ingresar - RREDSI-IBIS</title>
</svelte:head>

{#if status}
    <div class="mb-4 font-medium text-sm text-green-600">
        {status}
    </div>
{/if}

<form on:submit|preventDefault={handleSubmit}>
    <div>
        <Input label={$_('Email')} id="email" type="email" class="mt-1" bind:value={$form.email} error={errors.email} required autocomplete="email" />
    </div>

    <div class="mt-4">
        <Password id="password" class="mt-1 w-full" bind:value={$form.password} error={errors.password} required autocomplete="current-password" />
    </div>

    <div class="block mt-4">
        <FormField>
            <Checkbox bind:checked={$form.remember} value={selection} />
            <span slot="label">{$_('Remember me')}</span>
        </FormField>
    </div>

    <div class="flex items-center justify-between mt-4">
        <a use:inertia href={route('password.request')} class="mr-4 underline text-sm text-gray-600 hover:text-gray-900">
            {$_('Forgot your password?')}
        </a>

        <LoadingButton bind:loading={sending} type="submit">{$_('Login')}</LoadingButton>
    </div>
</form>

<InfoMessage class="mt-20">
    Si aún no tiene cuenta puede crear una diligenciando el siguiente <a use:inertia href={route('register', 'tipoUsuario=rredsi')} class="text-gray-500 underline">formulario</a>
</InfoMessage>
