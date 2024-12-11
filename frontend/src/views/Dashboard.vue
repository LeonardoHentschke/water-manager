<script setup>
import { Settings, LogOut, Share, SquareTerminal, SquareUser, Waves } from 'lucide-vue-next'
import { Drawer, DrawerContent, DrawerDescription, DrawerHeader, DrawerTitle, DrawerTrigger } from '@/components/ui/drawer'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip'
import { Textarea } from '@/components/ui/textarea'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import LeafletMap from '@/components/leaflet/LeafletMap.vue'
import DateRangePicker from '@/components/app/DateRangePicker.vue'

import { useAuthStore } from "@/stores/auth";
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from 'vue'
import { fallbackProductsIds } from '@/utils/fallbackProductsIds'

const authStore = useAuthStore();
const postsStore = usePostsStore();
const projectIds = ref([]);
const mapData = ref([]);
const selectedProductId = ref("");
const latitude = ref("");
const longitude = ref("");

const fetchData = async () => {
  try {
    const data = await postsStore.searchData();
    mapData.value = data;
  } catch (error) {
    console.error("Erro ao buscar os dados:", error);
  }
};

const handleMarkerAdded = (coords) => {
  latitude.value = coords.latitude;
  longitude.value = coords.longitude;
};

onMounted(async () => {
  try {
    fetchData();
    projectIds.value = fallbackProductsIds;
  } catch (error) {
    console.error("Erro ao montar a página:", error);
  }
});

const handleSubmit = async (event) => {
  try {
    await postsStore.createPost({
      user_id: authStore.user.id,
      title: event.target.title.value,
      description: event.target.description.value,
      value: event.target.value.value,
      vendor_id: authStore.user.id,
      product_id: selectedProductId.value,
      latitude: latitude.value,
      longitude: longitude.value,
    });
    fetchData();
  } catch (error) {
    console.error("Erro ao criar o post:", error);
  }
};

</script>

