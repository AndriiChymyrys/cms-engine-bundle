const CmsEngine = {
    namespaced: true,
    state: () => ({
        contentTypes: null,
    }),
    mutations: {
        SET_CONTENT_TYPES: (state, types) => state.contentTypes = types,
    },
    actions: {
        setContentTypes({commit}, types) {
            commit('SET_CONTENT_TYPES', types);
        },
    },
    getters: {
        getContentTypes(state) {
            return state.contentTypes;
        }
    }
}

export default CmsEngine;
