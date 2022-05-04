<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'

    import InfoMessage from '@/Shared/InfoMessage'

    $: $title = 'Connect'

    export let nodo
    export let estudios
</script>

<AuthenticatedLayout>
    <div class="mb-20">
        <div class="grid grid-cols-2 min-h-[32.6rem] relative">
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl text-left font-extrabold">
                    <span class="block text-blue-900 xl:inline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 20 20" class="inline mb-2">
                            <path
                                d="M14.03,12.914l-5.82,2.66a1.288,1.288,0,0,0-.636.636l-2.66,5.82A.8.8,0,0,0,5.97,23.086l5.82-2.66a1.288,1.288,0,0,0,.636-.636l2.66-5.82a.8.8,0,0,0-1.056-1.056Zm-3.119,6a1.288,1.288,0,1,1,0-1.821A1.288,1.288,0,0,1,10.91,18.91ZM10,8A10,10,0,1,0,20,18,10,10,0,0,0,10,8Zm0,18.065A8.065,8.065,0,1,1,18.065,18,8.074,8.074,0,0,1,10,26.065Z"
                                transform="translate(0 -8)"
                                fill="#1e3a8a"
                            />
                        </svg>
                        Connect: Conecte con jóvenes investigadores
                    </span>
                </h1>
                <p class="mt-8 pr-10">
                    Fortalezca los resultados de su proyecto conectando con jóvenes investigadores de otras áreas de conocimiento y de instituciones educativas cómo:{#each nodo.instituciones_educativas as institucionEducativa} {institucionEducativa.nombre},{/each}
                </p>
            </div>
            <figure class="absolute right-[-17rem] top-[-4rem]" style="clip-path: polygon(21% 0%, 100% 0%, 100% 100%, 0% 100%);">
                <img src="/storage/images/AdobeStock_Student.jpeg" alt="" class="w-[1000px] h-[667px] object-cover" />
            </figure>
        </div>

        <div class="mt-44">
            <h1 class="text-center text-2xl mb-12">A continuación, se muestran los programas de formación de las {nodo.instituciones_educativas.length} instituciones educativas adscritas a RREDSI Nodo {nodo.departamento}. Por favor seleccione un programa de formación y conecte con estudiantes relacionados.</h1>

            <ul class="grid grid-cols-4 gap-3 mt-20">
                {#each estudios as estudio}
                    <li>
                        <a class="h-52 flex items-center justify-center shadow" use:inertia href={route('nodos.explorer.rol-programa', [nodo, estudio.programa_academico])}>
                            {estudio.programa_academico}
                        </a>
                    </li>
                {/each}
            </ul>
            {#if estudios.length == 0}
                <InfoMessage alertMsg={true} class="w-full">Sin información registrada.</InfoMessage>
            {/if}
        </div>
    </div>
</AuthenticatedLayout>
