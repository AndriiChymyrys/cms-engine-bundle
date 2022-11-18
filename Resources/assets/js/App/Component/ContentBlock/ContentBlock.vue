<template>
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ blockTitle }}</h3>
        </div>
        <div class="card-body">
            <div class="card" v-for="content in contents.contents">
                <Content :content="content" />
            </div>
        </div>
    </div>
</template>

<script>
import Content from "./Content";
import {mapActions} from 'vuex'

export default {
    name: "ContentBlock",
    props: ['blockTitle', 'contents', 'contentTypes'],
    components: {
        Content
    },
    mounted() {
        this.setContentTypes(this.contentTypes);
    },
    methods: {
        ...mapActions('cmsEngine', ['setContentTypes'])
    }
}
</script>
