<!-- eslint-disable vue/block-lang -->
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({
    orders: Object,
});

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(amount);
};

function formatDate(date) {
    return new Date(date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="laptop:p-10 container mx-auto grid gap-6 p-6">
            <h1 class="text-2xl font-bold lg:text-3xl">Your Purchases</h1>

            <div
                v-if="orders.length === 0"
                class="rounded-lg bg-white py-12 text-center shadow-sm"
            >
                <p class="text-gray-500">No orders found.</p>
            </div>

            <section v-else class="space-y-6">
                <div
                    v-for="order in props.orders"
                    :key="order.id"
                    class="overflow-hidden border bg-white shadow-sm sm:rounded-lg"
                >
                    <div
                        class="flex items-center justify-between border-b bg-gray-50 px-6 py-4"
                    >
                        <div>
                            <span class="font-bold">Order #{{ order.id }}</span>
                            <span class="ml-2 text-sm text-gray-500">{{
                                formatDate(order.created_at)
                            }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800 capitalize"
                            >
                                {{ order.status }}
                            </span>
                            <span class="font-bold">{{
                                formatCurrency(order.total_amount)
                            }}</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div
                            v-for="item in order.items"
                            :key="item.id"
                            class="flex items-center justify-between border-b py-2 last:border-0"
                        >
                            <div class="flex items-center gap-4">
                                <div>
                                    <h3 class="font-medium">
                                        {{
                                            item.product?.name ||
                                            'Unknown Product'
                                        }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        Quantity: {{ item.quantity }}
                                    </p>
                                </div>
                            </div>
                            <p>{{ formatCurrency(item.price) }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="flex flex-col gap-2">
                <h3 class="text-lg">Completed</h3>
                <div></div>
            </section>
        </div>
    </AppLayout>
</template>
