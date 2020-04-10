<template>
  <section id="section-login">
    <div class="container">
      <div class="login">
        <form class="login__form" @submit.prevent="login">
          <h1 class="login__title">Форма входа</h1>
          <div class="input-field">
            <input id="name" type="text" class="validate" v-model="name" />
            <label for="name">Введите логин</label>
          </div>
          <div class="input-field">
            <input id="password" type="password" class="validate" v-model="password" />
            <label for="password">Введите пароль</label>
          </div>
          <button class="login__send btn waves-effect waves-light" type="submit" name="action">
            Войти
            <i class="material-icons right">send</i>
          </button>
        </form>
        <div class="login__otherwise">
          <span>У вас нет учетной записи?</span>
          <router-link to="/register">Регистрация</router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import EmptyLayout from "@/layouts/EmptyLayout";
export default {
  name: "Login",
  created() {
    this.$emit("update:layout", EmptyLayout);
    setTimeout(() => {
      M.updateTextFields();
    });
  },
  data: () => ({
    name: "",
    password: ""
  }),
  methods: {
    async login() {
      const formData = {
        name: this.name,
        password: this.password
      };

      try {
        await this.$store.dispatch('login', formData);
        this.$router.push('/');
      } catch (e) {
        M.toast({html: e.message});
      }
    }
  }
};
</script>

<style lang="scss">
#section-login {
  height: 100vh;
  display: flex;
  align-items: center;
}

.login {
  padding: 15px;
  &__title {
    text-align: center;
    font-size: 2rem;
  }

  &__send {
    margin: 0 auto;
    display: block;
  }

  &__otherwise {
    font-size: 1.2rem;
    text-align: center;
    margin-top: 2rem;
    & span {
      margin-right: 1rem;
    }
  }
}
</style>
