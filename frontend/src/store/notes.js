import NotesModule from '../libs/NotesModule';

export default {
    state: {
        notes: []
    },
    mutations: {
        setNotes(state, notes) {
            state.notes = notes;
        },
        clearNotes(state) {
            state.notes = [];
        }
    },
    actions: {
        async getNotes({ commit }) {
            let notes = await NotesModule.getNotes();
            commit('setNotes', notes);
        },

        async addNote({ commit, getters }, id) {
            let note = await NotesModule.addNote(id);
            let a = getters.notes;
            debugger;
            debugger;
            let b = 
            commit('setNotes', [...getters.notes, note]);
        },

        async deleteNote({ commit }, id) {
            await NotesModule.deleteNote(id);
        },

        async updateNote({ commit }, { id, name, description }) {
            await NotesModule.updateNote(id, name, description);
        }
    },
    getters: {
        notes: s => s.notes
    }
}