<template>
  <div id="app">
    <PageLoader></PageLoader>
    <component :is="layout">
      <router-view :layout.sync="layout" />
    </component>
  </div>
</template>
<script>
import PageLoader from "@/components/PageLoader";

export default {
  name: "App",
  data: () => ({
    layout: "div"
  }),
  components: {
    PageLoader
  }
};
</script>
<style lang="scss">
@import "@/styles/libs.scss";
@import "@/styles/main.scss";
</style>
