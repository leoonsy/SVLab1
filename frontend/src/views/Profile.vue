<template>
  <section id="section-profile">
    <div>Добро пожаловать, <b>{{ userInfo.name }}</b>! Вы вошли как <b>{{ userInfo.role }}</b>.</div>
  </section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
import { mapGetters, mapActions } from 'vuex';
export default {
  name: "Error",
  created() {
    this.$emit("update:layout", MainLayout);
  },
  data: () => ({
    name: "",
    role: ""
  }),
  async mounted() {
    this.name = this.userInfo.name;
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
