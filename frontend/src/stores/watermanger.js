import { defineStore } from "pinia";

export const useWaterManagerStore = defineStore("waterManagerStore", {
    actions: {
        async getProductId() {
            return await fetch('http://177.44.248.13:8080/WaterManager/productID.jsp?FORMAT=JSON', { mode: 'no-cors' });
        }
    },
});