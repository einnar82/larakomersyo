<script setup>

import {ref} from "vue";
import {useAuthStore} from "@/store/auth";
import {storeToRefs} from "pinia";
import {useRouter} from "vue-router";

const drawer = ref(false);
const auth = useAuthStore();
const router = useRouter();
const {isAuthenticated} = storeToRefs(auth)

const logout = async () => {
  await auth.logout();
  await router.push('/login');
  localStorage.clear();
}

</script>
<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer">
      <v-list density="compact" nav>
        <v-list-item prepend-icon="mdi-view-dashboard" title="Products" value="home" to="/administrator/products">
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Administrator</v-toolbar-title>
      <v-spacer></v-spacer>

      <v-btn prepend-icon="mdi-logout"
             @click="logout"
             v-show="isAuthenticated">
        Logout
      </v-btn>
    </v-app-bar>

    <v-main>
      <router-view v-if="isAuthenticated"/>
      <v-alert
        type="error"
        title="Unauthorized"
        text="Please login!"
        v-else
      ></v-alert>
    </v-main>
  </v-app>
</template>
