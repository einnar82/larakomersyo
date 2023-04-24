import { defineStore } from 'pinia'
import httpClient from "@/http";
export const useAuthStore = defineStore('auth', {
  persist: true,
  actions: {
    async login(credentials = {}) {
      try {
        return await httpClient()
          .post('/admin/login', credentials, {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          });
      } catch (err) {
        return err.response;
      }
    },
    async logout() {
      try {
        const auth = useAuthStore();
        const token = auth.getToken;
        await httpClient({
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
          .post('/admin/logout', {}, {
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          });
        this.isAuthenticated = false
      } catch (err) {
        return err.response;
      }
    }
  },
  getters: {
    getToken: (state) => state.token
  },
  state: () => ({
    isAuthenticated: false,
    token: null
  }),
})
