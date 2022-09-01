<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Textarea from '@/Shared/Textarea'
    import LoadingButton from '@/Shared/LoadingButton'
import { Inertia } from '@inertiajs/inertia'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])

    function loadfile(event) {
        var output = document.getElementById('preimage')
        output.src = URL.createObjectURL(event.target.files[0])
        $form.image = event.target.files[0]
    }
</script>

<form on:submit|preventDefault={submit} class="col-span-2">


    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [19]) ? undefined : true}>
        <div class="mt-4">



            <div>
                <Label required labelFor="nombre de la entidad" value="Nombre de la entidad" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombreEntidad} error={errors.nombreEntidad} required />

            </div>

            <div>
                <Label required labelFor="Nit" value="Nit"/>
                <Input id="nit" type="text" class="mt-1" bind:value={$form.nit} error={errors.nit} required />

            </div>
            <div>
                <Label required labelFor="telefono" value="Telefono" />
                <Input id="telefono" type="text" class="mt-1" bind:value={$form.telefono} error={errors.telefono} required />

            </div>
            <div>
                <Label required labelFor="ciudad" value="Ciudad" />
                <Input id="ciuddad" type="text" class="mt-1" bind:value={$form.ciudad} error={errors.ciudad} required />

            </div>
            <div>
                <Label required labelFor="direccion" value="Direccion" />
                <Input id="direccion" type="text" class="mt-1" bind:value={$form.direccion} error={errors.direccion} required />

            </div>



            

        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">


        {#if isSuperAdmin || checkPermission(authUser, [19])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>

        {/if}
    </div>
</form>



