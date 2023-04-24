<script setup>

import {ref} from "vue";

const drawer = ref(false);

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
    </v-app-bar>

    <v-main>
      <router-view/>
    </v-main>
  </v-app>
</template>
