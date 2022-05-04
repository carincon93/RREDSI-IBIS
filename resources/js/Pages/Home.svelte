<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page, useForm, inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { Inertia } from '@inertiajs/inertia'
    import { _ } from 'svelte-i18n'

    import Dialog from '@/Shared/Dialog'
    import Button from '@/Shared/Button'
    import Select from '@/Shared/Select'
    import Label from '@/Shared/Label'
    import InfoMessage from '@/Shared/InfoMessage'

    export let errors
    export let institucionesEducativas

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let dialogOpen = true

    let form = useForm({
        institucion_educativa_id: null,
    })

    function submit() {
        Inertia.get(route('instituciones-educativas.show', $form.institucion_educativa_id?.value))
    }
</script>

<AuthenticatedLayout>
    <Dialog bind:open={dialogOpen}>
        <div slot="title" class="text-center">Menú principal</div>
        <div slot="content" class="min-h-[15rem]">
            {#if authUser.institucion_educativa_id != null && checkPermission(authUser, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 33, 34, 35, 36])}
                <form id="form-institucion-educativa" on:submit|preventDefault={submit} class="mt-10">
                    <Label labelFor="institucion_educativa_id" class="mb-8" value="Por favor seleccione una de las siguientes instituciones educativas para que sea dirigido(a) al respectivo panel y luego de clic en 'Continuar':" />
                    <Select id="institucion_educativa_id" items={institucionesEducativas} bind:selectedValue={$form.institucion_educativa_id} error={errors.institucion_educativa_id} autocomplete="off" placeholder="Seleccione una intstiución educativa" required />
                </form>
            {/if}

            {#if isSuperAdmin || checkPermission(authUser, [19, 20, 21, 22, 23, 24, 25, 26]) || authUser.empresa_id}
                <span class="mt-10 block text-sm text-gray-700 mb-8 text-center">Por favor seleccione un módulo de la siguiente lista:</span>

                <ul class="grid grid-cols-3 gap-2">
                    {#if isSuperAdmin || checkPermission(authUser, [21, 22])}
                        <li>
                            <Button on:click={() => Inertia.visit(route('nodos.index'))} variant="outlined" class="p-2 w-full">Nodos</Button>
                        </li>
                    {/if}

                    {#if isSuperAdmin || checkPermission(authUser, [19, 20])}
                        <li>
                            <Button on:click={() => Inertia.visit(route('convocatorias.index'))} variant="outlined" class="p-2 w-full">Convocatorias</Button>
                        </li>
                    {/if}

                    {#if isSuperAdmin || checkPermission(authUser, [23, 24])}
                        <li>
                            <Button on:click={() => Inertia.visit(route('users.index'))} variant="outlined" class="p-2 w-full">Usuarios</Button>
                        </li>
                    {/if}
                    {#if isSuperAdmin || checkPermission(authUser, [25, 26])}
                        <li>
                            <Button on:click={() => Inertia.visit(route('roles.index'))} variant="outlined" class="p-2 w-full">Roles</Button>
                        </li>
                    {/if}
                    {#if isSuperAdmin}
                        <li>
                            <Button on:click={() => Inertia.visit(route('instituciones-educativas.index'))} variant="outlined" class="p-2 w-full">Instituciones educativas</Button>
                        </li>
                    {/if}
                    {#if isSuperAdmin || authUser.empresa_id}
                        <li>
                            <Button on:click={() => Inertia.visit(route('dashboard-empresa'))} variant="outlined" class="p-2 w-full">Panel empresarial</Button>
                        </li>
                    {/if}
                </ul>
            {/if}

            {#if !isSuperAdmin && authUser.empresa_id == null && authUser.institucion_educativa_id == null}
                <InfoMessage class="mt-4" alertMsg={true}>No está asignado a ninguna empresa o institución educativa, por favor comuníquese con algún administrador.</InfoMessage>
            {/if}
        </div>
        <div slot="actions">
            {#if authUser.institucion_educativa_id != null}
                <div class="p-4">
                    <Button variant="raised" on:click={submit} form="form-institucion-educativa" disabled={$form.institucion_educativa_id?.value ? undefined : true}>Continuar</Button>
                </div>
            {/if}
        </div>
    </Dialog>
</AuthenticatedLayout>
