<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let gruposInvestigacion
    export let areasConocimiento

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [5]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="objetivos" value="Objetivos" />
                <Textarea maxlength="40000" id="objetivos" bind:value={$form.objetivos} error={errors.objetivos} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="mision" value="Misión" />
                <Textarea maxlength="40000" id="mision" bind:value={$form.mision} error={errors.mision} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="vision" value="Visión" />
                <Textarea maxlength="40000" id="vision" bind:value={$form.vision} error={errors.vision} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="logros" value="Logros" />
                <Textarea maxlength="40000" id="logros" bind:value={$form.logros} error={errors.logros} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="area_conocimiento_id" value="Área de conocimiento" />
                <Select id="area_conocimiento_id" items={areasConocimiento} bind:selectedValue={$form.area_conocimiento_id} error={errors.area_conocimiento_id} autocomplete="off" placeholder="Seleccione una área de conocimiento" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="grupo_investigacion_id" value="Grupo de investigación" />
                <Select id="grupo_investigacion_id" items={gruposInvestigacion} bind:selectedValue={$form.grupo_investigacion_id} error={errors.grupo_investigacion_id} autocomplete="off" placeholder="Seleccione un grupo de investigación" required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [5])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
