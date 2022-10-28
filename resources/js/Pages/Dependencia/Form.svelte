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

    /*
    export let tiposDocumento
    export let tipoUsuario
    export let institucionEducativa = null
    export let institucionesEducativas
    */

    export let submit
    export let sending
    export let roles
    export let errors
    export let form
    export let method = null
    export let municipios
    export let delegados

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
                <Label required labelFor="nombreEntidad" value="Nombre Entidad" />
                <Input id="name" type="text" class="mt-1" bind:value={$form.name} error={errors.name} required />
            </div>

            <div>
                <Label required labelFor="direccion" value="Direccion" />
                <Input id="direccion" type="text" class="mt-1" bind:value={$form.direction} error={errors.direction} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="phone" value="Telefono" />
                <Input id="phone" type="number" class="mt-1" bind:value={$form.phone} error={errors.phone} required={method == 'create' || method == 'register' ? 'required' : undefined} autocomplete="new-password" />
            </div>

            <!-- <div class="mt-4">
                <Label required labelFor="tipo_documento" value="Tipo de documento" />
                <Select id="tipo_documento" items={tiposDocumento} bind:selectedValue={$form.tipo_documento} error={errors.tipo_documento} autocomplete="off" placeholder="Seleccione el tipo de documento" required />
            </div> -->

            <div>
                <Label required labelFor="nit" value="Nit" />
                <Input id="nit" type="number" input$min="0" class="mt-1" bind:value={$form.nit} error={errors.nit} required />
            </div>

            {#if municipios}
                <div>
                    <Label required labelFor="municipios" value="Municipios" />
                    <select name="" id="" bind:value={$form.city} required>
                        <option value="">Seleccione... </option>
                        {#each municipios as muni}
                            <option value={muni.municipio}> {muni.municipio}</option>
                        {/each}
                    </select>
                    <!--<SelectMulti id="municipios" bind:selectedValue={$form.municipios} items={municipios} isMulti={true} error={errors.municipios} placeholder="Seleccione el rol" required /> -->
                </div>
            {/if}
            {#if municipios}
                <div>
                    <Label required labelFor="delegados" value="Delegado Entidad" />
                    <select name="" id="" bind:value={$form.id_delegado_entidad} required>
                        <option value="">Seleccione... </option>
                        {#each delegados as dele}
                            <option value={dele.id}> {dele.name}</option>
                        {/each}
                    </select>
                    <!--<SelectMulti id="municipios" bind:selectedValue={$form.municipios} items={municipios} isMulti={true} error={errors.municipios} placeholder="Seleccione el rol" required /> -->
                </div>
            {/if}
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        <LoadingButton loading={sending} class="ml-auto" type="submit">{method == 'register' ? 'Crear cuenta' : 'Guardar'}</LoadingButton>
    </div>
</form>
