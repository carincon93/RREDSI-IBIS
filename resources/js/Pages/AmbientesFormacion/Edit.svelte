<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { inertia, useForm, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import Form from './Form'

    export let errors
    export let institucionEducativa
    export let ambienteFormacion
    export let facultades
    export let disciplinasSubareaConocimiento
    export let disciplinasRelacionadas

    $: $title = 'Editar ambiente de formación'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let sending = false
    let form = useForm({
        _method: 'put',
        nombre: ambienteFormacion.nombre,
        tipo: ambienteFormacion.tipo,
        foto: null,
        nombre_responsable: ambienteFormacion.nombre_responsable,
        correo_responsable: ambienteFormacion.correo_responsable,
        celular_responsable: ambienteFormacion.celular_responsable,
        capacidad_aprox: ambienteFormacion.capacidad_aprox,
        descripcion: ambienteFormacion.descripcion,
        facultad_id: { value: ambienteFormacion.facultad_id, label: facultades.find((item) => item.value == ambienteFormacion.facultad_id)?.label },
        disciplina_subarea_conocimiento_id: disciplinasRelacionadas.length > 0 ? disciplinasRelacionadas : null,
    })

    function submit() {
        if (isSuperAdmin || checkPermission(authUser, [11])) {
            $form.post(route('instituciones-educativas.ambientes-formacion.update', [institucionEducativa.id, ambienteFormacion.id]), {
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
                    <a use:inertia href={route('instituciones-educativas.ambientes-formacion.index', institucionEducativa.id)} class="text-gray-500 hover:text-gray-600"> Ambientes de formación </a>
                    <span class="text-gray-500 font-medium">/</span>
                    Editar
                </h1>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-3 gap-6 my-20">
        <div class="col-span-1">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Información del ambiente de formación</h3>
            <p class="mt-1 text-sm text-gray-600">Ingrese nueva información para editar el ambiente de formación.</p>
            <figure class="mt-10 mb-10">
                <span class="font-medium">Foto</span>
                <img class="mx-auto" src={'/storage/' + ambienteFormacion.foto} alt="Foto {ambienteFormacion.nombre}" />
            </figure>
        </div>
        <div class="bg-white rounded shadow col-span-2">
            <Form {errors} {authUser} {submit} method="put" {facultades} {disciplinasSubareaConocimiento} {sending} {form} />
        </div>
    </div>
</AuthenticatedLayout>
