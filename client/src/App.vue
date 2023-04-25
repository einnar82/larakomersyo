<script setup>

import {useRouter} from "vue-router";
import {useCartStore} from "./stores/cart";
import {storeToRefs} from "pinia";
import {onMounted} from "vue";
import {useAuthStore} from "./stores/auth";
import {useProfileStore} from "./stores/profile";

const router = useRouter();
const cart = useCartStore();
const auth = useAuthStore()
const profile = useProfileStore();
const {getCartItems} = storeToRefs(cart);
const {isAuthenticated} = storeToRefs(auth)
const { user } = storeToRefs(profile);



const gotToHomepage = () => {
    router.push('/')
}

const goToCheckout = () => {
    router.push('/checkout')
}

const getFullName = () => {
    return user.value.hasOwnProperty('name')  ? user.value.name.toUpperCase() : 'GUEST';
}

const goToLogin = () => {
    if (isAuthenticated.value === false) {
        router.push('/login')
    }
}

const logout = async () => {
    await auth.logout();
    await router.push('/login');
    localStorage.clear();
}

onMounted(() => {
    if (isAuthenticated.value === true) {
        profile.fetchUserDetails()
        cart.fetchCartItems()
    }
})
</script>
<template>
    <v-app id="inspire">
        <v-app-bar app>
            <v-toolbar-title @click="gotToHomepage"
                    style="cursor: pointer">Larakomersyo</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn prepend-icon="mdi-cart"
                   @click="goToCheckout"
                   v-show="isAuthenticated"
                   :disabled="getCartItems.length === 0">
                ({{getCartItems.length}})
            </v-btn>
            <v-btn prepend-icon="mdi-account-circle"
                   @click="goToLogin"
                    v-show="isAuthenticated">
                {{getFullName()}}
            </v-btn>
            <v-btn prepend-icon="mdi-logout"
                    @click="logout"
                   v-show="isAuthenticated">
                Logout
            </v-btn>
            <v-btn prepend-icon="mdi-login"
                   @click="goToLogin"
                   v-show="!isAuthenticated">
                Login
            </v-btn>
        </v-app-bar>

        <v-main>
            <v-container>
                <router-view/>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

</script>
