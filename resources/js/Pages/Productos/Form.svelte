<script>
    import { checkRole, checkPermission } from '@/Utils'

    import Input from '@/Shared/Input'
    import Label from '@/Shared/Label'
    import Textarea from '@/Shared/Textarea'
    import LoadingButton from '@/Shared/LoadingButton'

    export let submit
    export let authUser
    export let sending
    export let errors
    export let form
    export let method = null

    let isSuperAdmin = checkRole(authUser, [1])

    function loadfile(event) {
        var output = document.getElementById('preimage')
        output.src = URL.createObjectURL(event.target.files[0])
        $form.image = event.target.files[0]
    }
</script>

<form on:submit|preventDefault={submit} class="col-span-2">
    <fieldset class="px-8" disabled={isSuperAdmin || checkPermission(authUser, [27]) ? undefined : true}>
        <div class="mt-4">
            <div>
                <Label required labelFor="nombre" value="Nombre" />
                <Input id="nombre" type="text" class="mt-1" bind:value={$form.nombre} error={errors.nombre} required />
            </div>

            <div class="mt-4">
                <Label required labelFor="descripcion" value="Descripción" />
                <Textarea maxlength="40000" id="descripcion" bind:value={$form.descripcion} error={errors.descripcion} required />
            </div>

            <div class="mt-4">
                <Label labelFor="imagen" value="Imagen" />

                <div class="flex space-x-3 justifycontent-center">
                    <div class="space-x-2 mt-1 w-100 flex justify-center px-3 pt-3 pb-3 border-2 border-gray-300 border-dashed rounded-md bg-white">
                        <div class="mt-1 w-40   flex justify-center px-3 pt-3 pb-3 border-2 border-gray-300  rounded-md">
                            <p class="text-xs text-gray-500 " />
                            <div class="m-auto">
                                <div class="text-center text-xs text-gray-500 flex-auto w-full mb-1 space-y-2 ">
                                    <img id="preimage" src="" />
                                    <span class=" inline-block align-text-bottom">Imagen</span>
                                </div>
                            </div>
                            <p />
                        </div>
                        <br />

                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Cargar archivo</span>
                                    <input id="image" bind:value={$form.image} type="file" accept=".png,.jpg,.jpeg" class="sr-only" on:change={(event) => loadfile(event)} />
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, Max 1MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="mt-10 px-8 py-4 bg-gray-50 flex items-center sticky bottom-0">
        {#if isSuperAdmin || checkPermission(authUser, [27])}
            <LoadingButton loading={sending} class="ml-auto" type="submit">Guardar</LoadingButton>
        {/if}
    </div>
</form>
