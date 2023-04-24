import { defineStore } from 'pinia'
import httpClient from "@/http";
import {computed, ref} from "vue";
import {useAuthStore} from "@/store/auth";

export const useUploadStore = defineStore('upload', () => {
  const imageUrl = ref(null)
  const getImageUrl = computed(() => imageUrl.value)
  const uploadImage = async (data) => {
    try {
      const auth = useAuthStore();
      const token = auth.getToken;
      const response = await httpClient({
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'multipart/form-data'
        }
      }).post(`/upload`, data)
      imageUrl.value = `${import.meta.env.VITE_IMAGE_BASE_URL}${response.data.path}`;

      return response;
    } catch (err) {
      return err.response;
    }
  }

  return {
    uploadImage,
    getImageUrl
  }
})
