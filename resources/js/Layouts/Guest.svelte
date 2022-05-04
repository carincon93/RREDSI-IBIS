<script context="module">
    import { writable } from 'svelte/store'
    export const title = writable(null)
</script>

<script>
    import { inertia } from '@inertiajs/inertia-svelte'
    import { route } from '@/Utils'
    import ApplicationLogo from '@/Shared/ApplicationLogo'
    import FlashMessages from '@/Shared/FlashMessages'

    $: props = {
        ...$$restProps,
        class: `min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 welcome-wallpaper ${$$restProps.class || ''}`,
    }
</script>

<svelte:head>
    <title>{$title ? `${$title} - RREDSI-IBIS` : 'RREDSI-IBIS'}</title>
</svelte:head>

<div {...props}>
    <div>
        <a use:inertia href={route('login')} class="flex items-center justify-center text-grayred-600 text-xl">
            <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <slot />
    </div>
    <FlashMessages />
</div>
