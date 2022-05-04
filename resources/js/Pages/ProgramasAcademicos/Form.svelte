<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let modalidades
    export let jornadas
    export let nivelesAcademicos
    export let facultades

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [9]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="modalidad" value="Modalidad" />
                <Select id="modalidad" items={modalidades} bind:selectedValue={$form.modalidad} error={errors.modalidad} autocomplete="off" placeholder="Seleccione una modalidad" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="jornada" value="Jornada" />
                <Select id="jornada" items={jornadas} bind:selectedValue={$form.jornada} error={errors.jornada} autocomplete="off" placeholder="Seleccione una jornada" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="nivel_academico" value="Nivel académico" />
                <Select id="nivel_academico" items={nivelesAcademicos} bind:selectedValue={$form.nivel_academico} error={errors.nivel_academico} autocomplete="off" placeholder="Seleccione un nivel académico" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="facultad_id" value="Facultad / Centro de formación" />
                <Select id="facultad_id" items={facultades} bind:selectedValue={$form.facultad_id} error={errors.facultad_id} autocomplete="off" placeholder="Seleccione una facultad/centro de formación" required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [9])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
