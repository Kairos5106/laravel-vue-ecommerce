<!-- eslint-disable vue/block-lang -->
<script setup>
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { toImageName } from '@/lib/utils';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { computed } from 'vue';
import { formatCurrency } from '@/lib/utils';

const props = defineProps({
    cart: Object,
});

const totalPrice = computed(() => {
    return Object.values(props.cart).reduce(
        (acc, item) => acc + item.price * item.quantity,
        0,
    );
});

function placeOrder() {
    router.post('checkout', {}, {
        onSuccess: () => {
            alert('Order sent successfully!')
        },
        onError: () => {
            alert('Failed to send order. Please try again later.');
        },
        preserveScroll: true,
    });
    const cartProductIds = Object.values(props.cart).map((c) => c.id);
    cartProductIds.forEach(element => {
        clearQuantity(element);
    });
}

function updateQuantity(product_id, action) {
    const url =
        action === 'inc'
            ? `/cart/increment/${product_id}`
            : `/cart/decrement/${product_id}`;
    return router.post(url, {}, { preserveScroll: true });
}

function clearQuantity(product_id) {
    return router.post(`/cart/clear/${product_id}`, {}, { preserveScroll: true });
}

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="laptop:p-10 container mx-auto p-6">
            <h1 class="pb-6 text-2xl font-bold lg:text-3xl">Your Cart</h1>

            <div class="relative grid gap-3 lg:grid-cols-[1fr_300px]">
                <Card class="overflow-x-scroll">
                    <CardContent>
                        <div
                            v-if="$page.props.cartCount == 0"
                            class="flex h-full w-full items-center justify-center text-sm text-gray-500"
                        >
                            No items in cart.
                        </div>
                        <Table v-if="$page.props.cartCount > 0">
                            <TableHeader>
                                <TableRow class="text-end">
                                    <TableCell class="text-start"
                                        >Item</TableCell
                                    >
                                    <TableCell></TableCell>
                                    <TableCell>Price</TableCell>
                                    <TableCell class="text-center"
                                        >Quantity</TableCell
                                    >
                                    <TableCell class="">Action</TableCell>
                                </TableRow>
                            </TableHeader>
                            <TableBody v-for="(item, id) in cart" :key="id">
                                <TableRow class="h-[100px] text-end">
                                    <TableCell class="min-w-[100px]">
                                        <img
                                            :src="`/products/${toImageName(item.name)}.jpg`"
                                            class="w-[300px] object-cover lg:h-[300px]"
                                        />
                                    </TableCell>
                                    <TableCell>{{ item.name }}</TableCell>
                                    <TableCell>{{ item.price }}</TableCell>
                                    <TableCell class="h-[100px]">
                                        <div
                                            class="flex h-full min-h-[100px] w-full items-center justify-center gap-2 lg:gap-3"
                                        >
                                            <Button
                                                variant="default"
                                                size="icon"
                                                class="flex h-6 w-6 items-center justify-center rounded-full p-1"
                                                @click="
                                                    updateQuantity(
                                                        item.id,
                                                        'dec',
                                                    )
                                                "
                                            >
                                                -
                                            </Button>
                                            <span class="font-bold">
                                                {{ item.quantity }}
                                            </span>
                                            <Button
                                                variant="default"
                                                size="icon"
                                                class="flex h-6 w-6 items-center justify-center rounded-full p-1"
                                                @click="
                                                    updateQuantity(
                                                        item.id,
                                                        'inc',
                                                    )
                                                "
                                            >
                                                +
                                            </Button>
                                        </div>
                                    </TableCell>
                                    <TableCell class="p-0">
                                        <div
                                            class="flex h-full min-h-[100px] w-full items-center justify-center"
                                        >
                                            <Button
                                                variant="ghost"
                                                size="icon"
                                                class=""
                                                @click="clearQuantity(item.id)"
                                            >
                                                <Trash2 class="h-5 w-5" />
                                            </Button>
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <div class="sticky top-20 flex flex-col gap-3">
                    <Card class="h-fit">
                        <CardHeader>
                            <h3 class="text-lg font-bold">Summary</h3>
                        </CardHeader>
                        <CardContent>
                            <div class="flex items-center justify-between">
                                <p>Total Quantity</p>
                                <p class="">{{ $page.props.cartCount }}</p>
                            </div>
                            <div class="my-4 h-px bg-stone-300" />
                            <div class="flex items-center justify-between">
                                <p>Total Price</p>
                                <p class="text-lg font-bold">
                                    {{ formatCurrency(totalPrice) }}
                                </p>
                            </div>
                        </CardContent>
                    </Card>
                    <Button
                        variant="default"
                        class="w-full"
                        @click="() => placeOrder()"
                    >
                        Place Order
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
