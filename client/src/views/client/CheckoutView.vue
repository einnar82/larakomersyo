<script setup>
import {onMounted, ref} from "vue";
import {useCartStore} from "../../stores/cart";
import {storeToRefs} from "pinia";
import {useCheckoutStore} from "../../stores/checkout";
import {useRouter} from "vue-router";


const cart = useCartStore();
const checkout = useCheckoutStore();
const router = useRouter();
const {getCartItems} = storeToRefs(cart);

const deleteCartItem = async (id) => {
    await cart.deleteCartItem(id)
}
const totalProductPrice = (quantity,amount) => {
    const product = quantity * amount
    return product.toFixed(2);
}
const getTotalAmount = () => getCartItems.value
    .map(cartItem => cartItem.product.price * cartItem.quantity)
    .reduce((accumulator, currentValue) => accumulator + currentValue, 0)
    .toFixed(2)

const listenModel = async (value, id) => {
    if (value === 0) {
        await cart.deleteCartItem(id)
    }
}

const checkoutCart = async () =>{
    const response = await checkout.checkoutOrder();
    await router.replace({
        path: '/redirect',
        replace: true,
        query: {
            url: response.data
        }
    })
}

onMounted(() => {
    cart.fetchCartItems()
})

</script>
<template>
    <v-row>
        <v-container>
            <p class="text-h3 text-center pa-4">SHOPPING CART</p>
            <v-row>
                <v-col :cols="12" md="9" sm="12" >
                    <v-table>
                        <template v-slot:default>
                            <thead>
                            <tr>
                                <th class="text-center">ITEM</th>
                                <th class="text-center">PRICE</th>
                                <th class="text-center">QUANTITY</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(cartItem, index) in getCartItems"
                                :key="index">
                                <td>
                                    <v-list
                                        :items="[{
                                            prependAvatar: cartItem.product.image_url,
                                            title: cartItem.product.name
                                        }]"
                                        item-props
                                        lines="two"
                                    >
                                    </v-list>
                                </td>
                                <td>${{cartItem.product.price}}</td>
                                <td>
                                    <v-text-field
                                        class="pt-10"
                                        style="width: 80px;"
                                        single-line
                                        outlined
                                        v-model="cartItem.quantity"
                                        @update:modelValue="((evt) => listenModel(evt, cartItem.id))"
                                        min="0"
                                        type="number"
                                    ></v-text-field>
                                </td>
                                <td>${{totalProductPrice(cartItem.quantity, cartItem.product.price)}}</td>
                                <td @click="deleteCartItem(cartItem.id)"><a>X</a></td>
                            </tr>
                            </tbody>
                        </template>
                    </v-table>
                </v-col>
                <v-col :cols="12" md="3" sm="12" style="background-color: lightgray">
                    <p class="headline">Order Summary</p>
                    <p class="overline">Shipping and additional costs are calculated based on values you have entered.
                    </p>
                    <v-table>
                        <template v-slot:default>
                            <tbody>
                            <tr>
                                <td>Total</td>
                                <td class="text-right" style="width: 50px;"><b>${{getTotalAmount()}}</b></td>
                            </tr>
                            </tbody>
                        </template>
                    </v-table>
                    <div class="text-center">
                        <v-btn class="primary white--text mt-5"
                               outlined
                                @click="checkoutCart">PROCEED TO PAY</v-btn>
                    </div>
                </v-col>
            </v-row>
        </v-container>
    </v-row>
</template>
