<template>
  <nav>
    <div class="nav-wrapper">
      <a href="/" class="brand-logo nav-wrapper__brand">SOFT-VULN-LAB1</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li v-for="link in shownLinks" :key="link.url" :class="[link.active ? 'active' : '']">
          <a v-if="link.name == 'logout'" @click.prevent="logout">{{ link.title }}</a>
          <router-link v-else :to="link.url">{{ link.title }}</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  name: "Navbar",
  data: () => ({
    links: [
      { title: "Заметки", name: "root", url: "/" },
      { title: "Профиль", name: "profile", url: "/profile" },
      { title: "Панель администратора", name: "admin", url: "/admin" },
      { title: "Выход", name: "logout" }
    ]
  }),
  methods: {
    async logout() {
      await this.$store.dispatch("logout");
      this.$router.push({ name: "login" });
    }
  },
  computed: {
    ...mapGetters(["userInfo"]),
    shownLinks() {
      let links = this.links.filter(e =>
        this.userInfo.accessPages.includes(e.name)
      );
      links.forEach(e => {
        if (e.name == this.$route.name) e.active = true;
        else e.active = false;
      });

      return this.links.filter(e => this.userInfo.accessPages.includes(e.name));
    }
  }
};
</script>
<style lang="scss">
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