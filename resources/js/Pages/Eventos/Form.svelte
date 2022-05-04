<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Textarea from '@/Shared/Textarea'
    import File from '@/Shared/File'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let evento
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [15]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div>
                <Label required labelFor="ubicacion" value="Ubicación" />
                <Input id="ubicacion" type="text" class="mt-1" bind:value={$form.ubicacion} error={errors.ubicacion} required />
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
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="imagen_principal" value="Imagen principal" />
                <File id="imagen_principal" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="10000" class="mt-1" bind:value={$form.imagen_principal} error={errors.imagen_principal} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put' && evento.imagen_principal}
                    <a href="/storage/{evento.imagen_principal}" target="_blank" class="underline inline-block mt-8">Ver imagen_principal</a>
                {/if}
            </div>

            <div class="mt-4">
                <Label required={method == 'put' ? undefined : 'required'} class="mb-4" labelFor="afiche" value="Afiche" />
                <File id="afiche" type="file" accept="image/png,image/jpeg,image/jpg" maxSize="10000" class="mt-1" bind:value={$form.afiche} error={errors.afiche} required={method == 'put' ? undefined : 'required'} />
                {#if method == 'put' && evento.afiche}
                    <a href="/storage/{evento.afiche}" target="_blank" class="underline inline-block mt-8">Ver afiche</a>
                {/if}
            </div>

            <div>
                <Label required labelFor="info_link" value="Enlace para ofrecer más información" />
                <Input id="info_link" type="url" class="mt-1" bind:value={$form.info_link} error={errors.info_link} required />
            </div>

            <div>
                <Label required labelFor="link_registro" value="Enlace de la página de registro" />
                <Input id="link_registro" type="url" class="mt-1" bind:value={$form.link_registro} error={errors.link_registro} required />
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
                <Label required labelFor="descripcion" value="Descripción detallada del evento" />
                <Textarea maxlength="40000" id="descripcion" bind:value={$form.descripcion} error={errors.descripcion} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [15])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
