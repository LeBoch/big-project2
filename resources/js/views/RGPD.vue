<template>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Mentions Légales </p>
                <p class="mt-6 text-lg leading-8 text-gray-600">Les mentions légales sont essentielles pour garantir la transparence et la conformité légale d'un site internet, incluant des informations sur l'éditeur, l'hébergeur, les droits d'auteur et la gestion des données personnelles.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <div v-for="feature in features" :key="feature.name" class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-600">
                                <component :is="feature.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                            </div>
                            {{ feature.name }}
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">{{ feature.description }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ArrowPathIcon, CloudArrowUpIcon, FingerPrintIcon, LockClosedIcon } from '@heroicons/vue/24/outline'

const features = [
    {
        name: "Identification de l’éditeur du site :",
        description: "Entreprise Démo SARL 123 Rue de l’Exemple, 75000 Paris, France +33 1 23 45 67 89, bochsler.enzo@gmail.com",
        icon: CloudArrowUpIcon
    },
    {
        name: 'Hébergement du site :',
        description:
            'Nom de l’hébergeur : Hébergeur Démo SAS\n' +
            'Adresse : 456 Avenue de l’Hébergement, 69000 Lyon, France\n' +
            'Numéro de téléphone : +33 4 56 78 90 12\n' +
            'Adresse e-mail : contact@hebergeur-demo.com',
        icon: LockClosedIcon,
    },
    {
        name: 'Propriété intellectuelle :',
        description:
            'Droits d’auteur : Les contenus (textes, images, vidéos, etc.) présents sur ce site sont protégés par le droit d’auteur et sont la propriété exclusive de Entreprise Démo SARL. ',
        icon: ArrowPathIcon,
    },
    {
        name: 'Marques :',
        description:
            'Les marques et logos figurant sur ce site sont des marques déposées par Entreprise Démo SARL ou ses partenaires.',
        icon: FingerPrintIcon,
    },
]
</script>
