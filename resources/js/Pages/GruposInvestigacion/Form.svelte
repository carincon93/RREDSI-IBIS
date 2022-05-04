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
    export let categoriasMinciencias
    export let facultades

    let isSuperAdmin = checkRole(authUser, [1])
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [3]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div>
                <Label required labelFor="email" value="Correo electrónico" />
                <Input id="email" type="email" class="mt-1" bind:value={$form.email} error={errors.email} required />
            </div>

            <div>
                <Label required labelFor="lider" value="Nombre del líder del grupo" />
                <Input id="lider" type="text" class="mt-1" bind:value={$form.lider} error={errors.lider} required />
            </div>

            <div>
                <Label required labelFor="gruplac" value="Enlace del GrupLac" />
                <Input id="gruplac" type="url" class="mt-1" bind:value={$form.gruplac} error={errors.gruplac} required />
                <p>Ejemplo: https://scienti.minciencias.gov.co/gruplac/jsp/visualiza/visualizagr.jsp?nro=00000xxxxx</p>
            </div>

            <div>
                <Label required labelFor="codigo_minciencias" value="Código Minciencias" />
                <Input id="codigo_minciencias" type="text" class="mt-1" bind:value={$form.codigo_minciencias} error={errors.codigo_minciencias} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="categoria_minciencias" value="Categoría Minciencias" />
                <Select id="categoria_minciencias" items={categoriasMinciencias} bind:selectedValue={$form.categoria_minciencias} error={errors.categoria_minciencias} autocomplete="off" placeholder="Seleccione una categoría" required />
            </div>

            <div class="mt-4">
                <Label required labelFor="facultad_id" value="Facultad / Centro de formación" />
                <Select id="facultad_id" items={facultades} bind:selectedValue={$form.facultad_id} error={errors.facultad_id} autocomplete="off" placeholder="Seleccione una facultad/centro de formación" required />
            </div>

            <div>
                <Label required labelFor="sitio_web" value="Sitio web" />
                <Input id="sitio_web" type="url" class="mt-1" bind:value={$form.sitio_web} error={errors.sitio_web} required />
                <p>Ejemplo: https://google.com.co</p>
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [3])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
