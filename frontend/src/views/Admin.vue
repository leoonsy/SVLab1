<template>
  <section id="section-admin">Панель администратора</section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
export default {
  name: "Error",
  created() {
    this.$emit("update:layout", MainLayout);
  }
};
</script>

<style lang="scss">
#section-admin {
  margin: 1rem;
}
</style>
