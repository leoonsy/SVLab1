<template>
  <section id="section-register">
    <div class="container">
      <div class="register">
        <form class="register__form" @submit.prevent="register">
          <h1 class="register__title">Форма регистрации</h1>
          <div class="input-field">
            <input id="username" type="text" class="validate" v-model="username" />
            <label for="username">Введите логин</label>
          </div>
          <div class="input-field">
            <input id="password" type="password" class="validate" v-model="password" />
            <label for="password">Введите пароль</label>
          </div>
          <button class="register__send btn waves-effect waves-light" type="submit" name="action">
            Зарегистрироваться
            <i class="material-icons right">send</i>
          </button>
        </form>
        <div class="register__otherwise">
          <span>У вас уже есть учетная запись?</span>
          <router-link to="/login">Войти</router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import EmptyLayout from "@/layouts/EmptyLayout";
export default {
  name: "register",
  mounted() {
    setTimeout(() => {
      M.updateTextFields();
    });
  },
  data: () => ({
    username: "",
    password: ""
  }),
  methods: {
    async register() {
      const formData = {
        username: this.username,
        password: this.password
      };

      try {
        await this.$store.dispatch("register", formData);
        M.toast({ html: "Успешная регистрация!" });
        this.username = null;
        this.password = null;
        setTimeout(() => {
          M.updateTextFields();
        });
      } catch (e) {
        M.toast({ html: e.message });
      }
    }
  }
};
</script>

<style lang="scss">
#section-register {
  height: 100vh;
  display: flex;
  align-items: center;
}

.register {
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
