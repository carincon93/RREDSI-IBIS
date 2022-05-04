<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'

    export let evento

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<div class="mb-20">
    <div class="grid grid-cols-2 min-h-[32.6rem] relative">
        <div class="flex flex-col justify-center">
            <h1 class="text-3xl text-left font-extrabold pr-8">
                <span class="block text-blue-900 xl:inline">
                    {evento.nombre}
                </span>
            </h1>
        </div>
        <figure class="absolute right-[-14rem] top-[-4rem]" style="clip-path: polygon(21% 0%, 100% 0%, 100% 100%, 0% 100%);">
            <img src={'/storage/' + evento.imagen_principal} alt="" class="w-[1000px] h-[667px] object-cover" />
        </figure>
    </div>

    <hr class="block my-20" />

    <p class="font-medium">Facultad</p>
    <p class="mt-2">{evento.nombre}</p>

    <p class="font-medium mt-4">Institución educativa</p>
    <div class="flex items-center mt-2">
        <figure class="mr-2">
            <img src="/storage/{evento.institucion_educativa.logo}" class="h-8" alt="Logo {evento.institucion_educativa.nombre}" />
        </figure>
        <p>{evento.institucion_educativa.nombre}</p>
    </div>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Descripción del evento</h1>
    <p class="whitespace-pre-line text-justify">{evento.descripcion}</p>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Objetivos del evento</h1>
    <p class="whitespace-pre-line text-justify">{evento.objetivos}</p>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Cronograma</h1>
    <p class="whitespace-pre-line text-justify">{evento.cronograma}</p>

    {#if evento.afiche}
        <hr class="block my-20" />

        <h1 class="text-2xl mb-5">Afiche</h1>
        <figure class="mr-2 flex justify-center">
            <img src="/storage/{evento.afiche}" alt="Logo {evento.nombre}" />
        </figure>
    {/if}

    <div class="grid grid-cols-3 gap-6 mt-44 mb-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del evento</h3>
            <p class="mt-1 text-sm text-gray-600">Revise la información del evento.</p>
            {#if isSuperAdmin || checkPermission(authUser, [15])}
                <a use:inertia href={route('instituciones-educativas.eventos.edit', [evento.institucion_educativa.id, evento.id])} class="text-sm underline text-gray-500">Editar la información</a>
            {/if}
        </div>
        <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Correo electrónico</p>
                <p class="whitespace-pre-line">{evento.descripcion}</p>
            </div>
            <div class="py-8">
                <p class="font-medium">Ubicación</p>
                <p>{evento.ubicacion}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Fechas del evento</p>
                <p>{evento.datesForHumans}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Enlace de la página de registro</p>
                <a href={evento.link_registro} class="underline" target="_blank">{evento.link_registro}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Enlace para ofrecer más información</p>
                <a href={evento.info_link} class="underline" target="_blank">{evento.info_link}</a>
            </div>
        </div>
    </div>
</div>
