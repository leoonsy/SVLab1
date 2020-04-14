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
        },
        clearNote(state, id) {
            state.notes = state.notes.filter(e => e.id != id);
        },
        updateNote(state, {id, name, description}) {
            let note = state.notes.find(e => e.id == id);
            note.name = name;
            note.description = description;
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
            commit('clearNote', id)
        },

        async updateNote({ commit }, { id, name, description }) {
            await NotesModule.updateNote(id, name, description);
            commit('updateNote', { id, name, description });
        }
    },
    getters: {
        notes: s => s.notes
    }
}