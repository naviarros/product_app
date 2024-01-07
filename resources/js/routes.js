import { createRouter, createWebHistory } from 'vue-router';
import Login from './layouts/Login.vue';
import Dashboard from './components/dashboard/Dashboard.vue';
import CreateProduct from './components/dashboard/ProductCreate.vue'
import EditProduct from './components/dashboard/ProductEdit.vue'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: { requiresAuth: true }, // Optional: Add authentication meta field if needed
  },
  {
    path: '/create_product',
    name: 'create_product',
    component: CreateProduct,
    meta: { requiresAuth: true }
  },
  {
    path: '/edit_product/:id',
    name: 'edit_product',
    component: EditProduct,
    meta: { requiresAuth: true }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
