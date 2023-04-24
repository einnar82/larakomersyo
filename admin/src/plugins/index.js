/**
 * plugins/index.js
 *
 * Automatically included in `./src/main.js`
 */

// Plugins
import { loadFonts } from './webfontloader'
import vuetify from './vuetify'
import pinia from '../store'
import router from '../router'
import {useAuthStore} from "@/store/auth";
import {storeToRefs} from "pinia";

router.beforeEach(async (to, from) => {
  const auth = useAuthStore();
  const {isAuthenticated} = storeToRefs(auth)
  if (
    // make sure the user is authenticated
    !isAuthenticated &&
    // ❗️ Avoid an infinite redirect
    to.name !== 'login'
  ) {
    // redirect the user to the login page
    return { name: 'login' }
  }
})


export function registerPlugins (app) {
  loadFonts()
  app
    .use(vuetify)
    .use(router)
    .use(pinia)
}
