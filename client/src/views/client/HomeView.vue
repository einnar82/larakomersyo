<script setup>
import ProductCard from "../../components/ProductCard.vue";
import {useProductStore} from "../../stores/product";
import {onMounted} from "vue";
import {storeToRefs} from "pinia";
const product = useProductStore();

const { products } = storeToRefs(product);

onMounted( () => {
    product.getProducts()
})
</script>

<template>
    <v-row>
        <v-col
            v-for="(product,index) in products"
            :key="index"
            lg="4"
            xl="4"
            xxl="3"
            md="6"
            sm="12"
        >
            <ProductCard v-bind="product"/>
        </v-col>
    </v-row>
</template>
