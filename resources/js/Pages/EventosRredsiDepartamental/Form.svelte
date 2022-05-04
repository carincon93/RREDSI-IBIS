<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Select from '@/Shared/Select'
    import Label from '@/Shared/Label'
    import Textarea from '@/Shared/Textarea'
    import File from '@/Shared/File'
    import Switch from '@/Shared/Switch'
    import LoadingButton from '@/Shared/LoadingButton'
    import Tags from '@/Shared/Tags'

    export let submit
    export let authUser
    export let sending
    export let eventoRredsiDepartamental
    export let institucionesEducativas
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [21]) ? undefined : true}>
        <div class="mt-4">
            <div class="mt-4">
                <Label required labelFor="titulo" value="Título" />
                <Textarea maxlength="1000" id="titulo" bind:value={$form.titulo} error={errors.titulo} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="introduccion" value="Introducción" />
                <Textarea maxlength="40000" id="introduccion" bind:value={$form.introduccion} error={errors.introduccion} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="objetivos" value="Objetivos" />
                <Textarea maxlength="40000" id="objetivos" bind:value={$form.objetivos} error={errors.objetivos} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="cronograma" value="Cronograma" />
                <Textarea maxlength="40000" id="cronograma" bind:value={$form.cronograma} error={errors.cronograma} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="areas_conocimiento" value="Áreas de conocimiento (Separar cada área por coma (,))" />
                <Tags id="areas_conocimiento" class="mt-4" bind:tags={$form.areas_conocimiento} enforceWhitelist={false} placeholder="Escriba las áreas" error={errors.areas_conocimiento} required />
            </div>

            <div>
                <Label required labelFor="fecha_inicio" value="Fecha de inicio del evento" />
                <input id="fecha_inicio" type="date" class="mt-1" bind:value={$form.fecha_inicio} error={errors.fecha_inicio} required />
            </div>

            <div>
                <Label required labelFor="fecha_finalizacion" value="Fecha de finalización del evento" />
                <input id="fecha_finalizacion" type="date" class="mt-1" bind:value={$form.fecha_finalizacion} error={errors.fecha_finalizacion} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="institucion_educativa_id" value="Institución educativa que realiza el evento" />
                <Select id="institucion_educativa_id" items={institucionesEducativas} bind:selectedValue={$form.institucion_educativa_id} error={errors.institucion_educativa_id} autocomplete="off" placeholder="Seleccione una institución" required />
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="afiche" value="Afiche" />
                <File id="afiche" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="10000" class="mt-1" bind:value={$form.afiche} error={errors.afiche} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.afiche}" target="_blank" class="underline inline-block mt-8">Ver afiche</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="formato_guia_ponencia" value="Formato guía de ponencia" />
                <File id="formato_guia_ponencia" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.formato_guia_ponencia} error={errors.formato_guia_ponencia} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.formato_guia_ponencia}" target="_blank" class="underline inline-block mt-8">Ver formato guía de ponencia</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="carta_aval_ponencia" value="Carta aval de ponencia" />
                <File id="carta_aval_ponencia" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.carta_aval_ponencia} error={errors.carta_aval_ponencia} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.carta_aval_ponencia}" target="_blank" class="underline inline-block mt-8">Ver carta aval de ponencia</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="plantilla_presentacion_ponencia" value="Plantilla de presentación de ponencia" />
                <File id="plantilla_presentacion_ponencia" type="file" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation" maxSize="10000" class="mt-1" bind:value={$form.plantilla_presentacion_ponencia} error={errors.plantilla_presentacion_ponencia} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.plantilla_presentacion_ponencia}" target="_blank" class="underline inline-block mt-8">Ver plantilla de presentación de ponencia</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="guia_proyecto_finalizado" value="Guía para elaboración de documento proyecto en curso o finalizado" />
                <File id="guia_proyecto_finalizado" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.guia_proyecto_finalizado} error={errors.guia_proyecto_finalizado} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.guia_proyecto_finalizado}" target="_blank" class="underline inline-block mt-8">Ver guía para elaboración de documento proyecto en curso o finalizado</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="formato_guia_poster" value="Formato guía de póster" />
                <File id="formato_guia_poster" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.formato_guia_poster} error={errors.formato_guia_poster} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.formato_guia_poster}" target="_blank" class="underline inline-block mt-8">Ver formato guía de póster</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="carta_aval_poster" value="Carta aval de póster" />
                <File id="carta_aval_poster" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.carta_aval_poster} error={errors.carta_aval_poster} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.carta_aval_poster}" target="_blank" class="underline inline-block mt-8">Ver carta aval de póster</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="plantilla_presentacion_poster" value="Plantilla de presentación de póster" />
                <File id="plantilla_presentacion_poster" type="file" accept="application/vnd.openxmlformats-officedocument.presentationml.presentation" maxSize="10000" class="mt-1" bind:value={$form.plantilla_presentacion_poster} error={errors.plantilla_presentacion_poster} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put'}
                    <a href="/storage/{eventoRredsiDepartamental.plantilla_presentacion_poster}" target="_blank" class="underline inline-block mt-8">Ver plantilla de presentación de póster</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label labelFor="estado" value="¿El evento está activo?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.estado} />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [21])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
