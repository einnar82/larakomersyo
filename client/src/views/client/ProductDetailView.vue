<script setup>
import {useProductStore} from "../../stores/product";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import {storeToRefs} from "pinia";
import { useCartStore} from "../../stores/cart";
import router from "../../router";
import {useAuthStore} from "../../stores/auth";

const productStore = useProductStore();
const cart = useCartStore()
const route = useRoute();
const quantity = ref(1);
const { product } = storeToRefs(productStore);
const productId = route.params.id
const auth = useAuthStore();
const {isAuthenticated} = storeToRefs(auth)

const addToCart = async () => {
    if (isAuthenticated.value) {
        await cart.addToCart([
            {
                "product_id": productId,
                "quantity": quantity.value
            }
        ])
    } else {
        await router.push('/login')
    }
}

const backToProductList = () => {
    router.push('/')
}

onMounted(() => {
    productStore.getProduct(productId);
})
</script>

<template>
    <v-row>
        <v-container>
            <v-row>
                <v-col
                    md="4"
                    lg="4"
                    xl="4"
                    xxl="4">
                    <v-img
                        className="align-end text-white"
                        height="400"
                        :src="product.image_url"
                        cover
                    >
                    </v-img>
                </v-col>
                <v-col
                    md="8"
                    lg="8"
                    xl="8"
                    xxl="8">
                    <v-container>
                        <v-row>
                            <v-col
                                cols="12">
                                <div class="text-h4 mb-2">{{product.name}}</div>
                                <div class="text-h5 mb-2">$ {{product.price}}</div>
                                <div class="text-body-1 mb-2">{{product.description}}</div>
                                <div class="text-h5 mb-2">QUANTITY</div>
                                <v-responsive
                                    max-width="100"
                                >
                                    <v-text-field
                                        type="number"
                                        v-model="quantity"
                                        min="1"
                                    ></v-text-field>
                                </v-responsive>
                                <v-btn prepend-icon="mdi-cart"
                                       color="blue-grey-darken-1"
                                       class="mr-2"
                                        @click="addToCart">
                                    ADD TO CART
                                </v-btn>
                                <v-btn prepend-icon="mdi-list-box-outline"
                                       @click="backToProductList">
                                    BACK TO PRODUCT LIST
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-col>
            </v-row>
        </v-container>
    </v-row>
</template>


