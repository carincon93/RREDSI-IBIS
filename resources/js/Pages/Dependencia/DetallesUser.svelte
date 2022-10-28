<script>
    export let user
</script>

<h1 class="mt-10 text-3xl font-medium text-center">{user.name}</h1>

<div class="mb-20">
    {#if user.institucion_educativa}
        <p class="font-medium mt-4">Institución educativa</p>
        <div class="flex items-center mt-2">
            <figure class="mr-2">
                <img src="/storage/{user.institucion_educativa.logo}" class="h-8" alt="Logo {user.institucion_educativa.nombre}" />
            </figure>
            <p>{user.institucion_educativa.nombre}</p>
        </div>

        <hr class="block my-20" />
    {/if}

    <h1 class="text-2xl mt-20 mb-5">Perfil</h1>
    <p class="whitespace-pre-line text-justify">{user.perfil ? user.perfil : 'Sin información registrada.'}</p>

    <hr class="block my-20" />

    <div class="grid grid-cols-2 gap-3 mt-20">
        <div>
            <h1 class="font-medium">Información</h1>
            <p class="mt-1 text-sm text-gray-600">Revise la información del usuario.</p>
        </div>

        <div class="bg-white rounded shadow p-8 divide-y">
            <div class="py-8">
                <p class="font-medium">Correo electrónico</p>
                <a href="mailto:{user.email}">{user.email}</a>
            </div>

            <div class="py-8">
                <p class="font-medium">Número de celular</p>
                <p>{user.numero_celular}</p>
            </div>

            <div class="py-8">
                <p class="font-medium">Intereses profesionales y formativos</p>
                {#if user.intereses}
                    <ul>
                        {#each JSON.parse(user.intereses) as interes}
                            <li>
                                {interes.value}
                            </li>
                        {/each}
                    </ul>
                {:else}
                    <p>Sin información registrada.</p>
                {/if}
            </div>

            <div class="py-8">
                <p class="font-medium">CvLAC</p>
                {#if user.cvlac}
                    <a href={user.cvlac} target="_blank" class="underline">Ver CvLAC</a>
                {:else}
                    <p>Sin información registrada.</p>
                {/if}
            </div>

            <div class="py-8">
                <p class="font-medium">Hoja de vida</p>
                {#if user.cv}
                    <a href={'/storage/' + user.cv} target="_blank" class="underline">Ver hoja de vida</a>
                {:else}
                    <p>Sin información registrada.</p>
                {/if}
            </div>

            <div class="py-8">
                <p class="font-medium">Estudios</p>
                <ul>
                    {#each user.estudios as estudio}
                        <li class="mb-4">
                            Programa académico: {estudio.programa_academico}
                            <br />
                            <span class="text-xs">Institución educativa: {estudio.institucion_educativa}</span>
                        </li>
                    {/each}
                    {#if user.estudios.length == 0}
                        <li>Sin información registrada.</li>
                    {/if}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Semilleros de investigación asociados</p>
                <ul>
                    {#each user.semilleros_investigacion as semillero_investigacion}
                        <li>{semillero_investigacion.nombre}</li>
                    {/each}
                    {#if user.semilleros_investigacion.length == 0}
                        <li>Sin información registrada.</li>
                    {/if}
                </ul>
            </div>

            <div class="py-8">
                <p class="font-medium">Proyectos asociados</p>
                <ul>
                    {#each user.proyectos as proyecto}
                        <li>{proyecto.titulo}</li>
                    {/each}
                    {#if user.proyectos.length == 0}
                        <li>Sin información registrada.</li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
</div>
