<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import LoadingButton from '@/Shared/LoadingButton'
    import Tags from '@/Shared/Tags'
    import File from '@/Shared/File'
    import Switch from '@/Shared/Switch'

    export let errors
    export let user

    let tiposDocumento = [
        { value: 'cc', label: 'Cédula de ciudadanía' },
        { value: 'ti', label: 'Tarjeta de identidad' },
        { value: 'ce', label: 'Cédula de extranjería' },
    ]

    $: $title = 'Soporte'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        name: user.name,
        email: user.email,
        password: '',
        password_confirmation: '',
        tipo_documento: { value: user.tipo_documento, label: tiposDocumento.find((item) => item.value == user.tipo_documento)?.label },
        numero_documento: user.numero_documento,
        numero_celular: user.numero_celular,
        intereses: user.intereses,
        perfil: user.perfil,
        cvlac: user.cvlac,
        cv: null,
        autorizacion_tratamiento_datos: user.autorizacion_tratamiento_datos,
        nit: user.empresa ? user.empresa.nit : '',
        nombre_empresa: user.empresa ? user.empresa.nombre : '',
        direccion_empresa: user.empresa ? user.empresa.direccion : '',
        numero_celular_empresa: user.empresa ? user.empresa.numero_celular : '',
        email_empresa: user.empresa ? user.empresa.email : '',
    })

    function submit() {
        $form.post(route('users.actualizar-perfil'), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
            preserveScroll: true,
        })
    }
</script>

<AuthenticatedLayout>
    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Perfil</h3>
            <p class="mt-1 text-sm text-gray-600">Información de <span class="capitalize">{user.name}</span></p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
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
                            <Label labelFor="password" value="Contraseña" />
                            <Input id="password" type="password" class="mt-1" bind:value={$form.password} error={errors.password} autocomplete="new-password" />
                        </div>

                        <div class="mt-4">
                            <Label labelFor="password_confirmation" value="Repita la contraseña" />
                            <Input id="password_confirmation" type="password" class="mt-1" bind:value={$form.password_confirmation} error={errors.password_confirmation} autocomplete="new-password" />
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

                        {#if user.institucion_educativa_id}
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

                        {#if user.empresa_id}
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

                        <div class="mt-4">
                            <Label required labelFor="autorizacion_tratamiento_datos" value="¿El usuario autoriza el tratamiento de los datos personales?" class="inline-block mb-4" />
                            <br />
                            <Switch bind:checked={$form.autorizacion_tratamiento_datos} required />
                        </div>
                    </div>
                </fieldset>
                <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
                    <LoadingButton loading={sending} disabled={$form.autorizacion_tratamiento_datos ? true : undefined} class="ml-auto" type="submit">Guardar</LoadingButton>
                </div>
            </form>
        </div>
    </div>
</AuthenticatedLayout>
