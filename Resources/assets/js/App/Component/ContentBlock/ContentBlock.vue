<template>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ blockTitle }}</h3>
        </div>
        <div class="card-body">
            <div class="card" v-for="content in contents.contents">
                <Content :content="content" :block-title="blockTitle" />
            </div>
        </div>
    </div>
</template>

<script>
import Content from "./Content";
import {mapActions} from 'vuex'

export default {
    name: "ContentBlock",
    props: ['blockTitle', 'contents', 'contentTypes', 'page'],
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
