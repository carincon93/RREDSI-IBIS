import { addMessages, init } from 'svelte-i18n'
import { createInertiaApp } from '@inertiajs/inertia-svelte'
import { InertiaProgress } from '@inertiajs/progress'

import es from '../lang/es.json'

addMessages('es', es)

init({
    initialLocale: 'es',
})

InertiaProgress.init({ color: '#395cc2' })

createInertiaApp({
    resolve: (name) => import(`@/Pages/${name}.svelte`),
    setup({ el, App, props }) {
        new App({ target: el, props })
    },
})
