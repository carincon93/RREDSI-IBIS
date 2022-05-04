<script>
    import { page } from '@inertiajs/inertia-svelte'
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import SelectMulti from '@/Shared/SelectMulti'
    import LoadingButton from '@/Shared/LoadingButton'
    import Tags from '@/Shared/Tags'
    import File from '@/Shared/File'
    import Switch from '@/Shared/Switch'

    export let submit
    export let sending
    export let tiposDocumento
    export let tipoUsuario
    export let institucionEducativa = null
    export let institucionesEducativas
    export let roles
    export let errors
    export let form
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
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="name" type="text" class="mt-1" bind:value={$form.name} error={errors.name} required />
            </div>

            <div>
                <Label required labelFor="email" value="Correo electrónico" />
                <Input id="email" type="email" class="mt-1" bind:value={$form.email} error={errors.email} required />
            </div>

            <div class="mt-4">
                <Label required={method == 'create' || method == 'register' ? 'required' : undefined} labelFor="password" value="Contraseña" />
                <Input id="password" type="password" class="mt-1" bind:value={$form.password} error={errors.password} required={method == 'create' || method == 'register' ? 'required' : undefined} autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label required={method == 'create' || method == 'register' ? 'required' : undefined} labelFor="password_confirmation" value="Repita la contraseña" />
                <Input id="password_confirmation" type="password" class="mt-1" bind:value={$form.password_confirmation} error={errors.password_confirmation} required={method == 'create' || method == 'register' ? 'required' : undefined} autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <Label required labelFor="tipo_documento" value="Tipo de documento" />
                <Select id="tipo_documento" items={tiposDocumento} bind:selectedValue={$form.tipo_documento} error={errors.tipo_documento} autocomplete="off" placeholder="Seleccione el tipo de documento" required />
            </div>

            <div>
                <Label required labelFor="numero_documento" value="Número de documento" />
                <Input id="numero_documento" type="number" input$min="0" class="mt-1" bind:value={$form.numero_documento} error={errors.numero_documento} required />
            </div>

            <div>
                <Label required labelFor="numero_celular" value="Número de celular" />
                <Input id="numero_celular" type="text" class="mt-1" bind:value={$form.numero_celular} error={errors.numero_celular} required />
            </div>

            {#if $form.tipo_usuario == 'rredsi' || tipoUsuario == 'rredsi'}
                <div class="mt-4">
                    <Label labelFor="perfil" value="Perfil académico y profesional" />
                    <Textarea maxlength="40000" id="perfil" bind:value={$form.perfil} error={errors.perfil} />
                </div>

                <div>
                    <Label labelFor="cvlac" value="Enlace al CvLAC (Debe contener el http:// o https://)" />
                    <Input id="cvlac" type="url" class="mt-1" bind:value={$form.cvlac} error={errors.cvlac} />
                </div>

                <div class="mt-4">
                    <Label class="mb-4" labelFor="cv" value="Hoja de vida (PDF)" />
                    <File id="cv" type="file" accept="application/pdf" maxSize="10000" class="mt-1" bind:value={$form.cv} error={errors.cv} />
                </div>

                <div class="mt-4">
                    <div class="mt-4">
                        <Label labelFor="intereses" value="Intereses profesionales y formativos (Separados por coma (,))" />
                        <Tags id="intereses" class="mt-4" bind:tags={$form.intereses} enforceWhitelist={false} placeholder="Escriba los intereses" error={errors.intereses} />
                    </div>
                </div>
            {/if}

            {#if roles}
                <div>
                    <Label required labelFor="rol_id" value="Roles" />
                    <SelectMulti id="rol_id" bind:selectedValue={$form.rol_id} items={roles} isMulti={true} error={errors.rol_id} placeholder="Seleccione el rol" required />
                </div>
            {/if}

            {#if (institucionEducativa == null && $form.tipo_usuario == 'rredsi') || (institucionEducativa == null && tipoUsuario == 'rredsi')}
                <div class="mt-4">
                    <Label required={$form.tipo_usuario == 'rredsi' || tipoUsuario == 'rredsi' ? 'required' : undefined} labelFor="institucion_educativa_id" value="Institución educativa a la que pertenece" />
                    <Select id="institucion_educativa_id" items={institucionesEducativas} bind:selectedValue={$form.institucion_educativa_id} error={errors.institucion_educativa_id} autocomplete="off" placeholder="Seleccione una institución educativa" required={$form.tipo_usuario == 'rredsi' || tipoUsuario == 'rredsi' ? 'required' : undefined} />
                </div>
            {/if}

            {#if $form.tipo_usuario == 'empresario' || tipoUsuario == 'empresario'}
                <div>
                    <Label required labelFor="nit" value="NIT" />
                    <Input id="nit" type="text" class="mt-1" bind:value={$form.nit} error={errors.nit} required />
                </div>

                <div>
                    <Label required labelFor="nombre_empresa" value="Nombre de la empresa" />
                    <Input id="nombre_empresa" type="text" class="mt-1" bind:value={$form.nombre_empresa} error={errors.nombre_empresa} required />
                </div>

                <div>
                    <Label required labelFor="direccion_empresa" value="Dirección de la empresa" />
                    <Input id="direccion_empresa" type="text" class="mt-1" bind:value={$form.direccion_empresa} error={errors.direccion_empresa} required />
                </div>

                <div>
                    <Label required labelFor="numero_celular_empresa" value="Teléfonos de la empresa" />
                    <Input id="numero_celular_empresa" type="text" class="mt-1" bind:value={$form.numero_celular_empresa} error={errors.numero_celular_empresa} required />
                </div>

                <div>
                    <Label required labelFor="email_empresa" value="Correo electrónico de la empresa" />
                    <Input id="email_empresa" type="email" class="mt-1" bind:value={$form.email_empresa} error={errors.email_empresa} required />
                </div>
            {/if}

            {#if authUser ? checkPermission(authUser, [17, 23]) || isSuperAdmin : null}
                <div class="mt-4">
                    <Label required labelFor="esta_habilitado" value="¿El usuario está habilitado? (Si esta inhabilitado no podrá ingresar al sistema)" class="inline-block mb-4" />
                    <br />
                    <Switch bind:checked={$form.esta_habilitado} required />
                </div>
            {/if}

            <div class="mt-4">
                <Label required labelFor="autorizacion_tratamiento_datos" value="¿El usuario autoriza el tratamiento de los datos personales?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.autorizacion_tratamiento_datos} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        <LoadingButton loading={sending} disabled={$form.autorizacion_tratamiento_datos ? true : undefined} class="ml-auto" type="submit">{method == 'register' ? 'Crear cuenta' : 'Guardar'}</LoadingButton>
    </div>
</form>
