import { defineStore } from 'pinia'
import httpClient from "../http";

export const useAuthStore = defineStore('auth', {
    persist: true,
    actions: {
        async login(credentials = {}) {
            try {
                return await httpClient()
                    .post('/login', credentials, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
            } catch (err) {
                return err.response;
            }
        },
        async register(data = {}) {
            try {
                return await httpClient()
                    .post('/register', data, {
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
                .post('/logout', {}, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                this.isAuthenticated = false
            } catch (err) {
                return err.response;
            }
        },
        async forgotPassword(email = ''){
            try {
                return await httpClient()
                    .post('/forgot-password', {
                        email: email
                    }, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
            } catch (err) {
                return err.response;
            }
        },
        async passwordReset(credentials = {}) {
            try {
                return await httpClient()
                    .post('/reset-password', credentials, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
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
