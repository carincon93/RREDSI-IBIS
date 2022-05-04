<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import LoadingButton from '@/Shared/LoadingButton'
    import Switch from '@/Shared/Switch'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="institucion_educativa" value="Nombre de la institución educativa" />
                <Input id="institucion_educativa" type="text" class="mt-1" bind:value={$form.institucion_educativa} error={errors.institucion_educativa} required />
            </div>

            <div>
                <Label required labelFor="programa_academico" value="Nombre del programa académico" />
                <Input id="programa_academico" type="text" class="mt-1" bind:value={$form.programa_academico} error={errors.programa_academico} required />
            </div>

            <div class="mt-4">
                <Label labelFor="graduado" value="¿Se ha graduado?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.graduado} />
            </div>

            {#if $form.graduado}
                <div>
                    <Label required labelFor="year" value="Año del grado" />
                    <Input id="year" type="number" input$min="1960" class="mt-1" bind:value={$form.year} error={errors.year} required />
                </div>
            {/if}
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
    </div>
</form>
