<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import SelectMulti from '@/Shared/SelectMulti'
    import LoadingButton from '@/Shared/LoadingButton'
    import File from '@/Shared/File'

    export let submit
    export let authUser
    export let sending
    export let facultades
    export let disciplinasSubareaConocimiento
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [35]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="foto" value="Imagen principal" />
                <File id="foto" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="4096" class="mt-1" bind:value={$form.foto} error={errors.foto} required={method == 'put' ? undefined : 'required'} />
            </div>

            <div>
                <Label required labelFor="nombre_responsable" value="Nombre del responsable" />
                <Input id="nombre_responsable" type="text" class="mt-1" bind:value={$form.nombre_responsable} error={errors.nombre_responsable} required />
            </div>

            <div>
                <Label required labelFor="correo_responsable" value="Correo del responsable" />
                <Input id="correo_responsable" type="email" class="mt-1" bind:value={$form.correo_responsable} error={errors.correo_responsable} required />
            </div>

            <div>
                <Label required labelFor="celular_responsable" value="Celular del responsable" />
                <Input id="celular_responsable" type="text" class="mt-1" bind:value={$form.celular_responsable} error={errors.celular_responsable} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="descripcion" value="Descripción detallada del equipo (Funcionalidades - Aplicaciones)" />
                <Textarea maxlength="40000" id="descripcion" bind:value={$form.descripcion} error={errors.descripcion} required />
            </div>

            <div>
                <Label required labelFor="disciplina_subarea_conocimiento_id" value="Disciplinas de subárea de conocimiento" />
                <SelectMulti id="disciplina_subarea_conocimiento_id" bind:selectedValue={$form.disciplina_subarea_conocimiento_id} items={disciplinasSubareaConocimiento} isMulti={true} error={errors.disciplina_subarea_conocimiento_id} placeholder="Buscar por el nombre de la disciplina" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="facultad_id" value="Facultad" />
                <Select id="facultad_id" items={facultades} bind:selectedValue={$form.facultad_id} error={errors.facultad_id} autocomplete="off" placeholder="Seleccione una facultad" required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [35])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
