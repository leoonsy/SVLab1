<template>
  <div id="app">
    <component :is="layout">
      <router-view :layout.sync="layout" />
    </component>
  </div>
</template>
<script>

export default {
  name: 'App',
  data: () => ({
    layout: 'div'
  })
}
</script>
<style lang="scss">
@import '@/styles/libs.scss';
@import '@/styles/main.scss';
</style>
