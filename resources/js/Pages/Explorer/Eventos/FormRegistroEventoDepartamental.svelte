<script>
    import { page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'

    import Label from '@/Shared/Label'
    import Select from '@/Shared/Select'
    import LoadingButton from '@/Shared/LoadingButton'
    import File from '@/Shared/File'
    import Switch from '@/Shared/Switch'
    import InfoMessage from '@/Shared/InfoMessage'

    export let errors
    export let submit
    export let proyectoEventoDepartamental
    export let tiposPresentacion
    export let modalidadesProyecto
    export let estudiantes
    export let programasAcademicos
    export let semillerosInvestigacion
    export let areasConocimiento
    export let eventoRredsiDepartamental
    export let form
    export let sending
    export let method = null

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8">
        <div class="mt-20">
            <div class="mt-20">
                <Label required labelFor="tipo_presentacion" value="Tipo de presentacion" />
                <Select id="tipo_presentacion" items={tiposPresentacion} bind:selectedValue={$form.tipo_presentacion} error={errors.tipo_presentacion} autocomplete="off" placeholder="Seleccione el tipo de presentación" required />
            </div>

            <div class="mt-20">
                <Label required labelFor="primer_ponente_id" value="Primer ponente" />
                <Select id="primer_ponente_id" items={estudiantes} bind:selectedValue={$form.primer_ponente_id} error={errors.primer_ponente_id} autocomplete="off" placeholder="Seleccione el primer ponente" required />
            </div>

            <div class="mt-20">
                <Label required labelFor="programa_academico_primer_ponente_id" value="Programa al que esta vinculado en la institución" />
                <Select id="programa_academico_primer_ponente_id" items={programasAcademicos} bind:selectedValue={$form.programa_academico_primer_ponente_id} error={errors.programa_academico_primer_ponente_id} autocomplete="off" placeholder="Seleccione el programa académico" required />
            </div>

            <div class="mt-20">
                <Label required labelFor="segundo_ponente_id" value="Segundo ponente" />
                <Select id="segundo_ponente_id" items={estudiantes} bind:selectedValue={$form.segundo_ponente_id} error={errors.segundo_ponente_id} autocomplete="off" placeholder="Seleccione el segundo ponente" required />
                <InfoMessage>Si no encuentra el ponente por favor indíquele que debe hace el registro en el siguiente enlace <a href={route('register')} class="underline" target="_blank">Formulario de registro</a></InfoMessage>
            </div>

            <div class="mt-20">
                <Label required labelFor="programa_academico_segundo_ponente_id" value="Programa al que esta vinculado en la institución" />
                <Select id="programa_academico_segundo_ponente_id" items={programasAcademicos} bind:selectedValue={$form.programa_academico_segundo_ponente_id} error={errors.programa_academico_segundo_ponente_id} autocomplete="off" placeholder="Seleccione el programa académico" required />
            </div>

            <div class="mt-20">
                <Label required labelFor="semillero_investigacion_id" value="Semillero en que participan los estudiantes" />
                <Select id="semillero_investigacion_id" items={semillerosInvestigacion} bind:selectedValue={$form.semillero_investigacion_id} error={errors.semillero_investigacion_id} autocomplete="off" placeholder="Seleccione el semillero de investigación" required />
            </div>

            <div class="mt-20">
                <Label required labelFor="area_conocimiento" value="Área de conocimiento en la que esta enmarcada el proyecto" />
                <Select id="area_conocimiento" items={areasConocimiento} bind:selectedValue={$form.area_conocimiento} error={errors.area_conocimiento} autocomplete="off" placeholder="Seleccione el área" required />
            </div>

            <div class="mt-20">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="carta_aval" value="Carta de Aval del Tutor PDF" />
                {#if $form.tipo_presentacion?.value == 'póster'}
                    <span class="mb-10 block">(En el siguiente enlace <a href={'/storage/' + eventoRredsiDepartamental.carta_aval_poster} class="underline" target="_blank">{eventoRredsiDepartamental.carta_aval_poster}</a> se encuentra la carta de aval del tutor)</span>
                {:else if $form.tipo_presentacion?.value == 'ponencia'}
                    <span class="mb-10 block">(En el siguiente enlace <a href={'/storage/' + eventoRredsiDepartamental.carta_aval_ponencia} class="underline" target="_blank">{eventoRredsiDepartamental.carta_aval_ponencia}</a> se encuentra la carta de aval del tutor)</span>
                {/if}
                <File id="carta_aval" type="file" accept="application/pdf" maxSize="10000" class="mt-1" bind:value={$form.carta_aval} error={errors.carta_aval} required={method == 'put' ? undefined : 'required'} />

                {#if method == 'put'}
                    <a href={'/storage/' + proyectoEventoDepartamental.carta_aval} class="underline block mt-10" target="_blank">Ver carta de aval del tutor</a>
                {/if}
            </div>

            {#if $form.tipo_presentacion?.value == 'póster'}
                <div class="mt-20">
                    <Label required={method == 'put' ? undefined : 'required'} labelFor="carta_poster" value="Documento del Póster para la evaluación de la inscripción (Word)" />
                    <span class="mb-10 block">(En el siguiente enlace <a href={'/storage/' + eventoRredsiDepartamental.formato_guia_poster} class="underline" target="_blank">{eventoRredsiDepartamental.formato_guia_poster}</a> se encuentra el documento del Póster)</span>

                    <File id="carta_poster" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.carta_poster} error={errors.carta_poster} required={method == 'put' ? undefined : 'required'} />

                    {#if method == 'put'}
                        <a href={'/storage/' + proyectoEventoDepartamental.carta_poster} class="underline block mt-10" target="_blank">Ver documento del póster para la evaluación de la inscripción</a>
                    {/if}
                </div>
            {:else if $form.tipo_presentacion?.value == 'ponencia'}
                <div class="mt-20">
                    <Label required labelFor="modalidad_proyecto" value="Modalidad de proyecto" />
                    <Select id="modalidad_proyecto" items={modalidadesProyecto} bind:selectedValue={$form.modalidad_proyecto} error={errors.modalidad_proyecto} autocomplete="off" placeholder="Seleccione una modalidad" required />
                </div>

                <div class="mt-20">
                    <Label required={method == 'put' ? undefined : 'required'} labelFor="documento_proyecto_finalizado" value="En esta sección se inscribe el proyecto finalizado teniendo en cuenta las indicaciones del siguiente formato: " />
                    <a href={'/storage/' + eventoRredsiDepartamental.formato_guia_ponencia} class="underline mb-10 block" target="_blank">{eventoRredsiDepartamental.formato_guia_ponencia}</a>
                    <File id="documento_proyecto_finalizado" type="file" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" maxSize="10000" class="mt-1" bind:value={$form.documento_proyecto_finalizado} error={errors.documento_proyecto_finalizado} required={method == 'put' ? undefined : 'required'} />

                    {#if method == 'put'}
                        <a href={'/storage/' + proyectoEventoDepartamental.documento_proyecto_finalizado} class="underline block mt-10" target="_blank">Ver documento de proyecto en curso/finalizado</a>
                    {/if}
                </div>
            {/if}

            <div class="mt-20">
                <Label required labelFor="autorizacion_memorias" value="En caso de que se publiquen memorias. ¿Estaría de acuerdo en que se publiquen como memorias en la pagina de la RREDSI? " class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.autorizacion_memorias} required />
            </div>

            <div class="mt-20">
                <Label
                    required
                    labelFor="autorizacion_tratamiento_datos"
                    value="Aviso de privacidad / Autorización de tratamiento de datos personales : Por medio de la presente autorizo de manera voluntaria, previa, explicita, informada e inequívoca a la Red Regional de Semilleros de Investigación -RREDSI para tratar mis datos personales con fines estadísticos y/o estratégicos para el desarrollo de actividades de la Red, así como para que me contacte a través de medios electrónicos de acuerdo a la Política de Manejo de Privacidad y Tratamiento de Datos Personales de la RREDSI. Declaro como titular, que la información aquí consignada es completa, veraz, confiable, exacta y que he sido informado que la Red Regional de Semilleros de Investigación - RREDSI, actuará como responsable de mis datos personales y que ha colocado a mi disposición el correo electrónico rredsicaldas@gmail.com para efectuar cualquier consulta y/o reclamo referente al tratamiento de datos personales, ejerciendo la ley 1581 de 2012,Decreto Reglamentario 1377 de 2013, la Ley1266 de 2008, el decreto 1571 de 1993, la Resolución 1995 y el decreto 2759 de 1991. Consulte nuestra política: https://rredsi.co/wp-content/uploads/2020/10/POLITICA-DE-MANEJO-DE-PRIVACIDAD-Y-TRATAMIENTO-DE-DATOS-PERSONALES-RREDSI.pdf "
                    class="inline-block mb-4"
                />
                <br />
                <Switch bind:checked={$form.autorizacion_tratamiento_datos} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
    </div>
</form>
