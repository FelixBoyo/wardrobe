<template>

    <Head title="Products" />
    <Frontend>
        <div v-if="$page.props.flash.message" class="bg-green-500 p-3 text-white px-4 rounded mt-4 mx-5">
            {{ $page.props.flash.message }}
        </div>
        <div class="mx-4 mt-4">
            <h5>Clothes List</h5>
            <hr class="my-2 w-24 border-black">
            <div class="flex justify-between ">
                <div class="mb-4 px-3">
                    <label for="category" class="font-semibold">Filter by Category:</label>
                    <select id="category" v-model="selectedCategory" @change="filterProducts"
                        class="h-10 w-40 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                        <option value="">All Categories</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                </div>
                <div class="relative w-full max-w-md mx-auto mb-4">
                    <input v-model="search" type="text" placeholder="Search products..."
                        class="border border-gray-300 rounded-full py-2 pl-10 pr-4 w-full shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300" />

                    <SearchIcon class="absolute left-3 top-2.5 h-5 w-5 text-gray-500" />
                </div>
                <Link :href="route('products.create')" class="bg-blue-500 p-3 mb-4 text-white rounded">Add Product
                </Link>

            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
                <div v-for="product in products" :key="product.id" class="bg-gray-200 border shadow-lg rounded-lg p-4">
                    <img :src="`/storage/images/${product.image}`" alt="Product Image"
                        class="h-32 w-32 object-cover rounded-md">

                    <div class="mt-4">
                        <h2 class="text-lg font-semibold">{{ product.name }}</h2>
                        <p class="text-gray-700">description: {{ product.description }}</p>
                        <p class="text-gray-700">Price: Ksh {{ product.price }}</p>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <Link :href="route('products.show', product.id)" class=" text-black px-3 py-1 rounded">Show
                        </Link>
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
import SearchIcon from '@/Components/SearchIcon.vue';
import Frontend from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';

defineProps({
    products: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});
let search = ref(""), pageNumber = ref(1);
let selectedCategory = ref("");

const filterProducts = () => {
    router.get(route('products.index'), { category_id: selectedCategory.value }, { preserveState: true });
};

let productsUrl = computed(() => {
    let url = new URL(route('products.index'));
    url.searchParams.append('page', pageNumber.value);
    if (search.value) {
        url.searchParams.append('search', search.value);
    }
    return url;
});
watch(selectedCategory, filterProducts);


watch(() => productsUrl.value,
    (updatedproductsUrl) => {
        router.visit(updatedproductsUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    });

const form = useForm();
const deleteProduct = (productId) => {
    if (confirm('Are you sure you want to delete this product?')) {
        form.delete(route('products.destroy', productId));
    }
}

</script>