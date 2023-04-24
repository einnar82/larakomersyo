<script setup>
import {onMounted, ref} from 'vue'
import { useField, useForm } from 'vee-validate'
import {useRoute, useRouter} from "vue-router";
import {useProductStore} from "@/store/product";
import {storeToRefs} from "pinia";
import {useUploadStore} from "@/store/upload";

const isSuccessful = ref(false);
const isFailed = ref(false)
const product = useProductStore();
const router = useRouter();
const route = useRoute();
const upload = useUploadStore();
const { getProduct } = storeToRefs(product)
const { getImageUrl } = storeToRefs(upload);

const { handleSubmit, setFieldValue } = useForm({
  initialValues: getProduct,
  validationSchema: {
    name (value) {
      if (value?.length >= 2) return true

      return 'Product name needs to be at least 2 characters.'
    },
    price (value) {
      if (value > 0 && /[0-9-]+/.test(value)) return true

      return 'Price must be greater than 0.'
    },
    description (value) {
      if (value?.length >= 1) return true

      return 'Description needs to be at least 1 characters.'
    },
    image_url(value) {
      if (value !== null) return true;

      return 'Image url is required.'
    }
  },
})
const name = useField('name')
const price = useField('price')
const description = useField('description')
const image_url = useField('image_url')


const back = () => {
  router.push('/administrator/products')
}

const updateSelectedProduct = async () => {
    const url = new URL(image_url.value.value)

    const response = await product.updateSelectedProduct(route.params.id, {
      name: name.value.value,
      price: price.value.value,
      description: description.value.value,
      image_url: url.pathname.replace('/', '')
    })

  if (response.status === 200) {
      isSuccessful.value = true
      isFailed.value = false
  } else {
      isFailed.value = true
      isSuccessful.value = false
  }
}

const getModelValue = async (file) => {
  let formData = new FormData();
  formData.append('file', file[0]);
  await upload.uploadImage(formData)
  setFieldValue('image_url', `${getImageUrl.value}`)
}


onMounted(() => {
  product.fetchSelectedProduct(route.params.id);
})

</script>

<template>
  <v-container>
    <v-row>
      <v-col>
        <v-alert
          type="success"
          title="Success"
          class="mb-16"
          text="Product information updated"
          v-show="isSuccessful"
        ></v-alert>
        <v-alert
          type="error"
          title="Failed"
          class="mb-16"
          text="Product information updating failed."
          v-show="isFailed"
        ></v-alert>
        <form @submit.prevent="updateSelectedProduct">
          <v-img :src="image_url.value.value"
                  height="200"
                  class="mb-4">

          </v-img>
          <v-file-input
            accept="image/*"
            label="File input"
            @update:modelValue="getModelValue"
          ></v-file-input>
          <v-text-field
            v-model="name.value.value"
            :counter="10"
            :error-messages="name.errorMessage.value"
            label="Name"
          ></v-text-field>

          <v-text-field
            v-model="price.value.value"
            :error-messages="price.errorMessage.value"
            label="Price"
            min="1"
          ></v-text-field>

          <v-textarea
            v-model="description.value.value"
            :error-messages="description.errorMessage.value"
            label="Description"
          ></v-textarea>

          <v-btn
            class="me-4"
            type="submit"
          >
            Submit
          </v-btn>

          <v-btn @click="back">
            Back
          </v-btn>
        </form>
      </v-col>
    </v-row>
  </v-container>
</template>
