<template>
  <section id="section-main">
    <!-- <div class="notes">
      <div class="note">
        <div class="note__header">
          <input class="note__name" type="text" placeholder="Имя заметки" />
          <i class="material-icons note__icon note__save">save</i>
          <i class="material-icons note__icon note__delete">delete_forever</i>
        </div>
        <textarea class="note__description" placeholder="Введите описание"></textarea>
      </div>
    </div>-->
    <div class="notes">
      <div class="note" v-for="note of notes" :key="note.id">
        <div class="note__header">
          <input class="note__name" type="text" placeholder="Имя заметки" :value="note.name" />
          <i class="material-icons note__icon note__save">save</i>
          <i class="material-icons note__icon note__delete">delete_forever</i>
        </div>
        <textarea class="note__description" placeholder="Введите описание" :value="note.description"></textarea>
      </div>
    </div>
    <button class="waves-effect waves-light btn" @click="addNote">Добавить заметку</button>
  </section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Root",
  async mounted() {
    await this.$store.dispatch("getNotes");
  },
  computed: {
    ...mapGetters(["notes"])
  },
  methods: {
    addNote() {
      this.$store.dispatch("addNote");
    }
  }
};
</script>
<style lang="scss">
#section-main {
  margin: 1rem;
}

.notes {
  margin: 0 0 1rem 0;
}

.note {
  position: relative;
  border: 1px dashed $primary;
  padding: 0.3rem 0.3rem 0 0.5rem;
  border-radius: 3px;
  margin: 1rem 0 0 0;

  &__name {
    margin-right: 1rem;
    color: rgb(23, 71, 126);
    font-size: 1.3rem !important;

    &::placeholder {
      color: $placeholder-color;
    }
  }

  &__header {
    display: flex;
    align-items: center;
  }

  &__description {
    width: 100%;
    height: 5rem;
    border: 0;
    outline: none;

    &::placeholder {
      color: $placeholder-color;
    }
  }

  &__icon {
    cursor: pointer;
    color: rgb(28, 107, 209);
    font-size: 35px !important;

    &:hover {
      color: rgb(26, 91, 177);
    }
  }
}
</style>