<script>
    import InfoMessage from '@/Shared/InfoMessage'
    import Dialog from '@/Shared/Dialog'
    import Button from '@/Shared/Button'

    let dialogOpen = false

    export let ambienteFormacion
</script>

<div class="mb-20">
    <div class="grid grid-cols-2 min-h-[32.6rem] relative">
        <div class="flex flex-col justify-center">
            <h1 class="text-3xl text-left font-extrabold">
                <span class="block text-blue-900 xl:inline">
                    {ambienteFormacion.nombre}
                </span>
            </h1>
        </div>
        <figure class="absolute right-[-14rem] top-[-4rem]" style="clip-path: polygon(21% 0%, 100% 0%, 100% 100%, 0% 100%);">
            <img src={'/storage/' + ambienteFormacion.foto} alt="" class="w-[1000px] h-[667px] object-cover" />
        </figure>
    </div>

    <hr class="block my-20" />

    <p class="font-medium">Facultad</p>
    <p class="mt-2">{ambienteFormacion.facultad.nombre}</p>

    <p class="font-medium mt-4">Institución educativa</p>
    <div class="flex items-center mt-2">
        <figure class="mr-2">
            <img src="/storage/{ambienteFormacion.facultad.institucion_educativa.logo}" class="h-8" alt="Logo {ambienteFormacion.facultad.institucion_educativa.nombre}" />
        </figure>
        <p>{ambienteFormacion.facultad.institucion_educativa.nombre}</p>
    </div>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Descripción del ambiente</h1>
    <p class="whitespace-pre-line text-justify">{ambienteFormacion.descripcion}</p>

    <hr class="block my-20" />

    <h1 class="text-2xl mb-5">Disciplinas asociadas</h1>
    <ul>
        {#each ambienteFormacion.disciplinas_subarea_conocimiento as disciplina}
            <li>{disciplina.nombre}</li>
        {/each}
    </ul>

    <button type="button" on:click={() => (dialogOpen = true)} class="fixed right-8 bottom-4 bg-blue-900 text-white p-4 rounded-full shadow flex">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <p class="ml-2">Más información</p>
    </button>
</div>

<Dialog bind:open={dialogOpen}>
    <div slot="title" class="flex items-center mb-8">
        <InfoMessage>Por favor póngase en contacto con el responsable del ambiente</InfoMessage>
    </div>
    <div slot="content">
        <h1 class="font-black mb-4">
            <div class="flex items-center mt-2">
                <figure class="mr-2">
                    <img src="/storage/{ambienteFormacion.facultad.institucion_educativa.logo}" class="h-8" alt="Logo {ambienteFormacion.facultad.institucion_educativa.nombre}" />
                </figure>
                <p>{ambienteFormacion.facultad.institucion_educativa.nombre}</p>
            </div>
        </h1>

        <ul>
            <li class="mb-4">
                <div>
                    <span>Responsable: </span>
                    {ambienteFormacion.nombre_responsable}
                    <br />
                    <span>Correo electrónico: </span>
                    <a href="mailto:{ambienteFormacion.correo_responsable}" class="underline">{ambienteFormacion.correo_responsable}</a>
                </div>
            </li>
        </ul>
    </div>
    <div slot="actions">
        <div class="p-4">
            <Button on:click={(event) => (dialogOpen = false)} variant={null}>Salir</Button>
        </div>
    </div>
</Dialog>
