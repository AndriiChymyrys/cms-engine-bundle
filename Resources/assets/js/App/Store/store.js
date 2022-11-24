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

            state.contentBlocks[blockName][contentName] = [];
        },
        ADD_CONTENT_TYPE: (state, {blockName, contentName, data}) => {
            if (!state.contentBlocks[blockName][contentName]) {
                state.contentBlocks[blockName][contentName] = [];
            }

            state.contentBlocks[blockName][contentName].push(data);
        },
        DELETE_CONTENT_TYPE: (state, {blockName, contentName, index}) => {
            if (state.contentBlocks[blockName][contentName]) {
                const i = state.contentBlocks[blockName][contentName].map(item => item.index).indexOf(index);
                state.contentBlocks[blockName][contentName].splice(i, 1);
            }
        },
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
        addContentType({commit}, {blockName, contentName, type, data}) {
            commit('ADD_CONTENT_TYPE', {blockName, contentName, type, data});
        },
        deleteContent({commit}, {blockName, contentName, type, index}) {
            commit('DELETE_CONTENT_TYPE', {blockName, contentName, type, index});
        },
    },
    getters: {
        getNextContentTypeIndex: (state) => ({blockName, contentName}) => {
            if (!state.contentBlocks[blockName][contentName]) {
                return 1;
            }

            let length = state.contentBlocks[blockName][contentName].length;

            return ++length;
        },
        getContentTypes(state) {
            return state.contentTypes;
        },
        getContentBlocks(state) {
            return state.contentBlocks;
        },
        getPage(state) {
            return state.page;
        }
    }
}

export default CmsEngine;
