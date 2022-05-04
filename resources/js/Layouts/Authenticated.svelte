<script context="module">
    import { writable } from 'svelte/store'
    export const title = writable(null)
    export const permissions = writable(null)
</script>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'
    import { _ } from 'svelte-i18n'

    import ApplicationLogo from '@/Shared/ApplicationLogo'
    import Dropdown from '@/Shared/Dropdown'
    import Icon from '@/Shared/Icon'
    import ResponsiveNavLink from '@/Shared/ResponsiveNavLink'
    import FlashMessages from '@/Shared/FlashMessages'
    import Loading from '@/Shared/Loading'
    import Menu from '@/Shared/Menu'

    let showingNavigationDropdown = false

    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])

    let loading = true
    Inertia.on('start', () => {
        loading = false
    })
    Inertia.on('finish', () => {
        loading = true
    })

    let navOpen = true
    function handleNav() {
        navOpen = !navOpen
    }

    $: props = {
        ...$$restProps,
        class: `${route().current('home') ? 'bg-blue-900' : ''} ${$$restProps.class || ''}`,
    }
</script>

<svelte:head>
    <title>{$title ? `${$title} - RREDSI-IBIS` : 'RREDSI-IBIS'}</title>
</svelte:head>

<div {...props}>
    <div class="min-h-screen">
        <nav class="bg-blue-900 border-b border-blue-500 left-0 right-0 shadow-md top-0 z-50{route().current('home') ? ' hidden' : ''}">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <ApplicationLogo class="fill-white" />
                            <a use:inertia href={route('home')} class="text-white ml-10"> Menú principal </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex sm:items-center" />
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <Dropdown class="rounded border-b-2 flex h-full items-center justify-center px-4 py-2 shadow text-white" placement="bottom-end">
                            <div class="flex items-center cursor-pointer select-none group">
                                <span class="border mr-3 rounded shadow-md p-[3px]">
                                    <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="compass" class="svg-inline--fa fa-compass fa-w-16 text-white" style="width: 18px;" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                        <path
                                            fill="currentColor"
                                            d="M347.94 129.86L203.6 195.83a31.938 31.938 0 0 0-15.77 15.77l-65.97 144.34c-7.61 16.65 9.54 33.81 26.2 26.2l144.34-65.97a31.938 31.938 0 0 0 15.77-15.77l65.97-144.34c7.61-16.66-9.54-33.81-26.2-26.2zm-77.36 148.72c-12.47 12.47-32.69 12.47-45.16 0-12.47-12.47-12.47-32.69 0-45.16 12.47-12.47 32.69-12.47 45.16 0 12.47 12.47 12.47 32.69 0 45.16zM248 8C111.03 8 0 119.03 0 256s111.03 248 248 248 248-111.03 248-248S384.97 8 248 8zm0 448c-110.28 0-200-89.72-200-200S137.72 56 248 56s200 89.72 200 200-89.72 200-200 200z"
                                        />
                                    </svg>
                                </span>
                                Explorador
                                <Icon name="cheveron-down" class="ml-2 w-5 h-5  fill-white " />
                            </div>
                            <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                                {#each $page.props.auth.nodos as nodo}
                                    <a use:inertia href={route('nodos.explorer', nodo.id)} class="flex items-center px-6 py-2 hover:bg-blue-900 hover:text-white">
                                        <span>{nodo.departamento}</span>
                                    </a>
                                {/each}
                            </div>
                        </Dropdown>

                        <!-- Settings Dropdown -->
                        <div class="mr-5 ml-5 relative">
                            <!-- <a use:inertia href={route('notificaciones.index')} class="flex items-center hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                {#if $page.props.auth.numeroNotificaciones > 0}
                                    <span class="absolute bg-gray-700 flex h-5/6 items-center justify-center rounded-full text-center text-white text-xs w-5/6" style="top: -10px; left: 10px;">{$page.props.auth.numeroNotificaciones}</span>
                                {/if}
                            </a> -->
                        </div>
                        <div class="ml-3 relative">
                            <Dropdown class="mt-1" placement="bottom-end">
                                <div class="flex items-center cursor-pointer select-none group">
                                    <div class="text-white  mr-1 whitespace-no-wrap">
                                        <span class="capitalize">{authUser.name}</span>
                                    </div>
                                    <Icon name="cheveron-down" class="w-5 h-5  fill-white " />
                                </div>
                                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                                    {#if authUser.institucion_educativa_id}
                                        <a use:inertia href={route('estudios.index')} class="flex items-center px-6 py-2 hover:bg-gray-500 hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                            </svg>
                                            <span class="ml-1.5">Mis estudios</span>
                                        </a>
                                    {/if}

                                    <a use:inertia href={route('users.perfil')} class="flex items-center px-6 py-2 hover:bg-gray-500 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="ml-1.5">Perfil</span>
                                    </a>

                                    <a use:inertia={{ method: 'post' }} href={route('logout')} class="flex items-center px-6 py-2 hover:bg-gray-500 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-1.5">{$_('Logout')}</span>
                                    </a>
                                </div>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <!-- <div class="-mr-2 flex items-center sm:hidden">
                        <button on:click={showingNavigationDropdown = ! showingNavigationDropdown} class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="{showingNavigationDropdown ? 'hidden': '', ! showingNavigationDropdown ? 'inline-flex': ''}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path class="{! showingNavigationDropdown ? 'hidden': '', showingNavigationDropdown ? 'inline-flex': ''}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div> -->
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div class="sm:hidden{(showingNavigationDropdown ? ' block' : '', !showingNavigationDropdown ? ' hidden' : '')}">
                <div class="pt-2 pb-3 space-y-1" />

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="font-medium text-base text-gray-800">
                            {authUser.name}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {authUser.email}
                        </div>
                    </div>

                    {#if authUser.institucion_educativa_id}
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink href={route('estudios.index')} method="post" as="button">Mis estudios</ResponsiveNavLink>
                        </div>
                    {/if}

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink href={route('logout')} method="post" as="button">
                            {$_('Logout')}
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        {#if $$slots.header}
            <div class="absolute left-0 right-0 top-[4rem] z-50">
                <slot name="header" />
            </div>
        {/if}

        <!-- Page Content -->
        <main class="overflow-x-hidden">
            <FlashMessages />
            <Loading {loading} />
            <!-- <Menu class="transition ease-in-out delay-150{navOpen ? '' : ' close'}" /> -->
            <div class={route().current('nodos.explorer') ? '' : 'max-w-7xl mx-auto'}>
                <slot />
            </div>
        </main>
    </div>
</div>
