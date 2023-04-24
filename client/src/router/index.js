import { createRouter, createWebHistory } from 'vue-router'
import HomeView from "../views/client/HomeView.vue";
import ProductDetail from "../views/client/ProductDetailView.vue";
import CheckoutView from "../views/client/CheckoutView.vue";
import LoginView from "../views/client/LoginView.vue";
import PaymentView from "../views/client/PaymentView.vue";
import SignupView from "../views/client/SignupView.vue";
import ForgotPasswordView from "../views/client/ForgotPasswordView.vue";
import ResetPasswordView from "../views/client/PasswordResetView.vue";
import SuccessPaymentView from "../views/client/SuccessPaymentView.vue";
import FailedPaymentView from "../views/client/FailedPaymentView.vue";


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/product/:id/:slug',
      name: 'product-detail',
      component: ProductDetail
    },
    {
      path: '/checkout',
      name: 'checkout',
      component: CheckoutView,
    },
    {
       path: '/login',
       name: 'login',
       component: LoginView
    },
    {
        path: '/payment',
        name: 'payment',
        component: PaymentView,
    },
    {
        path: '/signup',
        name: 'signup',
        component: SignupView
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        component: ForgotPasswordView
    },
    {
        path: '/password-reset/:token',
        name: 'password-reset',
        component: ResetPasswordView
    },
    {
        path: '/payment/success',
        name: 'payment-success',
        component: SuccessPaymentView
    },
    {
        path: '/payment/failed',
        name: 'payment-failed',
        component: FailedPaymentView
    },
    {
        path: "/redirect",
        name: 'redirect',
        beforeEnter(to, from, next) {
            window.location.replace(to.query.url);
        }
    }
  ]
})

// router.beforeEach(async (to, from, next) => {
//     const auth = useAuthStore();
//     const {isAuthenticated} = auth;
//
//     if (to.name !== 'login' && !isAuthenticated) next({ name: 'login' })
//     else next()
// })
export default router
