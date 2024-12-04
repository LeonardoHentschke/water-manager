<script setup>
import { Button } from '@/components/ui/button'
import { Waves } from 'lucide-vue-next'
</script>

<template>
  <div class="min-h-screen bg-background">
    <header class="border-b">
      <div class="container flex h-16 items-center">
        <Waves class="size-5 fill-foreground text-blue-600" />
        <h1 class="text-2xl font-bold ml-1">Water Manager</h1>
        <nav class="ml-auto flex gap-4">
          <RouterLink to="/login">
            <Button>Entrar</Button>
          </RouterLink>
          <RouterLink to="/register">
            <Button variant="ghost">Cadastrar-se</Button>
          </RouterLink>
          <Button variant="ghost">Saber mais</Button>
        </nav>
      </div>
    </header>

    <main class="container py-8">
      <section class="space-y-6 pb-8 pt-6 md:pb-12 md:pt-10 lg:py-32">
        <div class="container flex max-w-[64rem] flex-col items-center gap-4 text-center">
          <h1 class="text-4xl font-bold sm:text-5xl md:text-6xl lg:text-7xl">
            Bem vindo ao Water Manager
          </h1>
          <p class="max-w-[42rem] leading-normal text-muted-foreground sm:text-xl sm:leading-8">
            Univates 2024B - Desenvolvimento de aplicações para automação
          </p>
          <div class="flex gap-4">
            <RouterLink to="/login">
              <Button size="lg">Começar</Button>
            </RouterLink>
            <Button size="lg" variant="outline">Saber mais</Button>
          </div>
        </div>
      </section>

      <div class="w-full h-8">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M0 43.9999C106.667 43.9999 213.333 7.99994 320 7.99994C426.667 7.99994 533.333 43.9999 640 43.9999C746.667 43.9999 853.333 7.99994 960 7.99994C1066.67 7.99994 1173.33 43.9999 1280 43.9999C1386.67 43.9999 1440 19.0266 1440 9.01329V100H0V43.9999Z"
                class="fill-current text-blue-600"></path>
        </svg>
      </div>

      <section class="container space-y-6 py-8 md:py-12 lg:py-24">
        <div class="mx-auto grid justify-center gap-4 sm:grid-cols-2 md:max-w-[64rem] md:grid-cols-3">
          <div class="relative overflow-hidden rounded-lg border bg-background p-2">
            <div class="flex h-[180px] flex-col justify-between rounded-md p-6">
              <div class="space-y-2">
                <h3 class="font-bold">Feature um</h3>
                <p class="text-sm text-muted-foreground">
                    "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
                </p>
              </div>
            </div>
          </div>
          <div class="relative overflow-hidden rounded-lg border bg-background p-2">
            <div class="flex h-[180px] flex-col justify-between rounded-md p-6">
              <div class="space-y-2">
                <h3 class="font-bold">Feature Dois</h3>
                <p class="text-sm text-muted-foreground">
                    "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
                </p>
              </div>
            </div>
          </div>
          <div class="relative overflow-hidden rounded-lg border bg-background p-2">
            <div class="flex h-[180px] flex-col justify-between rounded-md p-6">
              <div class="space-y-2">
                <h3 class="font-bold">Feature Três</h3>
                <p class="text-sm text-muted-foreground">
                    "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
</template>