<script>
    import AuthenticatedLayout, { title } from '@/Layouts/Authenticated'

    import DetallesUser from '../../Users/DetallesUser'

    export let user
</script>

<AuthenticatedLayout>
    <DetallesUser {user} />
</AuthenticatedLayout>
