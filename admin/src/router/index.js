// Composables
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('@/layouts/default/Default.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import(/* webpackChunkName: "home" */ '@/views/LoginView.vue'),
      },
    ],
  },
  {
    path: '/administrator',
    component: () => import('@/layouts/default/Dashboard.vue'),
    children: [
      {
        path: 'products',
        name: 'list-products',
        component: () => import(/* webpackChunkName: "home" */ '@/views/ProductListView.vue'),
      },
      {
        path: 'products/create',
        name: 'create-product',
        component: () => import(/* webpackChunkName: "home" */ '@/views/CreateProductView.vue'),
      },
      {
        path: 'products/:id',
        name: 'get-product',
        component: () => import(/* webpackChunkName: "home" */ '@/views/ProductDetailView.vue'),
      }
    ],
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
})

export default router
