<template>
  <div id="wrapper">
    <div id="content">
      <Navbar />
      <slot />
    </div>
    <div id="footer"></div>
  </div>
</template>
<script>
import Loader from "@/components/Loader";
import Navbar from "@/components/Navbar";
export default {
  name: 'MainLayout',
  components: {
    Navbar
  }
  // data: () => ({
  //   loading: false
  // }),
  // components: {
  //   Loader
  // },
  // async mounted() {
  //   if (Object.keys(this.$store.getters.userInfo).length == 0) {
  //     await this.$store.dispatch("updateUserInfo");
  //   }

  //   this.loading = false;
  // }
};
</script>
<style lang="scss">
#wrapper {
  display: flex;
  flex: 1 1 auto; //for IE10-11 fix footer
  flex-flow: column nowrap;
  min-height: 100vh;
}

#content {
  flex: 1 0 auto;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

#footer {
  flex: 0 0 auto;
}
</style>