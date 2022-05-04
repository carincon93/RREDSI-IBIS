<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import LoadingButton from '@/Shared/LoadingButton'
    import SelectMulti from '@/Shared/SelectMulti'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let permisos

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [25]) ? undefined : true}>
        <div>
            <Label required labelFor="name" value="Nombre" />
            <Input id="name" type="text" class="mt-1" bind:value={$form.name} error={errors.name} required />
        </div>

        <div>
            <Label required labelFor="permission_id" value="Permisos" />
            <SelectMulti id="permission_id" bind:selectedValue={$form.permission_id} items={permisos} isMulti={true} error={errors.permission_id} placeholder="Buscar por el nombre del permiso" required />
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [25])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
