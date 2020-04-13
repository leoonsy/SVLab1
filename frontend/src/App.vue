<template>
  <div id="app">
    <PageLoader></PageLoader>
    <component :is="this.$route.meta.layout || 'div'">
      <router-view />
    </component>
  </div>
</template>
<script>
import PageLoader from "@/components/PageLoader";

export default {
  name: "App",
  components: {
    PageLoader
  }
};
</script>
<style lang="scss">
@import "@/styles/libs.scss";
@import "@/styles/main.scss";
</style>
