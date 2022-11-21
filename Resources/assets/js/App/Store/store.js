const CmsEngine = {
    namespaced: true,
    state: () => ({
        contentTypes: null,
        page: null,
        contentBlocks: {},
    }),
    mutations: {
        SET_CONTENT_TYPES: (state, types) => state.contentTypes = types,
        SET_PAGE: (state, page) => state.page = page,
        ADD_CONTENT: (state, {blockName, contentName}) => {
            if (!state.contentBlocks[blockName]) {
                state.contentBlocks[blockName] = {};
            }

            state.contentBlocks[blockName][contentName] = {};
        },
        ADD_CONTENT_TYPE: (state, {blockName, contentName, type, data}) => {
            state.contentBlocks[blockName][contentName][type] = data;
        }
    },
    actions: {
        setContentTypes({commit}, types) {
            commit('SET_CONTENT_TYPES', types);
        },
        setPage({commit}, page) {
            commit('SET_PAGE', page);
        },
        addContent({commit}, {blockName, contentName}) {
            commit('ADD_CONTENT', {blockName, contentName});
        },
        updateContent({commit}, {blockName, contentName, type, data}) {
            commit('ADD_CONTENT_TYPE', {blockName, contentName, type, data});
        }
    },
    getters: {
        getContentTypes(state) {
            return state.contentTypes;
        },
        getPage(state) {
            return state.page;
        }
    }
}

export default CmsEngine;
