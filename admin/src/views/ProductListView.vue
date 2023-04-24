<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import {useRouter} from "vue-router";
import {useProductStore} from "@/store/product";
import {storeToRefs} from "pinia";

const product  = useProductStore();
const {getProducts} = storeToRefs(product)
const router = useRouter();
const dialog = ref(false)
const dialogDelete = ref(false)
const editedIndex = ref(-1)
const headers = reactive([
  {
    title: 'ID',
    align: 'start',
    key: 'id',
  },
  {
    title: 'Logo',
    align: 'start',
    sortable: false,
    key: 'image_url'
  },
  { title: 'Name', align: 'start', key: 'name' },
  { title: 'Price', align: 'start', key: 'price' },
  { title: 'Actions', key: 'actions', sortable: false },
]);
const products = reactive([
  {
    id: 1,
    image_url: 'https://www.allrecipes.com/thmb/PHF_wbUzp-wIt6OYo2cMnt4xuZ4=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/25473-the-perfect-basic-burger-ddmfs-4x3-1350-1-f65d5518ecc0435f9791d453ee9cd78f.jpg',
    name: 'Frozen Yogurt',
    price: 24,
    description: 'lorem ipsum',
  },
])

const editedItem = reactive( {
  id: 1,
  image_url: null,
  name: null,
  price: 0,
  description: null,
})

const defaultItem = reactive( {
  image_url: null,
  name: null,
  price: 0,
  description: null,
})

const editItem = (item) => {
  editedIndex.value = getProducts.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  router.push(`/administrator/products/${item.id}`)
}

const deleteItem = (item) => {
  editedIndex.value = getProducts.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogDelete.value = true
}

const deleteItemConfirm = () => {
  product.deleteProduct(editedItem.value.id)
  products.splice(editedIndex.value, 1)
  closeDelete()
}

const close = () => {
  dialog.value = false
}

const closeDelete = () => {
  dialogDelete.value = false
}

const save = () => {
  if (editedIndex.value > -1) {
    Object.assign(getProducts.value[editedIndex.value], editedItem.value)
  } else {
    products.push(editedItem.value)
  }
  close()
}


watch(dialog, (value) => {
  value || close();
})

watch(dialogDelete, (value) => {
  value || closeDelete();
})

onMounted(() => {
  product.fetchProducts();
})
</script>

<template>
  <v-container>
    <v-row>
      <v-col>
        <v-data-table
          :headers="headers"
          :items="getProducts"
          class="elevation-1"
        >
          <template v-slot:top>
            <v-toolbar
              flat
            >
              <v-toolbar-title>Product Management</v-toolbar-title>
              <v-divider
                class="mx-4"
                inset
                vertical
              ></v-divider>
              <v-spacer></v-spacer>
              <v-dialog
                v-model="dialog"
                max-width="500px"
              >
                <template v-slot:activator="{ props }">
                  <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="props"
                  >
                    New Item
                  </v-btn>
                </template>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.image_url="{item}">
            <v-img :src="item.raw.image_url"
                  height="100"></v-img>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon
              size="small"
              class="me-2"
              @click="editItem(item.raw)"
            >
              mdi-pencil
            </v-icon>
            <v-icon
              size="small"
              @click="deleteItem(item.raw)"
            >
              mdi-delete
            </v-icon>
          </template>
          <template v-slot:no-data>
            <p>Nothing here.</p>
          </template>
        </v-data-table>
      </v-col>
    </v-row>
  </v-container>
</template>
