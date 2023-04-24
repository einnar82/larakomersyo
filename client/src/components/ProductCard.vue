<script setup>
import {useRouter} from "vue-router";

const router = useRouter()

const slugify = str =>
    str.toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
const viewProductDetail = (product = {}) => {
    router.push(`/product/${product.id}/${slugify(product.name)}`)
}

const props = defineProps({
    created_at: String,
    description: String,
    id: Number,
    image_url: String,
    name: String,
    price: Number,
    updated_at: String
})
</script>

<template>
    <v-card
        className="mx-auto"
        max-width="400"
    >
        <v-img
            className="align-end text-white"
            height="200"
            :src="image_url"
            cover
        >
        </v-img>

        <v-card-text>
            <div>$ {{price}}</div>

            <div>{{name}}</div>
        </v-card-text>

        <v-card-actions>
            <v-btn color="orange"
                    @click="viewProductDetail({
                        name: name,
                        id: id
                    })">
                View
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
