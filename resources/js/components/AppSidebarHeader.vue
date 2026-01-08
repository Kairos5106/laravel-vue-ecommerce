<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import CartButton from '@/components/CartButton.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);
</script>

<template>
    <header
        class="w-full flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 lg:px-8 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4 sticky top-0 bg-white"
    >
        <div class="w-full flex items-center justify-between gap-2 z-9999">
            <div>
                <SidebarTrigger class="-ml-1" />
                <template v-if="breadcrumbs && breadcrumbs.length > 0">
                    <Breadcrumbs :breadcrumbs="breadcrumbs" />
                </template>
            </div>
            <CartButton />
        </div>
    </header>
</template>
