<template>

    <Head :title="product.name" />
    <Frontend>
        <div class="mx-4 mt-4">
            <div class="flex justify-between ">
                <h5>{{ product.name }}</h5>
                <Link :href="route('products.index')" class="bg-red-500 p-3 mb-4 text-white rounded"> Back
                </Link>
            </div>
            <div class="grid grid-cols-6 gap-4 bg-white shadow-lg rounded-lg p-4">
                <div class="col-span-6">
                    <img :src="`/storage/images/${product.image}`" alt="Product Image"
                        class="h-48 w-56 object-cover rounded-md">

                    <div class="mb-3">
                        <label class=" font-bold">Product Name </label>
                        <p class="text-sm text-gray-700"> {{ product.name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="font-bold">Product description </label>
                        <p class="text-sm text-gray-700"> {{ product.description }}</p>

                    </div>
                    <div class="mb-3">
                        <label class="font-bold">Price</label>
                        <p class="text-sm text-gray-700"> {{ product.price }}</p>

                    </div>
                    <div class="mb-3">
                        <label class="font-bold">Category</label>
                        <p class="text-sm text-gray-700"> {{ product.category.name }}</p>

                    </div>
                    <div class="mb-3">
                        <Link :href="route('products.edit', product.id)" class=" text-green-600 px-3 py-1 rounded">Edit
                        </Link>
                        <button @click="deleteProduct(product.id)"
                            class=" px-3 text-red-800 py-1 rounded">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </Frontend>

</template>

<script setup>
import Frontend from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: {
        type: Object,
        required: true,
    },
    product: {
        type: Object,
        required: true,
    },
    errors: Object
});


</script>