<template>
  <section id="section-login">
    <div class="container">
      <div class="login">
        <div class="login__form">
          <h1 class="login__title">Форма входа</h1>
          <div class="input-field">
            <input id="name" type="text" class="validate" />
            <label for="name">Введите логин</label>
          </div>
          <div class="input-field">
            <input id="password" type="text" class="validate" />
            <label for="password">Введите пароль</label>
          </div>
          <button class="login__send btn waves-effect waves-light" type="submit" name="action">
            Войти
            <i class="material-icons right">send</i>
          </button>
        </div>
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
