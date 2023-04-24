import { defineStore } from 'pinia'
import httpClient from "../http";
import {reactive, ref} from "vue";

export const useProductStore = defineStore('product', () => {
    const products = ref([]);
    const product = ref({});
    const getProducts = async () => {
        try {
            const response = await httpClient().get('/products')
            products.value = response.data.data;
        } catch (err) {
            products.value = [];
        }
    }

    const getProduct = async (id) => {
        try {
            const response = await httpClient().get(`/products/${id}`)
            product.value = response.data.data;
        } catch (err) {
            product.value = {};
        }
    }

    return {
        products,
        product,
        getProducts,
        getProduct
    }
})
