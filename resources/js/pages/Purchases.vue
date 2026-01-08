<!-- eslint-disable vue/block-lang -->
<script setup>
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardFooter,
    CardHeader,
} from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { formatCurrency, formatDate } from '@/lib/utils';

const props = defineProps({
    orders: {
        type: Array,
        default: () => [],
    },
});

const pendingOrders = computed(() => {
    return props.orders.filter(order => order.status === 'pending');
});

const completedOrders = computed(() => {
    return props.orders.filter(order => order.status === 'completed');
});

function markAsReceived(orderId) {
    if (confirm("Are you sure you have received this order?")) {
        router.post(`/purchases/${orderId}/received`, {}, {
            preserveScroll: true,
            onSuccess: () => console.log('Updated!'),
        });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="laptop:p-10 container mx-auto grid gap-6 p-6">
            <h1 class="text-2xl font-bold lg:text-3xl">Your Purchases</h1>

            <section class="flex flex-col gap-4">
                <div class="w-full rounded-lg bg-gray-100 p-4 px-6 flex items-center justify-between">
                    <h3 class="text-2xl">Pending Orders</h3>
                    <p v-if="pendingOrders.length > 0">{{ pendingOrders.length }} pending orders</p>
                </div>

                <div
                    v-if="pendingOrders.length === 0"
                    class="rounded-lg bg-white py-12 text-center shadow-sm"
                >
                    <p class="text-gray-500">No pending orders.</p>
                </div>

                <div v-else class="grid gap-4">
                    <Card
                        v-for="order in pendingOrders"
                        :key="order.id"
                        class="overflow-hidden border bg-white pt-0 shadow-sm sm:rounded-lg"
                    >
                        <CardHeader
                            class="flex items-center justify-between border-b bg-gray-50 px-6 pt-4! pb-4!"
                        >
                            <div>
                                <span class="font-bold">Order #{{ order.id }}</span>
                                <span class="ml-2 text-sm text-gray-500">{{ formatDate(order.created_at) }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs text-blue-800 capitalize">
                                    {{ order.status }}
                                </span>
                                <span class="font-bold">{{ formatCurrency(order.total_amount) }}</span>
                            </div>
                        </CardHeader>
                        <CardContent class="grid gap-4 py-0!">
                            <div
                                v-for="item in order.items"
                                :key="item.id"
                                class="flex items-center justify-between border-b pb-4"
                            >
                                <div class="flex items-center gap-4">
                                    <div>
                                        <h3 class="font-medium">
                                            {{ item.product?.name || 'Unknown Product' }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Quantity: {{ item.quantity }}
                                        </p>
                                    </div>
                                </div>
                                <p>{{ formatCurrency(item.price) }}</p>
                            </div>
                        </CardContent>
                        <CardFooter class="flex w-full justify-end">
                            <Button variant="default" @click="markAsReceived(order.id)"> Order Received </Button>
                        </CardFooter>
                    </Card>
                </div>
            </section>

            <section class="flex flex-col gap-4">
                <div class="w-full rounded-lg bg-gray-100 p-4 px-6 flex items-center justify-between">
                    <h3 class="text-2xl">Completed Orders</h3>
                    <p v-if="completedOrders.length > 0">{{ completedOrders.length }} completed</p>
                </div>

                <div
                    v-if="completedOrders.length === 0"
                    class="rounded-lg bg-white py-12 text-center shadow-sm"
                >
                    <p class="text-gray-500">No completed orders found.</p>
                </div>

                <div v-else class="grid gap-4">
                    <Card
                        v-for="order in completedOrders"
                        :key="order.id"
                        class="overflow-hidden border bg-white pt-0 shadow-sm sm:rounded-lg"
                    >
                        <CardHeader
                            class="flex items-center justify-between border-b bg-gray-50 px-6 pt-4! pb-4!"
                        >
                            <div>
                                <span class="font-bold">Order #{{ order.id }}</span>
                                <span class="ml-2 text-sm text-gray-500">{{ formatDate(order.created_at) }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs text-green-800 capitalize">
                                    {{ order.status }}
                                </span>
                                <span class="font-bold">{{ formatCurrency(order.total_amount) }}</span>
                            </div>
                        </CardHeader>
                        <CardContent class="grid gap-4 py-0!">
                            <div
                                v-for="item in order.items"
                                :key="item.id"
                                class="flex items-center justify-between border-b pb-4"
                            >
                                <div class="flex items-center gap-4">
                                    <div>
                                        <h3 class="font-medium">
                                            {{ item.product?.name || 'Unknown Product' }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Quantity: {{ item.quantity }}
                                        </p>
                                    </div>
                                </div>
                                <p>{{ formatCurrency(item.price) }}</p>
                            </div>
                        </CardContent>
                        <CardFooter class="flex w-full justify-end">
                            <Button variant="outline"> Rate </Button>
                        </CardFooter>
                    </Card>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
