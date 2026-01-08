<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
</script>

<template>
    <Link
        class="flex items-center gap-3 rounded-lg hover:bg-stone-100 p-2 transition-all duration-150 z-9999 relative"
        href="/cart"
    >
        <ShoppingCart class="w-4" />
        <span class="text-sm">Cart</span>
        <div
            v-if="$page.props.cartCount > 0"
            class="bg-black text-white font-bold p-2 rounded-full w-4 h-4 text-xs flex items-center justify-center absolute -top-0.5 -right-2"
        >
            {{ $page.props.cartCount }}
        </div>
    </Link>
</template>
