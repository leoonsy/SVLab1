<template>
  <section id="section-main">
    <div>Список дел</div>
  </section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
export default {
  name: "Root",
  created() {
    this.$emit("update:layout", MainLayout);
  }
};
</script>
<style>
</style>