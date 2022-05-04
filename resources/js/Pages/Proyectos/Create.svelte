<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'
    import Dialog from '@/Shared/Dialog'
    import Button from '@/Shared/Button'

    export let errors
    export let institucionEducativa
    export let facultades
    export let users
    export let tiposProyecto
    export let semillerosInvestigacion
    export let lineasInvestigacion
    export let disciplinasSubareaConocimiento
    export let programasAcademicos

    let dialogOpen = true

    $: $title = 'Crear facultad'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        titulo: '',
        fecha_inicio: '',
        fecha_finalizacion: '',
        resumen: '',
        palabras_clave: '',
        file: null,
        objetivo_general: '',
        privado: false,
        descripcion_requerimiento_rol: '',
        requerimientos_roles: '',
        requerimientos_equipos_descripcion: '',
        requerimientos_equipos: '',
        main_image: null,
        tipo_proyecto_id: null,
        facultad_id: null,
        semillero_investigacion_id: null,
        linea_investigacion_id: null,
        disciplina_subarea_conocimiento_id: null,
        programa_academico_id: null,
        facultad_id: null,
        user_id: null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [13])) {
            $form.post(route('instituciones-educativas.proyectos.store', institucionEducativa.id), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('instituciones-educativas.proyectos.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Proyectos </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Crear
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del proyecto</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese la siguiente información para crear un nuevo proyecto.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {facultades} {tiposProyecto} {users} {semillerosInvestigacion} {lineasInvestigacion} {disciplinasSubareaConocimiento} {programasAcademicos} {sending} {form} />
        </div>
    </div>

    <Dialog bind:open={dialogOpen}>
        <div slot="title" class="flex items-center">Importante</div>
        <div slot="content">
            <p>
                Al cargar un trabajo de manera pública en la plataforma RREDSI, usted nos otorga el derecho para publicar, poner a disposición, enlazar y utilizar dicho trabajo en medios (ya sean conocidos o desarrollados posteriormente por la Red Regional de Semilleros de Investigación). No podrá realizar ningún envío de forma anónima, así ​​garantiza y declara que dicho trabajo es original y ha
                sido escrito por usted. <br /><br /> El trabajo que usted intenta cargar a la plataforma será revisado en algún momento por el delegado de su institución educativa y de ser pertinente podrá ser eliminado a criterio. Al publicar dicho trabajo, también garantiza y declara que posee o controla todos los derechos de su trabajo, incluidos, entre otros, todos los derechos necesarios para
                otorgar el permiso especificado anteriormente. <br /><br /> No puede utilizar los servicios de la plataforma RREDSI para publicar o distribuir información que sea ilegal, que viole o infrinja los derechos de cualquier otra persona, que sea difamatoria, abusiva, odiosa, profana, pornográfica, amenazante o vulgar, que contiene errores, virus u otros componentes dañinos, o que de otro
                modo sea procesable por ley. RREDSI puede en cualquier momento ejercer control editorial sobre el contenido de los trabajos. <br /> <br /> Tendremos el derecho de monitorear los trabajos para determinar el cumplimiento de estos Términos y Condiciones y cualquier regla operativa que establezcamos y para satisfacer cualquier ley, reglamento o solicitud gubernamental autorizada. Tendremos
                el derecho, a nuestro exclusivo criterio, de editar, negarnos a publicar o eliminar cualquier trabajo. Importante: si el trabajo está en proceso de ser una patente, invención o modelo de utilidad se recomienda no ser enviado a la plataforma o debe tener la opción 'Privacidad del proyecto' en 'SI'.
            </p>
        </div>
        <div slot="actions">
            <div class="p-4">
                <Button on:click={(event) => (dialogOpen = false)} variant={null}>Aceptar</Button>
            </div>
        </div>
    </Dialog>
</AuthenticatedLayout>
