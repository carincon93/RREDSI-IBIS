<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'
    import { page } from '@inertiajs/inertia-svelte'
    import { checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import NavEmpresarial from './NavEmpresarial'
    import TodosProyectos from '../Proyectos/TodosProyectos'

    export let proyectos

    $: $title = 'Mis intereses'

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<AuthenticatedLayout>
    <NavEmpresarial />

    <div class="ml-20 mt-20">
        <h1 class="mt-10 text-3xl font-medium text-center">Mis intereses</h1>
        <TodosProyectos {proyectos} />
    </div>
</AuthenticatedLayout>
