import { defineStore } from 'pinia'
import httpClient from "../http";
import {useAuthStore} from "./auth";

export const useCartStore = defineStore('cart', {
    state: () => ({
        cartItems: []
    }),
    getters: {
        getCartItems: (state) => state.cartItems
    },
    actions: {
        async addToCart(items) {
            try {
                const auth = useAuthStore();
                const token = auth.getToken;
                const response = await httpClient({
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).post('/cart', {
                    items: items
                })

                this.cartItems = response.data.data.filter(cart => cart.quantity !== 0);
            } catch (err) {
                this.cartItems = []
            }
        },
        async updateCart(items) {
            try {
                const auth = useAuthStore();
                const token = auth.getToken;
                const response = await httpClient({
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).put('/cart/update', {
                    items: items
                })

                this.cartItems = response.data.data.filter(cart => cart.quantity !== 0);
            } catch (err) {
                this.cartItems = []
            }
        },
        async fetchCartItems() {
            try {
                const auth = useAuthStore();
                const token = auth.getToken;
                const response = await httpClient({
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                }).get('/cart')

                this.cartItems = response.data.data.filter(cart => cart.quantity !== 0);
            } catch (err) {
                this.cartItems = []
            }
        },
        async deleteCartItem(id) {
            const auth = useAuthStore();
            const token = auth.getToken;
            await httpClient({
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }).delete(`/cart/${id}`)

            this.cartItems = this.cartItems.filter(cartItem => cartItem.id !== id);
        }
    },
    persist:true
})

