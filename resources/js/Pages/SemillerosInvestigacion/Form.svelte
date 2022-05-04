<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import Tags from '@/Shared/Tags'
    import SelectMulti from '@/Shared/SelectMulti'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let gruposInvestigacion
    export let disciplinasSubareaConocimiento
    export let lineasInvestigacion
    export let programasAcademicos

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [7]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre del semillero" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div>
                <Label required labelFor="fecha_creacion" value="Fecha de creación" />
                <input id="fecha_creacion" type="date" class="mt-1" bind:value={$form.fecha_creacion} error={errors.fecha_creacion} required />
            </div>

            <div>
                <Label required labelFor="nombre_mentor" value="Nombre del mentor" />
                <Input id="nombre_mentor" type="text" class="mt-1" bind:value={$form.nombre_mentor} error={errors.nombre_mentor} required />
            </div>

            <div>
                <Label required labelFor="correo_mentor" value="Correo electrónico del mentor" />
                <Input id="correo_mentor" type="email" class="mt-1" bind:value={$form.correo_mentor} error={errors.correo_mentor} required />
            </div>

            <div>
                <Label required labelFor="celular_mentor" value="Celular del mentor" />
                <Input id="celular_mentor" type="number" input$min="0" class="mt-1" bind:value={$form.celular_mentor} error={errors.celular_mentor} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="objetivo_general" value="Objetivo general" />
                <Textarea maxlength="40000" id="objetivo_general" bind:value={$form.objetivo_general} error={errors.objetivo_general} required />
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
                <Label required labelFor="proyeccion_regional" value="Proyección regional" />
                <Textarea maxlength="40000" id="proyeccion_regional" bind:value={$form.proyeccion_regional} error={errors.proyeccion_regional} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="estrategia_produccion_conocimiento" value="Estrategia de producción de conocimiento regional" />
                <Textarea maxlength="40000" id="estrategia_produccion_conocimiento" bind:value={$form.estrategia_produccion_conocimiento} error={errors.estrategia_produccion_conocimiento} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="tematica_investigacion" value="Temática de investigación (Separar cada temática por coma (,))" />
                <Tags id="tematica_investigacion" class="mt-4" bind:tags={$form.tematica_investigacion} enforceWhitelist={false} placeholder="Escriba las temáticas" error={errors.tematica_investigacion} required />
            </div>

            <div>
                <Label required labelFor="disciplina_subarea_conocimiento_id" value="Disciplinas de subárea de conocimiento" />
                <SelectMulti id="disciplina_subarea_conocimiento_id" bind:selectedValue={$form.disciplina_subarea_conocimiento_id} items={disciplinasSubareaConocimiento} isMulti={true} error={errors.disciplina_subarea_conocimiento_id} placeholder="Buscar por el nombre de la disciplina" required />
            </div>

            <div>
                <Label required labelFor="programa_academico_id" value="Programas académicos" />
                <SelectMulti id="programa_academico_id" bind:selectedValue={$form.programa_academico_id} items={programasAcademicos} isMulti={true} error={errors.programa_academico_id} placeholder="Buscar por el nombre del programa" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="grupo_investigacion_id" value="Grupo de investigación" />
                <Select id="grupo_investigacion_id" items={gruposInvestigacion} bind:selectedValue={$form.grupo_investigacion_id} error={errors.grupo_investigacion_id} autocomplete="off" placeholder="Seleccione un grupo de investigación" required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [7])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
