<script setup>
import { RouterLink, RouterView } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();
</script>

<template>
  <div class="min-h-screen bg-background text-center antialiased">
    <RouterView />
  </div>
</template>