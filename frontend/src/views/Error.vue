<template>
  <section id="section-error">
    <div class="container">
      <div class="error">{{ message }}</div>
    </div>
  </section>
</template>

<script>
import EmptyLayout from "@/layouts/EmptyLayout";
export default {
  name: "Error",
  computed: {
    message() {
      let results = {
        "403": "Ошибка доступа",
        "404": "Данной страницы не существует",
        "500": "Внутренняя ошибка сервера"
      };

      let code = this.$route.params.code;
      debugger;
      if (!code || !results.hasOwnProperty(code))
        return results['404'];

      return results[code];
    }
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
