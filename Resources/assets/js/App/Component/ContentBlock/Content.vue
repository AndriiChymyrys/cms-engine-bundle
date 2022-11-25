<template>
    <div class="card-header">
        <h3 class="card-title">{{ contentName }}</h3>
    </div>
    <div class="card-body">
        <component
            :is="'contentType'"
            v-for="data in getContents({blockName: blockName, contentName: contentName})"
            :key="'contentType'"
            :block-name="blockName"
            :content-name="contentName"
            :content-data="data"
            :content-id="data.id"
        />
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success" @click="addFreshContentType">Add</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import ContentType from "./ContentType";

export default {
    name: "Content",
    props: ['contentName', 'contentData', 'blockName'],
    components: {
        ContentType,
    },
    mounted() {
        this.addContent({
            blockName: this.blockName,
            contentName: this.contentName,
            contentData: this.contentData,
            init: true,
        });
    },
    methods: {
        generateContentId() {
            return '{type}_{key}_{unique}'
                .replace('{type}', this.blockName)
                .replace('{key}', this.contentName)
                .replace('{unique}', Math.random().toString(36).substr(2, 5));
        },
        addFreshContentType() {
            this.addContent({
                blockName: this.blockName,
                contentName: this.contentName,
                contentData: {
                    contentHtmlId: this.generateContentId(),
                    id: this.getNextContentTypeIndex({blockName: this.blockName, contentName: this.contentName}),
                    saved: false,
                },
                init: false,
            });
        },
        ...mapActions('cmsEngine', ['addContent'])
    },
    computed: {
        ...mapGetters('cmsEngine', ['getNextContentTypeIndex', 'getContents']),
    }
}
</script>
