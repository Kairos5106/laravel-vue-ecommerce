<!-- eslint-disable vue/block-lang -->
<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    products: Array,
    filters: Object
});

const search = ref(props.filters.search);

const handleSearch = () => {
    router.get('/catalogue', { search: search.value }, { preserveState: true });
};

const addToCart = (product) => {
    router.post('/cart', { product_id: product.id }, {
        onSuccess: () => console.log(`${product.name} [${product.id}] added successfully!`)
    });
    alert(`${product.name} added to cart!`);
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <section>
            <img src="/header.jpg" />
        </section>

        <!-- Section for product category filters -->
        <section>

        </section>

        <div class="container mx-auto p-6 laptop:p-10">
          <h1 class="text-3xl font-bold mb-6">Gaming for You!</h1>

          <div class="mb-6">
            <input
              v-model="search"
              @input="handleSearch"
              type="text"
              placeholder="Search products..."
              class="border p-2 rounded w-full max-w-sm"
            />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div v-for="product in products" :key="product.id" class="border p-4 rounded shadow">
              <h2 class="text-xl font-semibold">{{ product.name }}</h2>
              <p class="text-gray-600">{{ product.description }}</p>
              <p class="text-blue-600 font-bold mt-2">${{ product.price }}</p>

              <button
                @click="addToCart(product)"
                class="mt-4 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full"
              >
                Add to Cart
              </button>
            </div>
          </div>
        </div>
    </AppLayout>
</template>
