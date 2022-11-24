<template>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ blockName }}</h3>
        </div>
        <div class="card-body">
            <div class="card" v-for="(contentData, contentName) in contents.contents">
                <Content :content-name="contentName" :content-data="contentData" :block-name="blockName" />
            </div>
        </div>
    </div>
</template>

<script>
import Content from "./Content";
import {mapActions} from 'vuex'

export default {
    name: "ContentBlock",
    props: ['blockName', 'contents', 'contentTypes', 'page'],
    components: {
        Content
    },
    mounted() {
        this.setContentTypes(this.contentTypes);
        this.setPage(this.page);
    },
    methods: {
        ...mapActions('cmsEngine', ['setContentTypes', 'setPage'])
    }
}
</script>
