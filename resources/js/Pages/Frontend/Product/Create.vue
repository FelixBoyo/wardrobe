<template>

    <Head title="Create Product" />
    <Frontend>
        <div class="mx-4 mt-4">
            <div class="flex justify-between ">
                <h5>Create Product </h5>
                <Link :href="route('products.index')" class="bg-red-500 p-3 mb-4 text-white rounded"> Back
                </Link>
            </div>
            <form @submit.prevent="saveProduct">
                <div class="grid grid-cols-6 gap-4">
                    <div class="col-span-6">
                        <div class="mb-3">
                            <label>Product Name </label>
                            <input type="text" v-model="form.name" class="p-1 w-full" />
                            <div v-if="props.errors.name" class="text-red-500"> {{ props.errors.name }}</div>
                        </div>
                        <div class="mb-3">
                            <label>Product description </label>
                            <input type="text" v-model="form.description" class="p-1 w-full" />
                            <div v-if="props.errors.description" class="text-red-500"> {{ props.errors.description }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Price </label>
                            <input type="text" v-model="form.price" class="p-1 w-full" />
                            <div v-if="props.errors.price" class="text-red-500"> {{ props.errors.price }}</div>

                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <select v-model="form.category_id" class="p-1 w-full">
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                            <div v-if="props.errors.category_id" class="text-red-500">
                                {{ props.errors.category_id }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Product Image</label>
                            <input type="file" id="image" @input="change" class="p-1 w-full" />
                            <div v-if="props.errors.image" class="text-red-500">{{ props.errors.image }}</div>
                        </div>
                       
                        <div class="mb-3">
                            <Link :href="route('products.index')"
                                class="bg-red-500 py-2 px-5 mb-4 text-white rounded inline-block"> Back
                            </Link>
                            <button class="bg-blue-500 py-2 px-5 mb-4 text-white rounded" :disabled="form.processing"
                                type="submit">
                                <span v-if="form.processing">Saving...</span>
                                <span v-else>Save</span></button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </Frontend>

</template>

<script setup>
import Frontend from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    errors: Object
});
const form = useForm({
    name: '',
    description: '',
    price: '',
    category_id: '',
    image: null,
});
const change = (e) => {
    form.image = e.target.files[0];
}
const saveProduct = () => {
    const res = form.post(route('products.store'));
    if (res) {
        form.reset();
    }
}

</script>