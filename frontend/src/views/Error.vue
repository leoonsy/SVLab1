<template>
  <section id="section-error">
    <div class="container">
      <div class="error">
        Данной страницы не существует
      </div>
    </div>
  </section>
</template>

<script>
import EmptyLayout from "@/layouts/EmptyLayout";
export default {
  name: "Error",
  created() {
    this.$emit("update:layout", EmptyLayout);
  }
};
</script>

<style lang="scss">
#section-error {
  height: 100vh;
  display: flex;
  align-items: center;
}

.error {
  text-align: center;
  font-size: 2rem;
}
</style>
