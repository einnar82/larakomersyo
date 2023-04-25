<script setup>
import {ref, toRaw} from 'vue'
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
const { getImageUrl } = storeToRefs(upload);
const uploader = ref(null)

const { resetForm, setFieldValue } = useForm({
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

const createProduct = async () => {
  const url = new URL(image_url.value.value)
  const formattedPrice = Number(price.value.value)

  const response = await product.createProduct({
    name: name.value.value,
    price: parseFloat(formattedPrice).toFixed(2),
    description: description.value.value,
    image_url: url.pathname.replace('/', '')
  })

  let HTTP_CREATED = 201;
  if (response.status === HTTP_CREATED) {
    isSuccessful.value = true
    isFailed.value = false
    await resetForm();
    const instance = toRaw(uploader.value);
    await instance.reset()
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

</script>

<template>
  <v-container>
    <v-row>
      <v-col>
        <v-alert
          type="success"
          title="Success"
          class="mb-16"
          text="Product information created"
          v-show="isSuccessful"
        ></v-alert>
        <v-alert
          type="error"
          title="Failed"
          class="mb-16"
          text="Product information creation failed."
          v-show="isFailed"
        ></v-alert>
        <form @submit.prevent="createProduct">
          <v-img :src="image_url.value.value"
                 height="200"
                 class="mb-4">

          </v-img>
          <v-file-input
            accept="image/*"
            label="File input"
            ref="uploader"
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
