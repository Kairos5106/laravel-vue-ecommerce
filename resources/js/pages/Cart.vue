<!-- eslint-disable vue/block-lang -->
<script setup>
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import {
    Table,
    TableHeader,
    TableBody,
    TableRow,
    TableCell,
} from "@/components/ui/table";
import { Button } from '@/components/ui/button';
import { toImageName } from '@/lib/utils';

const props = defineProps({
    cart: Object
});

const totalPrice = computed(() => {
    return Object.values(props.cart).reduce((acc, item) => acc + (item.price * item.quantity), 0)
});

function placeOrder() {
    router.post(route('checkout'));
}

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="container mx-auto p-6 laptop:p-10">
            <h1 class="text-2xl lg:text-3xl font-bold pb-6">Your Cart</h1>

            <div class="grid gap-3 lg:grid-cols-[1fr_300px] relative">
                <Card class="overflow-x-scroll">
                    <CardContent>
                        <div
                            v-if="$page.props.cartCount == 0"
                            class="w-full h-full flex items-center justify-center text-sm text-gray-500"
                        >
                            No items in cart.
                        </div>
                        <Table
                            v-if="$page.props.cartCount > 0"
                        >
                            <TableHeader>
                                <TableRow class="text-end">
                                    <TableCell class="text-start">Item</TableCell>
                                    <TableCell></TableCell>
                                    <TableCell>Price</TableCell>
                                    <TableCell class="text-center">Quantity</TableCell>
                                </TableRow>
                            </TableHeader>
                            <TableBody v-for="(item, id) in cart" :key="id">
                                <TableRow class="text-end h-[100px]">
                                    <TableCell class="text-start">
                                        <img
                                            :src="`/products/${toImageName(item.name)}.jpg`"
                                            class="w-[300px] h-auto object-cover"
                                        />
                                    </TableCell>
                                    <TableCell>{{ item.name }}</TableCell>
                                    <TableCell>{{ item.price }}</TableCell>
                                    <TableCell class="h-[100px] flex items-center! justify-center gap-4">
                                        <Button
                                            variant="default"
                                            size="icon"
                                            class="rounded-full flex items-center justify-center w-6 h-6 p-1"
                                        >
                                            -
                                        </Button>
                                        <span class="font-bold">
                                            {{ item.quantity }}
                                        </span>
                                        <Button
                                            variant="default"
                                            size="icon"
                                            class="rounded-full flex items-center justify-center w-6 h-6 p-1"
                                        >
                                            +
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <div class="sticky top-20 flex flex-col gap-3">
                    <Card class="h-fit">
                        <CardHeader>
                            <h3 class="font-bold text-lg">Summary</h3>
                        </CardHeader>
                        <CardContent>
                            <div class="flex items-center justify-between">
                                <p> Total Quantity </p>
                                <p class=""> {{ Object.values(cart).length }} </p>
                            </div>
                            <div class="h-px bg-stone-300 my-4" />
                            <div class="flex items-center justify-between">
                                <p> Total Price (MYR) </p>
                                <p class="font-bold text-lg"> {{ totalPrice  }} </p>
                            </div>
                        </CardContent>
                    </Card>
                    <Button
                        variant="default"
                        class="w-full"
                    >
                        Place Order
                    </Button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
