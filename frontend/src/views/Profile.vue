<template>
  <section id="section-profile">
    <div>Добро пожаловать, <b>{{ username }}</b>! Вы вошли как <b>{{ role }}</b>.</div>
  </section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
import { mapGetters, mapActions } from 'vuex';
export default {
  username: "Error",
  data: () => ({
    username: "",
    role: ""
  }),
  async mounted() {
    this.username = this.userInfo.username;
    this.role = this.userInfo.role;
  },
  computed: {
    ...mapGetters(["userInfo"])
  }
};
</script>

<style lang="scss">
#section-profile {
  margin: 1rem;
}
</style>
