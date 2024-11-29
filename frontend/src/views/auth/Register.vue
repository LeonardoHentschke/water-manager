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
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

onMounted(() => (errors.value = {}));

const handleRegister = async () => {
  try {
    console.log("formData", formData);
    await authenticate('register', formData);
  } catch (err) {
    console.error("Erro no registro:", err);
  }
};
</script>

<template>
  <div class="w-full lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
    <div class="flex items-center justify-center py-12">
      <div class="mx-auto grid w-[350px] gap-6">
        <div class="grid gap-2 text-center">
          <h1 class="text-primary text-3xl font-bold">
            Bem-vindo à nossa plataforma!
          </h1>
          <p class="text-balance text-muted-foreground">
            Crie uma nova conta e comece a explorar todos os nossos recursos.
          </p>
        </div>
        <form @submit.prevent="handleRegister" class="grid gap-4">
          <div class="grid gap-2">
            <div class="flex items-center">
              <Label class="text-primary" for="name">Nome</Label>
            </div>
            <Input
              id="name"
              v-model="formData.name"
              placeholder="Seu nome"
              required
            />
            <p v-if="errors.name" class="text-red-500 text-xs">{{ errors.name[0] }}</p>
          </div>
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
          <div class="grid gap-2">
            <div class="flex items-center">
              <Label class="text-primary" for="password_confirmation">Confirmar senha</Label>
            </div>
            <Input 
              id="password_confirmation"
              type="password"
              v-model="formData.password_confirmation"
              placeholder="******"
              required
            />
            <p v-if="errors.password_confirmation" class="text-red-500 text-xs">{{ errors.password_confirmation[0] }}</p>
          </div>
          <Button type="submit" class="w-full">
            Cadastrar
          </Button>
          <Button variant="outline" class="w-full" disabled>
            Entrar com Google
          </Button>
        </form>
        <div class="mt-4 text-center text-sm">
          Já tem uma conta?
          <a href="/login" class="underline">
            Entrar
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