<template>
  <div class="grid h-screen w-full pl-[56px]">
    <aside class="inset-y fixed  left-0 z-20 flex h-full flex-col border-r">
      <div class="border-b p-2">
        <Button variant="outline" size="icon" aria-label="Home">
          <Waves class="size-5 fill-foreground" />
        </Button>
      </div>
      <nav class="grid gap-1 p-2">
        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button
                variant="ghost"
                size="icon"
                class="rounded-lg bg-muted"
                aria-label="Dashboard"
              >
                <SquareTerminal class="size-5" />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="right" :side-offset="5">
              Dashboard
            </TooltipContent>
          </Tooltip>
        </TooltipProvider>
      </nav>
      <nav class="mt-auto grid gap-1 p-2">
        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button
                variant="ghost"
                size="icon"
                class="mt-auto rounded-lg"
                aria-label="Account"
              >
                <SquareUser class="size-5" />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="right" :side-offset="5">
              Conta
            </TooltipContent>
          </Tooltip>
        </TooltipProvider>
        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button
                variant="ghost"
                size="icon"
                class="mt-auto rounded-lg"
                aria-label="Log Out"
                @click="authStore.logout"
              >
                <LogOut class="size-5" />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="right" :side-offset="5">
              Sair
            </TooltipContent>
          </Tooltip>
        </TooltipProvider>
      </nav>
    </aside>
    <div class="flex flex-col">
      <header class="sticky top-0 z-10 flex h-[57px] items-center gap-1 border-b bg-background px-4">
        <h1 class="text-xl font-semibold">
          Dashboard
        </h1>
        <Drawer>
          <DrawerTrigger as-child>
            <Button variant="ghost" size="icon" class="md:hidden">
              <Settings class="size-4" />
              <span class="sr-only">Configurações</span>
            </Button>
          </DrawerTrigger>
          <DrawerContent class="max-h-[80vh]">
            <DrawerHeader>
              <DrawerTitle>Nova informação</DrawerTitle>
              <DrawerDescription>
                Defina as configurações do modelo do post
              </DrawerDescription>
            </DrawerHeader>
            <form class="grid w-full items-start gap-6 overflow-auto p-4 pt-0">
              <fieldset class="grid gap-6 rounded-lg border p-4">
                <div class="grid gap-3">
                <Label for="title">Titulo</Label>
                <Input id="title"/>
                </div>
                <div class="grid gap-3">
                  <Label for="description">Descrição</Label>
                  <Textarea id="description" />
                </div>
              </fieldset>
              <fieldset class="grid gap-6 rounded-lg border p-4">
                <legend class="-ml-1 px-1 text-sm font-medium">
                  Informações
                </legend>
                <div class="grid gap-3">
                  <Label for="model">Project ID</Label>
                  <Select v-model="selectedProductId">
                    <SelectTrigger
                      id="model"
                      class="items-start [&_[data-description]]:hidden"
                      :disabled="projectIds.length === 0"
                    >
                      <SelectValue placeholder="Selecione o tipo" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem
                        v-for="project in projectIds"
                        :key="project.id"
                        :value="project.productid"
                      >
                        <div class="flex items-start gap-3 text-muted-foreground">
                          <div class="grid gap-0.5">
                            <p>
                              {{ project.id }}
                              <span class="font-medium text-foreground">
                                {{ project.description }}
                              </span>
                            </p>
                            <p class="text-xs" data-description>
                              {{ project.productid }}
                            </p>
                          </div>
                        </div>
                      </SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <div class="grid gap-3">
                  <Label for="value">Valor</Label>
                  <Input id="value"/>
                </div>
                <div class="grid gap-3">
                  <Label for="latitude">Latitude</Label>
                  <Input id="latitude"/>
                </div>
                <div class="grid gap-3">
                  <Label for="longitude">Latitude</Label>
                  <Input id="longitude"/>
                </div>
              </fieldset>
              <Button>
                Salvar
              </Button>
            </form>
          </DrawerContent>
        </Drawer>
        <Button
          variant="outline"
          size="sm"
          class="ml-auto gap-1.5 text-sm"
          disabled
        >
          <Share class="size-3.5" />
          Compartilhar
        </Button>
      </header>
      <main class="grid flex-1 gap-4 overflow-auto p-4 md:grid-cols-2 lg:grid-cols-3">
        <div class="relative hidden flex-col items-start gap-8 md:flex">
          <form class="grid w-full items-start gap-6" @submit.prevent="handleSubmit">
            <fieldset class="grid gap-6 rounded-lg border p-4">
              <legend class="-ml-1 px-1 text-sm font-medium">
                Nova informação
              </legend>
              <div class="grid gap-3">
                <Label for="title" class="text-left">Titulo</Label>
                <Input id="title"/>
              </div>
              <div class="grid gap-3">
                <Label for="description" class="text-left">Descrição</Label>
                <Textarea id="description" class="min-h-[9.5rem]" />
              </div>
            </fieldset>
            <fieldset class="grid gap-6 rounded-lg border p-4">
              <legend class="-ml-1 px-1 text-sm font-medium">
                Informações
              </legend>
              <div class="grid gap-3">
                <Label for="model" class="text-left">Project ID</Label>
                <Select v-model="selectedProductId">
                  <SelectTrigger
                    id="model"
                    class="items-start [&_[data-description]]:hidden"
                    :disabled="projectIds.length === 0"
                  >
                    <SelectValue placeholder="Selecione o tipo" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem
                      v-for="project in projectIds"
                      :key="project.id"
                      :value="project.productid"
                    >
                      <div class="flex items-start gap-3 text-muted-foreground">
                        <div class="grid gap-0.5">
                          <p>
                            {{ project.id }}
                            <span class="font-medium text-foreground">
                              {{ project.description }}
                            </span>
                          </p>
                          <p class="text-xs" data-description>
                            {{ project.productid }}
                          </p>
                        </div>
                      </div>
                    </SelectItem>
                  </SelectContent>
                </Select>
              </div>
              <div class="grid gap-3">
                <Label for="value" class="text-left">Valor</Label>
                <Input id="value"/>
              </div>
              <div class="grid gap-3">
                <Label for="latitude" class="text-left">Latitude</Label>
                <Input id="latitude" v-model="latitude" readonly />
              </div>
              <div class="grid gap-3">
                <Label for="longitude" class="text-left">Longitude</Label>
                <Input id="longitude" v-model="longitude" readonly />
              </div>
            </fieldset>
            <Button type="submit">
              Salvar
            </Button>
          </form>
        </div>
        <div class="relative flex h-full min-h-[50vh] flex-col rounded-xl bg-muted/50 p-4 lg:col-span-2">
          <div class="flex items-center justify-between mb-2 relative">
            <DateRangePicker class="z-10 relative" />
            <Badge variant="outline" class="absolute right-3 top-3 z-20">
              Mapa
            </Badge>
          </div>
          <div id="map-container" class="relative z-0">
            <LeafletMap :markers="mapData" @marker-added="handleMarkerAdded" />
          </div>
        </div>
      </main>
    </div>
  </div>
</template>