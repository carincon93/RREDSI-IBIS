<script>
    import { _ } from 'svelte-i18n'
    import Menu from '@smui/menu'
    import List from '@smui/list'
    import Button from '@smui/button'
    import { onMount } from 'svelte'

    let menu
    let container

    $: props = {
        ...$$restProps,
        class: `${$$restProps.class || ''}`,
    }

    onMount(() => {
        let ul = container.getElementsByTagName('ul')

        for (var i = 0, max = ul.length; i < max; i++) {
            if (ul[i].childElementCount == 0) {
                ul[i].innerHTML += '<li class="mdc-deprecated-list-item mdc-ripple-upgraded" role="menuitem" aria-disabled="false" tabindex="0" style=""><span class="mdc-deprecated-list-item__ripple"></span><span class="mdc-deprecated-list-item__text">No tiene permisos</span></li>'
            }
        }
    })
</script>

<div style="min-width: 100px;" {...props} class="relative flex justify-center" bind:this={container}>
    <Button on:click={() => menu.setOpen(true)}>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
        </svg>
    </Button>
    <Menu bind:this={menu}>
        <List>
            <slot />
        </List>
    </Menu>
</div>
