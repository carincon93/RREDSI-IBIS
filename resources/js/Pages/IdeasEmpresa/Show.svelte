<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page, useForm } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'
    import Textarea from '@/Shared/Textarea'
    import Label from '@/Shared/Label'
    import Input from '@/Shared/Input'
    import LoadingButton from '@/Shared/LoadingButton'
    import DataTable from '@/Shared/DataTable'

    import File from '@/Shared/File'

    export let errors
    export let ideaEmpresa
    export let respuestas
    export let respuesta

    $: $title = 'Detalles de la idea'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        idea_empresa_id: ideaEmpresa.id,
        titulo: respuesta ? respuesta.titulo : '',
        descripcion: respuesta ? respuesta.descripcion : '',
        documento: null,
    })

    function submit() {
        $form.post(route('respuestas.store'), {
            onStart: () => (sending = true),
            onFinish: () => (sending = false),
            preserveScroll: true,
        })
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('ideas-empresa.index')} class="text-gray-500 hover:text-gray-600"> Ideas </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <NavEmpresarial />

    <h1 class="mt-20 text-3xl font-medium text-center">{ideaEmpresa.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la idea</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información de la idea.</p>
            {#if isSuperAdmin || checkPermission(authUser, [31])}
                <a use:inertia href={route('ideas-empresa.edit', [ideaEmpresa.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Descripción</p>
                <p class="whitespace-pre-line">{ideaEmpresa.descripcion}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Tipo</p>
                <p class="whitespace-pre-line">{ideaEmpresa.tipo}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Condición</p>
                <p class="whitespace-pre-line">{ideaEmpresa.condicion}</p>
            </div>

            {#if ideaEmpresa.tiene_equipos == true}
                <div class="py-8">
                    <p class="font-medium">Equipos</p>
                    {#if ideaEmpresa.equipos}
                        <ul>
                            {#each JSON.parse(ideaEmpresa.equipos) as equipo}
                                <li>
                                    {equipo.value}
                                </li>
                            {/each}
                        </ul>
                    {:else}
                        <p>Sin información registrada.</p>
                    {/if}
                </div>
            {/if}

            {#if ideaEmpresa.tiene_recursos == true}
                <div class="py-8">
                    <p class="font-medium">Recursos</p>
                    <p class="whitespace-pre-line">{ideaEmpresa.recursos}</p>
                </div>
            {/if}

            <div class="py-8">
                <p class="font-medium">Nombre de la empresa</p>
                <p class="whitespace-pre-line">{ideaEmpresa.empresa.nombre}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Dirección de la empresa</p>
                <p class="whitespace-pre-line">{ideaEmpresa.empresa.direccion}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Números de contacto de la empresa</p>
                <p class="whitespace-pre-line">{ideaEmpresa.empresa.numero_celular}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Correo electrónico de la empresa</p>
                <a href="mailto:{ideaEmpresa.empresa.email}" class="underline hover:cursor-pointer">{ideaEmpresa.empresa.email}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Responsable</p>
                <p class="whitespace-pre-line">{ideaEmpresa.empresa.user.name}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Número de teléfono / celular del responsable</p>
                <p class="whitespace-pre-line">{ideaEmpresa.empresa.user.numero_celular}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Correo electrónico del responsable</p>
                <a href="mailto:{ideaEmpresa.empresa.user.email}" class="underline hover:cursor-pointer">{ideaEmpresa.empresa.user.email}</a>
            </div>
        </div>
    </div>

    <hr class="block w-full my-10" />

    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Publicar respuesta</h3>
            <p class="mt-1 text-sm text-gray-600">Diligencia cada uno de los campos requeridos para publicar la respuesta, esta sera vista por la empresa responsable..</p>
        </div>
        <form on:submit|preventDefault={submit} class="col-span-2">
            <fieldset class="px-8">
                <div class="mt-4">
                    <Label required labelFor="titulo" value="Título" />
                    <Input id="titulo" type="text" class="mt-1" bind:value={$form.titulo} error={errors.titulo} required />
                </div>

                <div class="mt-4">
                    <Label required labelFor="descripcion" value="Descripción" />
                    <Textarea maxlength="40000" id="descripcion" bind:value={$form.descripcion} error={errors.descripcion} required />
                </div>

                <div class="mt-4">
                    <Label class="mb-4" labelFor="file" value="Documento" />
                    <File id="documento" type="file" accept="application/pdf" maxSize="10000" class="mt-1" bind:value={$form.documento} error={errors.documento} />
                </div>
            </fieldset>
            <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
                <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
            </div>
        </form>
    </div>

    {#if isSuperAdmin || ideaEmpresa.empresa_id == authUser.empresa_id}
        <hr class="block w-full my-10" />

        <div class="my-20 ml-20">
            <DataTable showSearchInput={false}>
                <div slot="title">Respuestas</div>

                <thead slot="thead">
                    <tr class="text-left font-bold">
                        <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Título </th>
                        <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Descripción </th>
                        <th class="px-6 pt-6 pb-4 sticky top-0 z-10 bg-white shadow-xl w-full"> Documento </th>
                    </tr>
                </thead>
                <tbody slot="tbody">
                    {#each respuestas as respuesta (respuesta.id)}
                        <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t">
                                <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                    {respuesta.titulo}
                                </p>
                            </td>
                            <td class="border-t">
                                <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">
                                    {respuesta.descripcion}
                                </p>
                            </td>

                            <td class="border-t">
                                {#if respuesta.documento}
                                    <a href={'/storage/' + respuesta.documento} target="_blank" class="px-6 py-4 underline hover:cursor-pointer"> Ver documento </a>
                                {:else}
                                    <p class="px-6 py-4 focus:text-gray-500 first-letter-uppercase">No se cargó ninún documento</p>
                                {/if}
                            </td>
                        </tr>
                    {/each}

                    {#if respuestas.length === 0}
                        <tr>
                            <td class="border-t px-6 py-4" colspan="4"> Sin información registrada </td>
                        </tr>
                    {/if}
                </tbody>
            </DataTable>
        </div>
    {/if}
</AuthenticatedLayout>
