<script>
    import { route, checkRole, checkPermission } from '@/Utils'

    import Label from '@/Shared/Label'
    import SelectMulti from '@/Shared/SelectMulti'
    import Select from '@/Shared/Select'
    import Textarea from '@/Shared/Textarea'
    import File from '@/Shared/File'
    import Tags from '@/Shared/Tags'
    import Switch from '@/Shared/Switch'
    import LoadingButton from '@/Shared/LoadingButton'
    import InfoMessage from '@/Shared/InfoMessage'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let users
    export let facultades
    export let tiposProyecto
    export let semillerosInvestigacion
    export let lineasInvestigacion
    export let disciplinasSubareaConocimiento
    export let programasAcademicos

    export let method

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [13]) ? undefined : true}>
        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="titulo" value="Título" />
                <Textarea maxlength="500" id="titulo" bind:value={$form.titulo} error={errors.titulo} required />
            </div>
        </div>

        <div class="mt-4">
            <Label required labelFor="tipo_proyecto_id" value="Tipo de proyecto" />
            <Select id="tipo_proyecto_id" items={tiposProyecto} bind:selectedValue={$form.tipo_proyecto_id} error={errors.tipo_proyecto_id} autocomplete="off" placeholder="Seleccione el tipo de proyecto" required />
        </div>

        <div class="mt-4">
            <Label required labelFor="facultad_id" value="Facultad" />
            <Select id="facultad_id" items={facultades} bind:selectedValue={$form.facultad_id} error={errors.facultad_id} autocomplete="off" placeholder="Seleccione el tipo de proyecto" required />
        </div>

        <div>
            <Label required labelFor="fecha_inicio" value="Fecha de inicio del proyecto" />
            <input id="fecha_inicio" type="date" class="mt-1" bind:value={$form.fecha_inicio} error={errors.fecha_inicio} required />
        </div>

        <div>
            <Label required labelFor="fecha_finalizacion" value="Fecha de finalización del proyecto" />
            <input id="fecha_finalizacion" type="date" class="mt-1" bind:value={$form.fecha_finalizacion} error={errors.fecha_finalizacion} required />
        </div>

        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="resumen" value="Resumen" />
                <Textarea maxlength="40000" id="resumen" bind:value={$form.resumen} error={errors.resumen} required />
            </div>
        </div>

        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="palabras_clave" value="Palabras clave" />
                <Tags id="palabras_clave" class="mt-4" bind:tags={$form.palabras_clave} enforceWhitelist={false} placeholder="Escriba las palabras clave" error={errors.palabras_clave} required />
            </div>
        </div>

        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="objetivo_general" value="Objetivo general" />
                <Textarea maxlength="40000" id="objetivo_general" bind:value={$form.objetivo_general} error={errors.objetivo_general} required />
            </div>
        </div>

        <div class="mt-4">
            <div class="mt-4">
                <Label labelFor="requerimientos_roles" value="Requerimientos de perfiles (Jóvenes investigadores) Ej: Desarrollador web" />
                <Tags id="requerimientos_roles" class="mt-4" bind:tags={$form.requerimientos_roles} enforceWhitelist={false} placeholder="Escriba los requerimientos de roles" error={errors.requerimientos_roles} />
            </div>
        </div>

        {#if $form.requerimientos_roles}
            <div class="mt-4">
                <div class="mt-4">
                    <Label required labelFor="descripcion_requerimiento_rol" value="Descripción de los perfiles requeridos (actividades a realizar)" />
                    <Textarea maxlength="40000" id="descripcion_requerimiento_rol" bind:value={$form.descripcion_requerimiento_rol} error={errors.descripcion_requerimiento_rol} required />
                </div>
            </div>
        {/if}

        <div class="mt-4">
            <div class="mt-4">
                <Label labelFor="requerimientos_equipos" value="Equipos requeridos. Ej: Impresora 3D" />
                <Tags id="requerimientos_equipos" class="mt-4" bind:tags={$form.requerimientos_equipos} enforceWhitelist={false} placeholder="Escriba los requirimientos de equipos" error={errors.requerimientos_equipos} />
            </div>
        </div>

        {#if $form.requerimientos_equipos}
            <div class="mt-4">
                <div class="mt-4">
                    <Label required labelFor="requerimientos_equipos_descripcion" value="Descripción de los equipos requeridos (¿Que se requiere y para qué?)" />
                    <Textarea maxlength="40000" id="requerimientos_equipos_descripcion" bind:value={$form.requerimientos_equipos_descripcion} error={errors.requerimientos_equipos_descripcion} required />
                </div>
            </div>
        {/if}

        <div class="mt-4">
            <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="file" value="Por favor cargue un pdf con la información detallada del proyecto" />
            <File id="file" type="file" accept="application/pdf" maxSize="10000" class="mt-1" bind:value={$form.file} error={errors.file} required={method == 'put' ? undefined : 'required'} />
        </div>

        <div class="mt-4">
            <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="main_image" value="Imagen principal" />
            <File id="main_image" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="10000" class="mt-1" bind:value={$form.main_image} error={errors.main_image} required={method == 'put' ? undefined : 'required'} />
        </div>

        <div>
            <Label required labelFor="user_id" value="Participantes" />
            <SelectMulti id="user_id" bind:selectedValue={$form.user_id} items={users} isMulti={true} error={errors.user_id} placeholder="Buscar por el nombre del participante" required />
            <InfoMessage>Debe tener en cuenta que para asociar un participante este debe estar registrado(a) en el sistema. Si no está registrado(a) por favor indíquele que debe registrarse en el siguiente enlace <span class="underline">{route('register')}</span></InfoMessage>
        </div>

        <div>
            <Label required labelFor="programa_academico_id" value="Seleccione los programas académicos asociados al proyecto" />
            <SelectMulti id="programa_academico_id" bind:selectedValue={$form.programa_academico_id} items={programasAcademicos} isMulti={true} error={errors.programa_academico_id} placeholder="Buscar por el nombre del programa" required />
        </div>

        <div>
            <Label required labelFor="disciplina_subarea_conocimiento_id" value="Seleccione las disciplinas asociadas al proyecto" />
            <SelectMulti id="disciplina_subarea_conocimiento_id" bind:selectedValue={$form.disciplina_subarea_conocimiento_id} items={disciplinasSubareaConocimiento} isMulti={true} error={errors.disciplina_subarea_conocimiento_id} placeholder="Buscar por el nombre de la disciplina" required />
        </div>

        <div>
            <Label required labelFor="linea_investigacion_id" value="Seleccione las líneas de investigación asociadas al proyecto" />
            <SelectMulti id="linea_investigacion_id" bind:selectedValue={$form.linea_investigacion_id} items={lineasInvestigacion} isMulti={true} error={errors.linea_investigacion_id} placeholder="Buscar por el nombre de la línea" required />
        </div>

        <div>
            <Label required labelFor="semillero_investigacion_id" value="Selecccione los semilleros de investigación asociados al proyecto" />
            <SelectMulti id="semillero_investigacion_id" bind:selectedValue={$form.semillero_investigacion_id} items={semillerosInvestigacion} isMulti={true} error={errors.semillero_investigacion_id} placeholder="Buscar por el nombre del semillero" required />
        </div>

        <div class="mt-4">
            <Label labelFor="privado" value="¿El proyecto es privado? (No podrá ser consultado)" class="inline-block mb-4" />
            <br />
            <Switch bind:checked={$form.privado} />
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [13])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
