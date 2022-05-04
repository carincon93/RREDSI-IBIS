<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from '../DashboardEmpresa/NavEmpresarial'

    export let producto

    $: $title = 'Detalles de la producto'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('productos.index')} class="text-gray-500 hover:text-gray-600"> Productos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Ver detalles
                </h1>
            </div>
        </div>
    </header>

    <NavEmpresarial />

    <h1 class="mt-20 text-3xl font-medium text-center">{producto.nombre}</h1>
    <div class="grid grid-cols-3 gap-6 my-20 ml-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del producto</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información del producto.</p>
            {#if isSuperAdmin || (checkPermission(authUser, [27]) && producto.empresa_id == authUser.empresa_id)}
                <a use:inertia href={route('productos.edit', [producto.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Descripción</p>
                <p class="whitespace-pre-line">{producto.descripcion}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Imagen</p>
                <figure>
                    <img src={'/storage/' + producto.image} alt={'Imagen ' + producto.nombre} />
                </figure>
            </div>

            <div class="py-8">
                <p class="font-medium">Nombre de la empresa</p>
                <p class="whitespace-pre-line">{producto.empresa.nombre}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Dirección de la empresa</p>
                <p class="whitespace-pre-line">{producto.empresa.direccion}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Números de contacto de la empresa</p>
                <p class="whitespace-pre-line">{producto.empresa.numero_celular}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Correo electrónico de la empresa</p>
                <a href="mailto:{producto.empresa.email}" class="underline hover:cursor-pointer">{producto.empresa.email}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Responsable</p>
                <p class="whitespace-pre-line">{producto.empresa.user.name}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Número de teléfono / celular del responsable</p>
                <p class="whitespace-pre-line">{producto.empresa.user.numero_celular}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Correo electrónico del responsable</p>
                <a href="mailto:{producto.empresa.user.email}" class="underline hover:cursor-pointer">{producto.empresa.user.email}</a>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
