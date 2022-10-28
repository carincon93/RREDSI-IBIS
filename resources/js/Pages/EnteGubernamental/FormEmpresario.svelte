<script>
    import { checkRole, checkPermission } from '@/Utils'
    import { page } from '@inertiajs/inertia-svelte'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import LoadingButton from '@/Shared/LoadingButton'
    import Switch from '@/Shared/Switch'
    import SelectMulti from '@/Shared/SelectMulti'

    export let submit
    export let sending
    export let tiposDocumento
    export let roles = null
    export let errors
    export let formEmpresario
    export let method = null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = null
    if (authUser) {
        isSuperAdmin = checkRole(authUser, [1])
    }
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8">
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre_user" value="Nombre" />
                <Input id="name_user" type="text" class="mt-1" bind:value={$formEmpresario.name} error={errors.name} required />
            </div>

            <div>
                <Label required labelFor="email_user" value="Correo electrónico" />
                <Input id="email_user" type="email" class="mt-1" bind:value={$formEmpresario.email} error={errors.email} required />
            </div>

            <div class="mt-4">
                <Label required={method == 'create' || method == 'register' ? 'required' : undefined} labelFor="password_user" value="Contraseña" />
                <Input id="password_user" type="password" class="mt-1" bind:value={$formEmpresario.password} error={errors.password} required={method == 'create' || method == 'register' ? 'required' : undefined} autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label required={method == 'create' || method == 'register' ? 'required' : undefined} labelFor="password_confirmation_user" value="Repita la contraseña" />
                <Input id="password_confirmation_user" type="password" class="mt-1" bind:value={$formEmpresario.password_confirmation} error={errors.password_confirmation} required={method == 'create' || method == 'register' ? 'required' : undefined} autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label required labelFor="tipo_documento_user" value="Tipo de documento" />
                <Select id="tipo_documento_user" items={tiposDocumento} bind:selectedValue={$formEmpresario.tipo_documento} error={errors.tipo_documento} autocomplete="off" placeholder="Seleccione el tipo de documento" required />
            </div>

            <div>
                <Label required labelFor="numero_documento_user" value="Número de documento" />
                <Input id="numero_documento_user" type="number" input$min="0" class="mt-1" bind:value={$formEmpresario.numero_documento} error={errors.numero_documento} required />
            </div>

            <div>
                <Label required labelFor="numero_celular_user" value="Número de celular" />
                <Input id="numero_celular_user" type="text" class="mt-1" bind:value={$formEmpresario.numero_celular} error={errors.numero_celular} required />
            </div>

            {#if roles}
                <div>
                    <Label required labelFor="rol_id_user" value="Roles" />
                    <SelectMulti id="rol_id_user" bind:selectedValue={$formEmpresario.rol_id} items={roles} isMulti={true} error={errors.rol_id} placeholder="Seleccione el rol" required />
                </div>
            {/if}

            {#if authUser ? checkPermission(authUser, [17, 23]) || isSuperAdmin : null}
                <div class="mt-4">
                    <Label required labelFor="esta_habilitado" value="¿El usuario está habilitado? (Si esta inhabilitado no podrá ingresar al sistema)" class="inline-block mb-4" />
                    <br />
                    <Switch bind:checked={$formEmpresario.esta_habilitado} required />
                </div>
            {/if}

            <div class="mt-4">
                <Label required labelFor="autorizacion_tratamiento_datos" value="¿El usuario autoriza el tratamiento de los datos personales?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$formEmpresario.autorizacion_tratamiento_datos} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        <LoadingButton loading={sending} disabled={$formEmpresario.autorizacion_tratamiento_datos ? true : undefined} class="ml-auto" type="submit">Guardar</LoadingButton>
    </div>
</form>
