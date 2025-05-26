<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';
import type { BreadcrumbItem } from '../../types';
import { Card } from '../../components/ui/card';
import { Avatar, AvatarFallback, AvatarImage } from '../../components/ui/avatar';
import { Input } from '../../components/ui/input';
import { LoaderCircle } from 'lucide-vue-next';
import { Button } from '../../components/ui/button';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'patient',
        href: 'dashboard/Patient',
    },
];
const form = useForm({
    search: '',
    remember: false,
});

</script>
<template>
    <Head title="Patient" />
        <AppLayout :breadcrumbs="breadcrumbs">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-8">
                    <Card is-rounded>
                        <Card is-rounded>
                            <div class="flex items-center gap-3 cursor-pointer">
                                <Avatar class="cursor-pointer">
                                    <AvatarImage src="/avatar.png" alt="User Avatar" />
                                    <AvatarFallback>U</AvatarFallback>
                                </Avatar>
                                <div class="w-full">
                                    <h3 class="text-md font-medium">Nama Pasien</h3>
                                    <p class="font-light text-xs">33109 (p)</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-sm">
                                    <h4 class="font-medium text-md">IDENTITY</h4>
                                    <p class="font-light mt-5">Number Identity :  331350407040001</p>
                                    <p class="font-light">Date of birth :  4 Juli 2004</p>
                                </div>
                                <div class="text-sm">
                                    <h4 class="font-medium">CONTACT</h4>
                                    <p class="font-light mt-5">phone Number :  331350407040001</p>
                                </div>
                                <div class="text-sm">
                                    <h4 class="font-medium">STATUS</h4>
                                </div>
                            </div>
                        </Card>
                    </Card>
                </div>
                <div class="col-span-4">
                    <Card>
                        <div class="flex items-center justify-between">
                            <h2 class="font-semibold">Filter Pencarian</h2>
                            <Button variant="link">Add New Patient</Button>
                        </div>
                        <div class="mt-10">
                            <Input
                                id="search"
                                type="text"
                                required
                                autofocus
                                :tabindex="1"
                                autocomplete="search"
                                v-model="form.search"
                                placeholder="search"
                            />
                        </div>
                        <Button type="submit" class="mt-4 w-full cursor-pointer" :tabindex="4" :disabled="form.processing">
                            <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                            Search
                        </Button>
                    </Card>
                </div>
            </div>
        </AppLayout>
</template>
