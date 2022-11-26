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
        ADD_CONTENT: (state, {blockName, contentName, contentData, init}) => {
            if (!state.contentBlocks[blockName]) {
                state.contentBlocks[blockName] = {};
            }

            if (!state.contentBlocks[blockName][contentName]) {
                state.contentBlocks[blockName][contentName] = [];
            }

            if (init) {
                contentData.forEach((data) => {
                    // at this point we add only saved types field/widget
                    data.saved = true;
                    data.contentHtmlId = 'saved_{type}_{key}_{id}'.replace('{type}', data.contentType)
                        .replace('{key}', data.contentKey)
                        .replace('{id}', data.id);
                    state.contentBlocks[blockName][contentName].push(data);
                })
            } else {
                // add fresh content types
                state.contentBlocks[blockName][contentName].push(contentData);
            }
        },
        ADD_CONTENT_TYPE: (state, {blockName, contentName, data}) => {
            if (!state.contentBlocks[blockName][contentName]) {
                state.contentBlocks[blockName][contentName] = [];
            }

            state.contentBlocks[blockName][contentName].push(data);
        },
        UPDATE_CONTENT_TYPE_BY_ID: (state, {blockName, contentName, id, data}) => {
            let i = state.contentBlocks[blockName][contentName].findIndex(o => o.id === id);
            state.contentBlocks[blockName][contentName][i] = {...state.contentBlocks[blockName][contentName][i], ...data};
        },
        DELETE_CONTENT_TYPE: (state, {blockName, contentName, id}) => {
            if (state.contentBlocks[blockName][contentName]) {
                const i = state.contentBlocks[blockName][contentName].findIndex(item => item.id === id);
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
        addContent({commit}, {blockName, contentName, contentData, init}) {
            commit('ADD_CONTENT', {blockName, contentName, contentData, init});
        },
        addContentType({commit}, {blockName, contentName, data}) {
            commit('ADD_CONTENT_TYPE', {blockName, contentName, data});
        },
        deleteContent({commit}, {blockName, contentName, id}) {
            commit('DELETE_CONTENT_TYPE', {blockName, contentName, id});
        },
        updateContentTypeById({commit}, {blockName, contentName, id, data}) {
            commit('UPDATE_CONTENT_TYPE_BY_ID', {blockName, contentName, id, data});
        }
    },
    getters: {
        getNextContentTypeIndex: (state) => ({blockName, contentName}) => {
            if (!state.contentBlocks[blockName][contentName].length) {
                return 1;
            }

            let max = Math.max(...state.contentBlocks[blockName][contentName].map(o => o.id))

            return ++max;
        },
        getContents: (state) => ({blockName, contentName}) => {
            if (state.contentBlocks[blockName]) {
                return state.contentBlocks[blockName][contentName];
            }

            return [];
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
