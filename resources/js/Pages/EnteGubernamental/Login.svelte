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
        $form.post(route('entegubernamental.loginEnte'), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
        })
    }
</script>

<svelte:head>
    <title>Ingresar - Administracion Gubernamental</title>
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


    <div class="flex items-center justify-between mt-4">
        <LoadingButton bind:loading={sending} type="submit">{$_('Login')}</LoadingButton>
    </div>
</form>

