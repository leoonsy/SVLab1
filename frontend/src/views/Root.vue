<template>
  <section id="section-main" :class="[loading ? 'loading' : '']">
    <div class="notes">
      <div class="note" v-for="note of notes" :key="note.id">
        <div class="note__header">
          <input class="note__name" type="text" placeholder="Имя заметки" v-model="note.name" :disabled="loading" />
          <i class="material-icons note__icon note__save" @click="updateNote(note)">save</i>
          <i
            class="material-icons note__icon note__delete"
            @click="deleteNote(note.id)"
          >delete_forever</i>
        </div>
        <textarea
          class="note__description"
          placeholder="Введите описание"
          v-model="note.description"
          :disabled="loading"
        ></textarea>
      </div>
    </div>
    <button class="waves-effect waves-light btn" @click="addNote" :disabled="loading">Добавить заметку</button>
  </section>
</template>

<script>
import MainLayout from "@/layouts/MainLayout";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Root",
  async mounted() {
    try {
      this.$store.commit("setLoading", true);
      await this.$store.dispatch("getNotes");
      this.$store.commit("setLoading", false);
    } catch (e) {
      M.toast({ html: e.message });
    }
  },
  computed: {
    ...mapGetters(["notes", "loading"])
  },
  methods: {
    async addNote() {
      try {
        this.$store.commit("setLoading", true);
        await this.$store.dispatch("addNote");
        this.$store.commit("setLoading", false);
        M.toast({ html: "Заметка успешно добавлена" });
      } catch (e) {
        M.toast({ html: e.message });
      }
    },
    async deleteNote(noteId) {
      try {
        this.$store.commit("setLoading", true);
        await this.$store.dispatch("deleteNote", noteId);
        this.$store.commit("setLoading", false);
        M.toast({ html: "Заметка успешно удалена" });
      } catch (e) {
        M.toast({ html: e.message });
      }
    },
    async updateNote(note) {
      try {
        this.$store.commit("setLoading", true);
        await this.$store.dispatch("updateNote", note);
        this.$store.commit("setLoading", false);
        M.toast({ html: "Заметка успешно сохранена" });
      } catch (e) {
        M.toast({ html: e.message });
      }
    }
  }
};
</script>
<style lang="scss">
#section-main {
  margin: 1rem;

  &.loading {
    opacity: .5;
  }
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