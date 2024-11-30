<script setup>
import { Button } from '@/components/ui/button'
import { Waves } from 'lucide-vue-next'
</script>

<template>
  <div class="min-h-screen bg-background">
    <header class="border-b">
      <div class="container flex h-16 items-center">
        <Waves class="size-5 fill-foreground" />
        <h1 class="text-2xl font-bold">Water Manager</h1>
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