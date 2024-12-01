<script setup lang="ts">
import { useAuthStore } from "@/stores/auth";
import { storeToRefs } from "pinia";
import { reactive, onMounted } from "vue";

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const authStore = useAuthStore();
const { errors }: { errors: any } = storeToRefs(authStore);
const { authenticate } = authStore;

const formData = reactive({
  email: "",
  password: "",
});

onMounted(() => (errors.value = {}));
</script>

<template>
  <div class="w-full lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
    <div class="flex items-center justify-center py-12">
      <div class="mx-auto grid w-[350px] gap-6">
        <div class="grid gap-2 text-center">
          <h1 class="text-primary text-3xl font-bold">
            Bem vindo de volta
          </h1>
          <p class="text-balance text-muted-foreground">
            Digite seu e-mail para fazer login em sua conta
          </p>
        </div>
        <form @submit.prevent="authenticate('login', formData)" class="grid gap-4">
          <div class="grid gap-2">
            <div class="flex items-center">
              <Label class="text-primary" for="email">Email</Label>
            </div>
            <Input
              id="email"
              type="email"
              v-model="formData.email"
              placeholder="wolf@example.com"
              required
            />
            <p v-if="errors.email" class="text-red-500 text-xs">{{ errors.email[0] }}</p>
          </div>
          <div class="grid gap-2">
            <div class="flex items-center">
              <Label class="text-primary" for="password">Senha</Label>
            </div>
            <Input
              id="password"
              type="password"
              v-model="formData.password"
              placeholder="******"
              required
            />
            <p v-if="errors.password" class="text-red-500 text-xs">{{ errors.password[0] }}</p>
          </div>
          <Button type="submit" class="w-full">
            Entrar
          </Button>
          <Button variant="outline" class="w-full" disabled>
            Entrar com Google
          </Button>
        </form>
        <div class="mt-4 text-center text-sm">
          Não tem uma conta?
          <a href="/register" class="underline">
            Inscrever-se
          </a>
        </div>
      </div>
    </div>
    <div class="hidden bg-muted lg:block">
      <img
        src="../../assets/placeholder.png"
        alt="Image"
        width="1920"
        height="1080"
        class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
      />
    </div>
  </div>
</template>
