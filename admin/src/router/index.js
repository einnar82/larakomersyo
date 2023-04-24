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
        name: 'product-list',
        component: () => import(/* webpackChunkName: "home" */ '@/views/ProductListView.vue'),
      },
      {
        path: 'products/:id',
        name: 'product-item',
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
