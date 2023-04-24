import {defineStore} from 'pinia'
import httpClient from "../http";
import {useAuthStore} from "./auth";

export const useCheckoutStore = defineStore('checkout', () => {
    const checkoutOrder = async () => {
        const auth = useAuthStore();
        const token = auth.getToken;
        try {
            return await httpClient({
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            }).post('/checkout');
        } catch (err) {
            return err.response;
        }
    }

    return {
        checkoutOrder
    }
})
