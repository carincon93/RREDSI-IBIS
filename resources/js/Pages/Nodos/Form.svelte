<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Select from '@/Shared/Select'
    import Label from '@/Shared/Label'
    import File from '@/Shared/File'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let departamentos
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [21]) ? undefined : true}>
        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="departamento" value="Departamento" />
                <Select id="departamento" items={departamentos} bind:selectedValue={$form.departamento} error={errors.departamento} autocomplete="off" placeholder="Seleccione un departamento" required />
            </div>
            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="logo" value="Logo del nodo (Preferiblemente png y sin fondo. Utilice la siguiente aplicación para remover el fondo https://www.remove.bg/)" />
                <File id="logo" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="4096" class="mt-1" bind:value={$form.logo} error={errors.logo} required={method == 'put' ? undefined : 'required'} />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [21])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
