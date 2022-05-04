<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [1]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div>
                <Label required labelFor="email" value="Correo electrónico" />
                <Input id="email" type="email" class="mt-1" bind:value={$form.email} error={errors.email} required />
            </div>

            <div>
                <Label required labelFor="numero_telefono" value="Número de teléfono + Extensión (Opcional)" />
                <Input id="numero_telefono" type="text" class="mt-1" bind:value={$form.numero_telefono} error={errors.numero_telefono} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [1])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
