<template>
  <section id="section-admin">
    <div class="container">
        Панель администратора
    </div>
  </section>
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

</style>
