<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import File from '@/Shared/File'
    import LoadingButton from '@/Shared/LoadingButton'
    import Select from '@/Shared/Select'

    export let submit
    export let nodos
    export let institucionEducativa
    export let authUser
    export let sending
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [33]) ? undefined : true}>
        <div>
            <Label required labelFor="nombre" value="Nombre de la institución educativa" />
            <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
        </div>

        <div class="mt-4">
            <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="logo" value="Logo" />
            <File id="logo" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="4096" class="mt-1" bind:value={$form.logo} error={errors.logo} required={method == 'put' ? undefined : 'required'} />
            {#if method == 'put'}
                <a href="/storage/{institucionEducativa.logo}" target="_blank" class="underline inline-block mt-8">Ver logo de la institución</a>
            {/if}
        </div>

        <div>
            <Label required labelFor="nit" value="NIT" />
            <Input id="nit" type="text" class="mt-1" bind:value={$form.nit} error={errors.nit} required />
        </div>

        <div>
            <Label required labelFor="direccion" value="Dirección" />
            <Input id="direccion" type="text" class="mt-1" bind:value={$form.direccion} error={errors.direccion} required />
        </div>

        <div>
            <Label required labelFor="ciudad" value="Ciudad" />
            <Input id="ciudad" type="text" class="mt-1" bind:value={$form.ciudad} error={errors.ciudad} required />
        </div>

        <div>
            <Label required labelFor="numero_telefono" value="Número de teléfono" />
            <Input id="numero_telefono" type="text" class="mt-1" bind:value={$form.numero_telefono} error={errors.numero_telefono} required />
        </div>

        <div>
            <Label required labelFor="sitio_web" value="Sitio web" />
            <Input id="sitio_web" type="text" class="mt-1" bind:value={$form.sitio_web} error={errors.sitio_web} required />
        </div>

        <div class="mt-4">
            <Label required labelFor="nodo_id" value="Nodo" />
            <Select id="nodo_id" items={nodos} bind:selectedValue={$form.nodo_id} error={errors.nodo_id} autocomplete="off" placeholder="Seleccione un nodo" required />
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [33])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
