<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let lineaInvestigacion
    export let institucionEducativa
    export let areasConocimiento
    export let gruposInvestigacion

    $: $title = 'Editar línea de investigación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        area_conocimiento_id: { value: lineaInvestigacion.area_conocimiento_id, label: gruposInvestigacion.find((item) => item.value == lineaInvestigacion.area_conocimiento_id)?.label },
        grupo_investigacion_id: { value: lineaInvestigacion.grupo_investigacion_id, label: gruposInvestigacion.find((item) => item.value == lineaInvestigacion.grupo_investigacion_id)?.label },
        nombre: lineaInvestigacion.nombre,
        objetivos: lineaInvestigacion.objetivos,
        mision: lineaInvestigacion.mision,
        vision: lineaInvestigacion.vision,
        logros: lineaInvestigacion.logros,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [5])) {
            $form.put(route('instituciones-educativas.lineas-investigacion.update', [institucionEducativa.id, lineaInvestigacion.id]), {
                onStart: () => (sending = true),
                onFinish: () => (sending = false),
                preserveScroll: true,
            })
        }
    }
</script>

<AuthenticatedLayout>
    <header slot="header" class="bg-white">
        <div class="flex items-center justify-between max-w-7xl mx-auto py-6">
            <div>
                <h1>
                    <a use:inertia href={route('instituciones-educativas.lineas-investigacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Líneas de investigación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información de la línea de investigación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar la línea de investigación.</p>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} {gruposInvestigacion} {areasConocimiento} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
