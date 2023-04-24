<script setup>
import {ref} from "vue";
import { useAuthStore } from "../../stores/auth";

const auth = useAuthStore();
const email = ref(null);

const errorMessage = ref(null);
const successMessage = ref(null);
const showErrorMessage = ref(false);
const HTTP_OK = 200;

const forgotPassword = async (evt) => {
    const response = await auth.forgotPassword(email.value)
    if (response.status === HTTP_OK) {
        successMessage.value = response.data.status;
        showErrorMessage.value = false;
        email.value = null;
    } else {
        showErrorMessage.value = true;
        errorMessage.value = response.data.message
    }
}
</script>

<template>
    <div class="d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="400" class="mx-auto">
            <v-form fast-fail @submit.prevent="forgotPassword">
                <v-text-field v-model="email" label="Email Address"></v-text-field>
                <div class="text-body-1 text-red" v-if="showErrorMessage">{{errorMessage}}</div>
                <div class="text-body-1" v-else>{{successMessage}}</div>
                <v-btn type="submit" color="primary" block class="mt-2">Send Reset Password Link</v-btn>

            </v-form>
        </v-sheet>
    </div>
</template>
