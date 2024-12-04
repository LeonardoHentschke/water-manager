<script setup>
import { Button } from '@/components/ui/button'

import "leaflet/dist/leaflet.css";
import leaflet from "leaflet";
import "leaflet.heat";
import { onMounted, watchEffect, ref } from "vue";
import { useGeolocation } from "@vueuse/core";
import { userMarker, nearbyMarkers } from "@/stores/map";

const { coords } = useGeolocation();

let map;
let userGeoMarker;
let markersLayer = [];
let heatmapLayer;

const showHeatMap = ref(false);

const createMarker = (lat, lng, popupText) => {
  const marker = leaflet
    .marker([lat, lng])
    .addTo(map)
    .bindPopup(popupText);

  // Adiciona um evento de clique no marcador para removê-lo
  marker.on("click", () => {
    map.removeLayer(marker);
    nearbyMarkers.value = nearbyMarkers.value.filter(
      (m) => m.latitude !== lat || m.longitude !== lng
    );
  });

  markersLayer.push(marker); // Armazena o marcador no array
};

const toggleHeatMap = () => {
  showHeatMap.value = !showHeatMap.value;

  if (showHeatMap.value) {
    // Remove os marcadores
    markersLayer.forEach((marker) => map.removeLayer(marker));

    // Adiciona o heatmap
    const heatData = nearbyMarkers.value.map(({ latitude, longitude }) => [
      latitude,
      longitude,
      50, // Intensidade (ajustável)
    ]);
    heatmapLayer = leaflet.heatLayer(heatData, { radius: 20 }).addTo(map);
  } else {
    // Remove o heatmap
    if (heatmapLayer) map.removeLayer(heatmapLayer);

    // Recoloca os marcadores
    nearbyMarkers.value.forEach(({ latitude, longitude }) =>
      createMarker(latitude, longitude, `Saved Marker at (<strong>${latitude.toFixed(2)},${longitude.toFixed(2)})</strong>`)
    );
  }
};

onMounted(() => {
  map = leaflet
    .map("map")
    .setView([userMarker.value.latitude, userMarker.value.longitude], 13);

  leaflet
    .tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    })
    .addTo(map);

  nearbyMarkers.value.forEach(({ latitude, longitude }) =>
    createMarker(latitude, longitude, `Saved Marker at (<strong>${latitude.toFixed(2)},${longitude.toFixed(2)})</strong>`)
  );

  map.addEventListener("click", (e) => {
    const { lat: latitude, lng: longitude } = e.latlng;
    createMarker(latitude, longitude, `Saved Marker at (<strong>${latitude.toFixed(2)},${longitude.toFixed(2)})</strong>`);
    nearbyMarkers.value.push({ latitude, longitude });
  });
});

watchEffect(() => {
  const { latitude, longitude } = coords.value;
  if (latitude !== Number.POSITIVE_INFINITY && longitude !== Number.POSITIVE_INFINITY) {
    userMarker.value.latitude = latitude;
    userMarker.value.longitude = longitude;

    if (userGeoMarker) map.removeLayer(userGeoMarker);

    userGeoMarker = leaflet
      .marker([latitude, longitude])
      .addTo(map)
      .bindPopup("Marcado pelo sistema");

    map.setView([latitude, longitude], 13);

    const el = userGeoMarker.getElement();
    if (el) el.style.filter = "hue-rotate(120deg)";
  }
});
</script>

<template>
  <div class="flex">
    <Button variant="outline" class="mb-2" @click="toggleHeatMap">{{ showHeatMap ? "Mostrar marcadores" : "Mapa de calor" }}</Button>
  </div>
  <div id="map" style="height:75vh;"></div>
</template>
