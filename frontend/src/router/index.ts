import { createRouter, createWebHistory } from "vue-router";

import Home from "@/views/Home.vue";
import Login from "@/views/auth/Login.vue";
import Register from "@/views/auth/Register.vue";
// import CreateView from "@/views/Posts/CreateView.vue";
// import ShowView from "@/views/Posts/ShowView.vue";
// import UpdateView from "@/views/Posts/UpdateView.vue";
import { useAuthStore } from "@/stores/auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: Home,
    },
    {
      path: "/register",
      name: "register",
      component: Register,
      meta: { guest: true },
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      meta: { guest: true },
    },
    // {
    //   path: "/create",
    //   name: "create",
    //   component: CreateView,
    //   meta: { auth: true },
    // },
    // {
    //   path: "/posts/:id",
    //   name: "show",
    //   component: ShowView,
    // },
    // {
    //   path: "/posts/update/:id",
    //   name: "update",
    //   component: UpdateView,
    //   meta: { auth: true },
    // },
  ],
});

router.beforeEach(async (to, from) => {
  const authStore = useAuthStore();
  await authStore.getUser();

  if (authStore.user && to.meta.guest) {
    return { name: "dashboard" };
  }

  if (!authStore.user && to.meta.auth) {
    return { name: "home" };
  }
});

export default router;