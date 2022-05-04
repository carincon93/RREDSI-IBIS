<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    export let eventoRredsiDepartamental

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    eventoRredsiDepartamental.areas_conocimiento = JSON.parse(eventoRredsiDepartamental.areas_conocimiento)
</script>

<h1 class="mt-40 text-3xl font-medium text-center">{eventoRredsiDepartamental.titulo}</h1>

<figure class="flex justify-center my-40">
    <img src={'/storage/' + eventoRredsiDepartamental.afiche} alt="" />
</figure>

<div class="grid grid-cols-3 gap-6 my-20">
    <div class="col-span-1">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Información del evento</h3>
        <p class="mt-1 text-sm text-gray-600">Revise la información del evento.</p>
        {#if isSuperAdmin || checkPermission(authUser, [21])}
            <a use:inertia href={route('nodos.eventos-rredsi-departamental.edit', [eventoRredsiDepartamental.nodo_id, eventoRredsiDepartamental.id])} class="text-sm underline text-gray-500">Editar la información</a>
        {/if}
    </div>
    <div class="bg-white rounded shadow col-span-2 p-8 divide-y">
        <div class="py-8">
            <p class="font-medium mt-4">Institución educativa donde se realiza el evento</p>
            <div class="flex items-center mt-2">
                <figure class="mr-2">
                    <img src="/storage/{eventoRredsiDepartamental.institucion_educativa.logo}" class="h-8" alt="Logo {eventoRredsiDepartamental.institucion_educativa.nombre}" />
                </figure>
                <p>{eventoRredsiDepartamental.institucion_educativa.nombre}</p>
            </div>
        </div>

        <div class="py-8">
            <p class="font-medium">Fecha de realización del evento</p>
            <p>{eventoRredsiDepartamental.datesForHumans}</p>
        </div>

        <div class="py-8">
            <p class="font-medium">Introducción</p>
            <p class="whitespace-pre-line">{eventoRredsiDepartamental.introduccion}</p>
        </div>

        <div class="py-8">
            <p class="font-medium">Objetivos</p>
            <p class="whitespace-pre-line">{eventoRredsiDepartamental.objetivos}</p>
        </div>

        <div class="py-8">
            <p class="font-medium">Cronograma</p>
            <p class="whitespace-pre-line">{eventoRredsiDepartamental.cronograma}</p>
        </div>

        <div class="py-8">
            <p class="font-medium">Áreas de conocimiento</p>
            <ul>
                {#each eventoRredsiDepartamental.areas_conocimiento as areaConocimiento}
                    <li>{areaConocimiento.value}</li>
                {/each}
            </ul>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver formato guía de ponencia</p>
            <a href={'/storage/' + eventoRredsiDepartamental.formato_guia_ponencia} class="underline" target="_blank">{eventoRredsiDepartamental.formato_guia_ponencia}</a>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver carta aval de ponencia</p>
            <a href={'/storage/' + eventoRredsiDepartamental.carta_aval_ponencia} class="underline" target="_blank">{eventoRredsiDepartamental.carta_aval_ponencia}</a>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver plantilla de presentación de ponencia</p>
            <a href={'/storage/' + eventoRredsiDepartamental.plantilla_presentacion_ponencia} class="underline" target="_blank">{eventoRredsiDepartamental.plantilla_presentacion_ponencia}</a>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver formato guía de póster</p>
            <a href={'/storage/' + eventoRredsiDepartamental.formato_guia_poster} class="underline" target="_blank">{eventoRredsiDepartamental.formato_guia_poster}</a>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver carta aval de póster</p>
            <a href={'/storage/' + eventoRredsiDepartamental.carta_aval_poster} class="underline" target="_blank">{eventoRredsiDepartamental.carta_aval_poster}</a>
        </div>

        <div class="py-8">
            <p class="font-medium">Ver plantilla de presentación de póster</p>
            <a href={'/storage/' + eventoRredsiDepartamental.plantilla_presentacion_poster} class="underline" target="_blank">{eventoRredsiDepartamental.plantilla_presentacion_poster}</a>
        </div>
    </div>
</div>
