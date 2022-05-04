<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Textarea from '@/Shared/Textarea'
    import LoadingButton from '@/Shared/LoadingButton'
    import Select from '@/Shared/Select'
    import Switch from '@/Shared/Switch'
    import Tags from '@/Shared/Tags'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let tiposIdea
    export let condiciones
    // export let method = null

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [31]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre de la idea" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="descripcion" value="Descripción" />
                <Textarea maxlength="40000" id="descripcion" bind:value={$form.descripcion} error={errors.descripcion} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="tipo" value="Tipo" />
                <Select id="tipo" items={tiposIdea} bind:selectedValue={$form.tipo} error={errors.tipo} autocomplete="off" placeholder="Seleccione un tipo" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="condicion" value="Condición" />
                <Select id="condicion" items={condiciones} bind:selectedValue={$form.condicion} error={errors.condicion} autocomplete="off" placeholder="Seleccione una condición" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="tiene_equipos" value="¿Tiene herramientas?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.tiene_equipos} required />
            </div>

            {#if $form.tiene_equipos}
                <div class="mt-4">
                    <div class="mt-4">
                        <Label labelFor="equipos" value="¿Con cuáles herramientas cuenta? (Separados por coma (,))" />
                        <Tags id="equipos" class="mt-4" bind:tags={$form.equipos} enforceWhitelist={false} placeholder="Escriba las herramientas" error={errors.equipos} />
                    </div>
                </div>
            {/if}

            <div class="mt-4">
                <Label required labelFor="tiene_recursos" value="¿Cuenta con presupuesto?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.tiene_recursos} required />
            </div>

            {#if $form.tiene_recursos}
                <div>
                    <Label required labelFor="recursos" value="Monto para desarrollar la idea" />
                    <Input id="recursos" type="number" input$min="0" class="mt-1" bind:value={$form.recursos} error={errors.recursos} required />
                </div>
            {/if}

            <div class="mt-4">
                <Label required labelFor="es_publica" value="¿Es público?" class="inline-block mb-4" />
                <br />
                <Switch bind:checked={$form.es_publica} required />
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [31])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
