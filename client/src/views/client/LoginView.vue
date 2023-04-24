<script setup>
import {reactive, ref} from 'vue';
import { useAuthStore } from "../../stores/auth";
import {useRouter} from "vue-router";

const auth = useAuthStore();
const router = useRouter();

const email = ref(null);
const password = ref(null);
const showPassword = ref(false);
const rules = reactive(ref({
    required: value => !!value || 'Required.',
    min: v => v.length >= 8 || 'Min 8 characters'
}))
const errorMessage = ref(null);
const showErrorMessage = ref(false);
const HTTP_OK = 200;

const login = async (evt) => {
    const data = await auth.login({
        email: email.value,
        password: password.value
    })

    if (data.status === HTTP_OK) {
        const token = data.data.access_token;
        auth.$patch((state) => {
            state.token = token
            state.isAuthenticated = true
        })
        showErrorMessage.value = false;
        await router.push('/');
    }
    errorMessage.value = data.data.message;
    showErrorMessage.value = true;
}

const goToSignup = () => {
    router.push('/signup')
}

const goToForgotPassword = () => {
    router.push('/forgot-password')
}
</script>

<template>
    <div class="d-flex align-center justify-center" style="height: 100vh">
        <v-sheet width="400" class="mx-auto">
            <v-form fast-fail @submit.prevent="login">
                <v-text-field v-model="email" label="Email Address"></v-text-field>
                <v-text-field
                    v-model="password"
                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                    :rules="[rules.required, rules.min]"
                    :type="showPassword ? 'text' : 'password'"
                    label="Password"
                    @click:append="showPassword = !showPassword"
                ></v-text-field>
                <div class="text-body-1 text-red" v-show="showErrorMessage">{{errorMessage}}</div>
                <a href="#"
                   class="text-body-2 font-weight-regular"
                   @click="goToForgotPassword">Forgot Password?</a>

                <v-btn type="submit" color="primary" block class="mt-2">Sign in</v-btn>

            </v-form>
            <div class="mt-2">
                <p class="text-body-2">Don't have an account? <a href="#" @click="goToSignup">Sign Up</a></p>
            </div>
        </v-sheet>
    </div>
</template>
