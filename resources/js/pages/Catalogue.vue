<!-- eslint-disable vue/block-lang -->
<script setup>
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
// import { ref } from 'vue';
import { toImageName } from '@/lib/utils';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps({
    products: Array,
    // filters: Object,
});

// const search = ref(props.filters.search);

// function handleSearch() {
//     router.get('/catalogue', { search: search.value }, { preserveState: true });
// };

function addToCart(product) {
    router.post(
        '/cart',
        { product_id: product.id },
        {
            onSuccess: () => {
                console.log(
                    `${product.name} [${product.id}] added successfully!`,
                )
                alert(`1 of ${product.name} has been added to cart!`);
            },
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <section>
            <img src="/header.jpg" />
        </section>

        <!-- Section for product category filters -->
        <section></section>

        <div class="laptop:p-10 container mx-auto p-6">
            <h1 class="mb-6 text-3xl font-bold">Gaming for You!</h1>

            <!-- <div class="mb-6">
                <input
                    v-model="search"
                    @input="handleSearch"
                    type="text"
                    placeholder="Search products..."
                    class="w-full max-w-sm rounded border p-2"
                />
            </div> -->

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <Card
                    v-for="product in products"
                    :key="product.id"
                    class="w-full rounded border p-4 shadow"
                >
                    <CardContent class="w-full px-2 flex flex-col items-center gap-4">
                        <img
                            :src="`/products/${toImageName(product.name)}.jpg`"
                            class="w-[200px] h-[200px] object-cover"
                        />

                        <div class="w-full min-h-[80px] grid grid-cols-[1fr_60px]">
                            <div>
                                <h2 class="text-xl font-semibold">{{ product.name }}</h2>
                                <p class="text-gray-600">{{ product.description }}</p>
                            </div>
                            <p class="pt-0.5 font-bold text-blue-700">${{ product.price }}</p>
                        </div>

                        <Button
                            variant="default"
                            @click="addToCart(product)"
                            class="w-full lg:w-fit rounded px-4 py-2 text-white self-start"
                        >
                            Add to Cart
                        </Button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
