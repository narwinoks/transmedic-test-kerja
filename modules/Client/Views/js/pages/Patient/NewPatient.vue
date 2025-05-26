<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';
import type { BreadcrumbItem } from '../../types';
import { Card } from '../../components/ui/card';
import { Button } from '../../components/ui/button';
import { Input } from '../../components/ui/input';
import { Label } from '../../components/ui/label';
import  {RadioGroup} from '../../components/ui/radio';
import DatePicker from 'primevue/datepicker';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'patient',
        href: '/dashboard/Patient',
    },
    {
        title: 'Entry New Patient',
        href: 'dashboard/NewPatient',
    },
];
const form = useForm({
    name: '',
    number_identity: '',
    date_of_birth : new Date(),
    gender:''
});
const radioOptions = [
    { label: 'Laki Laki', value: 'Laki Laki' },
    { label: 'Perempuan', value: 'Perempuan' },
]
</script>
<template>
    <Head title="Patient" />
        <AppLayout :breadcrumbs="breadcrumbs">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12">
                    <Card is-rounded class="min-h-80">
                        <div class="flex text-end gap-4 justify-end">
                            <div class="text-end flex gap-4">
                                <Button variant="outline">Back</Button>
                                <Button>Save</Button>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <Label for="name" class="mb-1">Patient Name</Label>
                                <Input
                                    id="name"
                                    type="text"
                                    required
                                    autofocus
                                    :tabindex="1"
                                    autocomplete="name"
                                    v-model="form.name"
                                    placeholder="Enter Your Name Patient"
                                />
                            </div>
                            <div class="col-span-6 gap-2">
                                <Label for="number_identity" class="mb-1">Number Identity</Label>
                                <Input
                                    id="number_identity"
                                    type="text"
                                    required
                                    autofocus
                                    :tabindex="2"
                                    autocomplete="number_identity"
                                    v-model="form.number_identity"
                                    placeholder="Enter Your Number Identity"
                                />
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <Label for="number_identity" class="mb-1">Date Of Birth</Label>
                                <DatePicker size="small" v-model="form.date_of_birth" showIcon fluid :showOnFocus="false" />
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <Label for="number_identity" class="mb-1">Gender</Label>
                                <RadioGroup v-model="form.gender" :options="radioOptions" />
                            </div>
                        </div>
                    </Card>
                </div>
            </div>
        </AppLayout>
</template>
