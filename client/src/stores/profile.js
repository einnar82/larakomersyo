import { defineStore } from 'pinia'
import httpClient from "../http";
import {useAuthStore} from "./auth";

export const useProfileStore = defineStore('profile', {
    state: () => ({
        user: {}
    }),
    getters: {
        getUserDetails: (state) => state.user
    },
    actions: {
        async fetchUserDetails() {
            try {
                const auth = useAuthStore();
                const token = auth.getToken;
                const response = await httpClient({
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).get('/me')

                this.user = response.data;
            } catch (err) {
                this.user = {
                    name: 'GUEST'
                }
            }
        }
    },
    persist:true
})

