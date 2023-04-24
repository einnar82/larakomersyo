<script setup>
import {reactive, ref} from "vue";
import { useAuthStore } from "../../stores/auth";

const auth = useAuthStore();

const name = ref(null);
const email = ref(null);
const password = ref(null);
const rules = reactive(ref({
    required: value => !!value || 'Required.',
    min: v => v.length >= 8 || 'Min 8 characters'
}))

const showPassword = ref(false)
const errorMessage = ref(null);
const successMessage = ref(null);
const showErrorMessage = ref(false);
const HTTP_OK = 200;

const register = async (evt) => {
    const response = await auth.register({
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password.value
    })
    if (response.status === HTTP_OK) {
        successMessage.value = response.data.message
        showErrorMessage.value = false
        name.value = null;
        email.value = null;
        password.value = null;
    } else {
        errorMessage.value = response.data.message
        showErrorMessage.value = true
    }
}
</script>

<template>
    <div class="d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="400" class="mx-auto">
            <v-form fast-fail @submit.prevent="register">
                <v-text-field v-model="name" label="Full Name"></v-text-field>
                <v-text-field v-model="email" label="Email Address"></v-text-field>
                <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password"
                    @click:append="showPassword = !showPassword"
                ></v-text-field>
                <div class="text-body-1 text-red" v-if="showErrorMessage">{{errorMessage}}</div>
                <div class="text-body-1" v-else>{{successMessage}}</div>
                <v-btn type="submit" color="primary" block class="mt-2">Register</v-btn>

            </v-form>
        </v-sheet>
    </div>
</template>
