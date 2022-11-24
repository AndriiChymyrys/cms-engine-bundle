<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Content Blocks</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <content-block v-for="(contents, blockName) in contentBlocks"
                           :block-name="blockName"
                           :content-types="contentTypes"
                           :page="page"
                           :contents="contents"
            />
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-success float-right" @click="submit">Save</button>
        </div>
    </div>
</template>

<script>
import ContentBlock from "./ContentBlock";
import {mapGetters} from 'vuex'
import axios from "axios";

export default {
    name: "Block",
    props: ['page', 'contentTypes', 'contentBlocks'],
    components: [
        ContentBlock
    ],
    methods: {
        submit() {
            const blocks = this.prepareBlocks();

            if (blocks) {
                const url = '/cms/api/content/save/{pageId}'.replace('{pageId}', this.page.id);
                axios.post(url, {blocks: blocks});
            }
        },
        prepareBlocks() {
            let submitBlocks = {};

            for (let blockName in this.getContentBlocks()) {
                submitBlocks[blockName] = {};

                for (let contentName in this.getContentBlocks()[blockName]) {
                    submitBlocks[blockName][contentName] = [];

                    for (let i = 0; i < this.getContentBlocks()[blockName][contentName].length; i++) {
                        let contentType = this.getContentBlocks()[blockName][contentName][i];

                        if (contentType.selectedType === 'field') {
                            contentType.value = window.WMCMSLib.FieldHandler.executeSaveHandler(
                                contentType.contentKey, document.getElementById(contentType.contentHtmlId)
                            )
                        }

                        submitBlocks[blockName][contentName].push(contentType);
                    }
                }
            }

            return submitBlocks;
        },
        ...mapGetters('cmsEngine', ['getContentBlocks'])
    },
}
</script>
