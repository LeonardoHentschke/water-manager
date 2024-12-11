<script setup>
import { LogOut, Share, SquareTerminal, SquareUser, Waves } from 'lucide-vue-next';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import { Button } from '@/components/ui/button';
import { useAuthStore } from "@/stores/auth";
import { usePostsStore } from "@/stores/posts";
import { onMounted, ref } from 'vue';

import "leaflet/dist/leaflet.css";
import L from "leaflet";
import "leaflet.heat";

const authStore = useAuthStore();
const postsStore = usePostsStore();

const map = ref(null);
const heatmapLayer = ref(null);
const markerLayer = ref(null);
const mapData = ref([]);
const isHeatmapMode = ref(false);

const dateIni = ref("2024-10-01");
const dateFin = ref(new Date().toISOString().slice(0, 10));

const formatDateTimeForAPI = (date) => {
  return `${date}T00:00:00`;
};

const initializeMap = () => {
  map.value = L.map("map").setView([-29.4661, -51.9614], 12);

  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "© OpenStreetMap contributors",
  }).addTo(map.value);

  heatmapLayer.value = L.heatLayer([], { radius: 25, blur: 15, maxZoom: 17 });
  markerLayer.value = L.layerGroup();
};

const updateHeatmap = () => {
  if (heatmapLayer.value) {
    heatmapLayer.value.setLatLngs(
      mapData.value.map(({ latitude, longitude, intensity = 0.5 }) => [latitude, longitude, intensity])
    );
  }
};

const updateMarkers = () => {
  if (markerLayer.value) {
    markerLayer.value.clearLayers();
    mapData.value.forEach(({ latitude, longitude, productid, value, dateinsert }) => {
      L.marker([latitude, longitude])
        .bindPopup(`<b>Product ID: ${productid}</b><br>Valor: ${value}<br>Data: ${dateinsert}`)
        .addTo(markerLayer.value);
    });
  }
};

const toggleMapMode = () => {
  isHeatmapMode.value = !isHeatmapMode.value;
  if (isHeatmapMode.value) {
    map.value.addLayer(heatmapLayer.value).removeLayer(markerLayer.value);
  } else {
    map.value.addLayer(markerLayer.value).removeLayer(heatmapLayer.value);
  }
};

const fetchMapData = async () => {
  try {
    const formattedDateIni = formatDateTimeForAPI(dateIni.value);
    const formattedDateFin = formatDateTimeForAPI(dateFin.value);
    const data = await postsStore.searchData(formattedDateIni, formattedDateFin);
    mapData.value = data;
    updateHeatmap();
    updateMarkers();
  } catch (error) {
    console.error("Erro ao buscar dados para o mapa:", error);
  }
};

onMounted(() => {
  initializeMap();
  fetchMapData();

  map.value.addLayer(markerLayer.value);
});
</script>

<template>
  <div class="grid h-screen w-full pl-[56px]">
    <aside class="fixed inset-y-0 left-0 z-20 flex h-full flex-col border-r">
      <div class="border-b p-2">
        <Button variant="outline" size="icon" aria-label="Home">
          <Waves class="size-5 fill-foreground" />
        </Button>
      </div>
      <nav class="grid gap-1 p-2">
        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button variant="ghost" size="icon" class="rounded-lg bg-muted" aria-label="Dashboard">
                <SquareTerminal class="size-5" />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="right" :side-offset="5">Dashboard</TooltipContent>
          </Tooltip>
        </TooltipProvider>
      </nav>
      <nav class="mt-auto grid gap-1 p-2">
        <TooltipProvider>
          <Tooltip>
            <TooltipTrigger as-child>
              <Button variant="ghost" size="icon" class="mt-auto rounded-lg" aria-label="Account">
                <SquareUser class="size-5" />
              </Button>
            </TooltipTrigger>
            <TooltipContent side="right" :side-offset="5">Conta</TooltipContent>
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
            <TooltipContent side="right" :side-offset="5">Sair</TooltipContent>
          </Tooltip>
        </TooltipProvider>
      </nav>
    </aside>
    <div class="flex flex-col">
      <header class="sticky top-0 z-10 flex h-[57px] items-center gap-1 border-b bg-background px-4">
        <h1 class="text-xl font-semibold">Dashboard</h1>
        <Button size="sm" class="ml-auto gap-1.5 text-sm" @click="toggleMapMode">
          {{ isHeatmapMode ? "Mostrar Marcadores" : "Mapa de calor" }}
        </Button>

        <Label for="dateIni">Inicio:</Label>
        <input
          id="dateIni"
          type="date"
          v-model="dateIni"
          class="border p-2 rounded"
        />
        <Label for="dateFin">Fim:</Label>
        <input
          id="dateFin"
          type="date"
          v-model="dateFin"
          class="border p-2 rounded"
        />
        <Button @click="fetchMapData">Search</Button>

        <Button variant="outline" size="sm" class="ml-auto gap-1.5 text-sm" disabled>
          <Share class="size-3.5" /> Compartilhar
        </Button>
      </header>
      <main class="h-full w-full">
        <div id="map" class="h-full w-full"></div>
      </main>
    </div>
  </div>
</template>
