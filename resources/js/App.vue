<template>
    <!--Barre de navigation ( template ) -->
    <header class="absolute z-50 inset-x-0 top-0 bg-white">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">VeloLibs</span>
                    <img class="h-8 w-auto" src="https://svgsilh.com/svg/311656.svg" alt=""/>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                        @click="mobileMenuOpen = true">
                    <span class="sr-only">Open main menu</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true"/>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a v-for="item in navigation" :key="item.name" class="text-sm font-semibold leading-6 text-gray-900">
                    <RouterLink :to=item.path> {{ item.name }}</RouterLink>
                </a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                <a href="#" class="text-sm font-semibold leading-6 text-gray-900"><span aria-hidden="true"></span></a>
            </div>
        </nav>
        <Dialog class="lg:hidden" @close="mobileMenuOpen = false" :open="mobileMenuOpen">
            <div class="fixed inset-0 z-50"/>
            <DialogPanel
                class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">Velolibs</span>
                        <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt=""/>
                    </a>
                    <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="mobileMenuOpen = false">
                        <span class="sr-only">Close menu</span>
                        <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a v-for="item in navigation" :key="item.name"
                               class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                <RouterLink @click="mobileMenuOpen=false" :to=item.path> {{ item.name }}</RouterLink></a>
                        </div>
                        <div class="py-6">
                            <a href="#"
                               class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                            </a>
                        </div>
                    </div>
                </div>
            </DialogPanel>
        </Dialog>
    </header>
    <main class="flex-auto mt-20">
        <!--Router View pour pouvoir changer de page-->
        <RouterView/>
    </main>
</template>

<script setup>
import {Bars3Icon, XMarkIcon} from "@heroicons/vue/24/outline";
import {Dialog, DialogPanel} from "@headlessui/vue";
import {ref} from "vue";

const navigation = [
    {name: 'Accueil', path: '/'},
    {name: 'Carte', path: '/map'},
    // {name: 'A Propos', path: '/policy'},
    // {name: 'Mention Légale', path: '#'},
]

const mobileMenuOpen = ref(false)
</script>

<style>
html, body, #app {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
}

#app {
    display: flex;
    flex-direction: column;
}
</style>
