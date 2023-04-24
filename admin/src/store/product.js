import { defineStore } from 'pinia'
import httpClient from "@/http";
import {useAuthStore} from "@/store/auth";
import {computed, reactive, ref} from "vue";

export const useProductStore = defineStore('product', () => {
  const products = ref([]);
  const product = reactive({})

  const getProducts = computed(() => products.value)
  const getProduct = computed(() => product.value)
  const fetchProducts = async () => {
    try {
      const auth = useAuthStore();
      const token = auth.getToken;
      const response = await httpClient({
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).get('/products')
      products.value = response.data.data;
    } catch (err) {
      return err.response;
    }
  }

  const fetchSelectedProduct = async (id) => {
    try {
      const auth = useAuthStore();
      const token = auth.getToken;
      const response = await httpClient({
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).get(`/products/${id}`)
      product.value = response.data.data;

    } catch (err) {
      return err.response;
    }
  }

  const updateSelectedProduct = async (id, data = {}) => {
    try {
      const auth = useAuthStore();
      const token = auth.getToken;
      const response = await httpClient({
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).put(`/products/${id}`, data)
      product.value = response.data.data;

      return response;
    } catch (err) {
      return err.response;
    }
  }

  const deleteProduct = async (id) => {
    try {
      const auth = useAuthStore();
      const token = auth.getToken;
      const response = await httpClient({
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).delete(`/products/${id}`)

      products.value = products.value.filter(product => product.id !== id);
    } catch (err) {
      return err.response;
    }
  }

  return {
    fetchProducts,
    fetchSelectedProduct,
    deleteProduct,
    updateSelectedProduct,
    getProducts,
    getProduct
  }
})
