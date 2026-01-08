<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';


</script>

<template>
    <Link
        class="flex items-center gap-3 rounded-lg hover:bg-stone-100 p-2 transition-all duration-150 z-9999"
        href="/cart"
    >
        <ShoppingCart class="w-4" />
        <span class="text-sm">Cart</span>
    </Link>
</template>
