<template>
  <div id="wrapper">
    <div id="content">
      <nav>
        <div class="nav-wrapper">
          <a href="#" class="brand-logo nav-wrapper__brand">SOFT-VULN-LAB1</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
              <router-link to="/">Список дел</router-link>
            </li>
            <li>
              <router-link to="/profile">Профиль</router-link>
            </li>
            <li>
              <a href="/" @click.prevent="logout">Выход</a>
            </li>
          </ul>
        </div>
      </nav>
      <slot />
    </div>
    <div id="footer"></div>
  </div>
</template>
<script>
import Loader from "@/components/Loader";
export default {
  // data: () => ({
  //   loading: false
  // }),
  methods: {
    async logout() {
      await this.$store.dispatch('logout');
      this.$router.push({ name: 'login' });
    }
  },
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

.nav-wrapper {
  & a {
    &:hover {
      text-decoration: none;
      color: #000;
      transition: all 0.3s;
    }
  }

  &__brand {
    margin-left: 1rem;
    font-size: 1.5rem !important;
  }
}
</style>