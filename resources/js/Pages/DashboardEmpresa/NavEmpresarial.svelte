<script>
    import { inertia, page } from '@inertiajs/inertia-svelte'
    import { route, checkRole, checkPermission } from '@/Utils'

    let observatorioDropdown = false
    let ideasDropdown = false
    let blogDropdown = false
    let proveedorDropdown = false

    /**
     * Permisos
     */
    let authUser = $page.props.auth.user
    let isSuperAdmin = checkRole(authUser, [1])
</script>

<nav class="absolute flex-grow overflow-y-autox w-[14.5rem] left-0">
    <a use:inertia href={route('dashboard-empresa')} class="w-full flex items-center md:mt-1/6 py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
        <svg class="mr-1/12 ml-1 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="width: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
            <polyline points="9 22 9 12 15 12 15 22" />
        </svg>
        <span class="text-gray-700 min-w-[75%] ml-4">Panel empresarial</span>
    </a>

    <hr class="mb-1/6 mt-1/6" />

    <div>
        <div on:click={() => (observatorioDropdown = !observatorioDropdown)} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-1/12 ml-1 text-black" style="width: 18px;" viewBox="0 0 32 32">
                <path d="M406-333.194h8.645V-344H406v10.806Zm0,8.645h8.645v-6.484H406v6.484Zm10.806,0h8.645v-10.806h-8.645v10.806Zm0-19.452v6.484h8.645V-344Z" transform="translate(-399.516 350.484)" fill-rule="evenodd" />
            </svg>
            <span class="text-gray-700 min-w-[75%] ml-4">Observatorio</span>
            <svg class="h-4 w-4 transition-all delay-75{observatorioDropdown || route().current('proyectos-empresa.*') || route().current('observatorio-empresarial') ? ' rotate-90 ' : ''}" viewBox="-10 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        {#if observatorioDropdown || route().current('proyectos-empresa.*') || route().current('observatorio-empresarial')}
            <div>
                <a use:inertia href={route('proyectos-empresa.index')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('proyectos-empresa.index') ? 'bg-gray-100' : ''}">
                    <span class="text-gray-700 pl-[35px]">Mis intereses</span>
                </a>
                <a use:inertia href={route('observatorio-empresarial')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('observatorio-empresarial') ? 'bg-gray-100' : ''}">
                    <span class="text-gray-700 pl-[35px]">Ver proyectos</span>
                </a>
            </div>
        {/if}
    </div>

    {#if isSuperAdmin || checkPermission(authUser, [31, 32])}
        <div>
            <div on:click={() => (ideasDropdown = !ideasDropdown)} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <span class="text-gray-700 min-w-[75%] ml-4">Ideas empresariales</span>
                <span>
                    <svg class="h-4 w-4 transition-all delay-75{ideasDropdown || route().current('ideas-empresa.*') || route().current('empresa.ideas-retos') ? ' rotate-90 ' : ''}" viewBox="-10 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
            {#if ideasDropdown || route().current('ideas-empresa.*') || route().current('empresa.ideas-retos')}
                <div>
                    <a use:inertia href={route('ideas-empresa.index')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('ideas-empresa.index') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px]">Mis ideas</span>
                    </a>

                    <a use:inertia href={route('ideas-empresa.ideas-retos')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('ideas-empresa.ideas-retos') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px]">Ideas y retos</span>
                    </a>
                </div>
            {/if}
        </div>
    {/if}

    {#if isSuperAdmin || checkPermission(authUser, [29, 30])}
        <div>
            <div on:click={() => (blogDropdown = !blogDropdown)} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="mr-1/12 ml-1 text-black" style="width: 18px;" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-gray-700 min-w-[75%] ml-4">Blog de experiencias</span>
                <span>
                    <svg class="h-4 w-4 transition-all delay-75{blogDropdown || route().current('experiencias.*') || route().current('experiencias.buscar-experiencias') ? ' rotate-90 ' : ''}" viewBox="-10 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>

            {#if blogDropdown || route().current('experiencias.*') || route().current('experiencias.buscar-experiencias')}
                <div>
                    <a use:inertia href={route('experiencias.index')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('experiencias.index') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px]">Mis experiencias</span>
                    </a>
                    <a use:inertia href={route('experiencias.buscar-experiencias')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('experiencias.buscar-experiencias') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px]">Ver experiencias</span>
                    </a>
                </div>
            {/if}
        </div>
    {/if}

    {#if isSuperAdmin || checkPermission(authUser, [27, 28])}
        <div>
            <div on:click={() => (proveedorDropdown = !proveedorDropdown)} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="17.216" height="15.209" viewBox="0 0 17.216 15.209" class="mr-1/12 ml-1 text-black" style="width: 18px;">
                    <path
                        id="Path_109"
                        data-name="Path 109"
                        d="M16.531,13.434a1.651,1.651,0,0,0-.844-.452l-1.971-.394a4.953,4.953,0,0,0-3.187.427l-.263.13a4.953,4.953,0,0,1-3.187.427l-1.594-.319A1.651,1.651,0,0,0,4,13.706M7.1,4h6.6l-.826.826V9.1a1.651,1.651,0,0,0,.484,1.167l4.128,4.128a1.651,1.651,0,0,1-1.168,2.818H4.478A1.651,1.651,0,0,1,3.311,14.39l4.128-4.128A1.651,1.651,0,0,0,7.923,9.1V4.826Z"
                        transform="translate(-1.791 -3)"
                        fill="#fff"
                        stroke="#000"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                    />
                </svg>
                <span class="text-gray-700 min-w-[75%] ml-4">Proveedores</span>
                <span>
                    <svg class="h-4 w-4 transition-all delay-75{proveedorDropdown || route().current('productos.*') || route().current('productos.buscar-proveedores') ? ' rotate-90 ' : ''}" viewBox="-10 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>

            {#if proveedorDropdown || route().current('productos.*') || route().current('productos.buscar-proveedores')}
                <div>
                    <a use:inertia href={route('productos.index')} class="mr-2 block w-full py-2 text-sm text-blue-900 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('productos.*') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px] ">Mis productos y servicios</span>
                    </a>
                    <a use:inertia href={route('productos.buscar-proveedores')} class="mr-2 block w-full py-2 text-sm text-blue-900  hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4 {route().current('productos.buscar-proveedores') ? 'bg-gray-100' : ''}">
                        <span class="text-gray-700 pl-[35px]">Buscar proveedores</span>
                    </a>
                </div>
            {/if}
        </div>
    {/if}

    <a use:inertia href={route('eventos-academicos.index')} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>

        <span class="text-gray-700 min-w-[75%] ml-4">Eventos académicos</span>
    </a>

    {#if isSuperAdmin || checkPermission(authUser, [19, 20])}
        <a use:inertia href={route('convocatorias.index')} class="cursor-pointer mt-4 mr-2 w-full flex items-center py-2 text-sm text-blue-900 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 px-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 text-black" viewBox="0 0 26.465 19.941">
                <g transform="translate(0 -44.37)">
                    <path
                        d="M26.086,63.615H21.713l1.548-.445a.983.983,0,0,0,.592-.454.853.853,0,0,0,.069-.706L18.152,45.02a.994.994,0,0,0-.959-.65,1.084,1.084,0,0,0-.3.042l-3.547,1.02c-.034.01-.067.021-.1.034v-.134a.968.968,0,0,0-1-.925H8.5a1.054,1.054,0,0,0-.627.2,1.057,1.057,0,0,0-.628-.2H3.5a.969.969,0,0,0-1.006.925V63.615H.378a.349.349,0,1,0,0,.7H26.086a.349.349,0,1,0,0-.7Zm-2.9-1.222a.244.244,0,0,1-.147.113l-3.547,1.02a.266.266,0,0,1-.074.01.251.251,0,0,1-.239-.162L14.923,50.848l4.023-1.156L23.2,62.218A.211.211,0,0,1,23.183,62.393ZM18.721,49.028,14.7,50.184l-.46-1.355,4.023-1.156ZM13.571,46.1l3.548-1.02a.268.268,0,0,1,.074-.011.246.246,0,0,1,.237.161l.605,1.782-4.023,1.156-.6-1.781A.228.228,0,0,1,13.571,46.1Zm4.9,17.519H13.247V48.244ZM8.254,52.482H12.49v.969H8.254Zm4.237-.7H8.254v-3.4h4.237ZM7.5,49.305H3.253v-.924H7.5ZM3.253,50H7.5v.924H3.253Zm5,4.145H12.49v9.469H8.254ZM8.5,45.1h3.74a.24.24,0,0,1,.249.229v2.354H8.254V45.332A.24.24,0,0,1,8.5,45.1Zm-5,0H7.247a.241.241,0,0,1,.251.229v2.354H3.253V45.332A.241.241,0,0,1,3.5,45.1Zm-.25,6.519H7.5V63.615H3.253Z"
                    />
                </g>
            </svg>
            <span class="text-gray-700 min-w-[75%] ml-4">Convocatorias I+D+i</span>
        </a>
    {/if}
</nav>
