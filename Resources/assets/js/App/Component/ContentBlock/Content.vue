<template>
    <div class="card-header">
        <h3 class="card-title">{{ content }}</h3>
    </div>
    <div class="card-body">
        <component
            :is="type.component"
            v-for="type in contentTypes"
            :key="type.component"
            :block-name="blockName"
            :content-name="content"
            :content-index="type.contentIndex"
            @content-type-deleted="deleteType"
        />
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-success" @click="addType">Add</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import ContentType from "./ContentType";

export default {
    name: "Content",
    props: ['content', 'blockName'],
    components: {
        ContentType,
    },
    data: function () {
        return {
            contentTypes: [],
        }
    },
    mounted() {
        this.addContent({blockName: this.blockName, contentName: this.content});
    },
    methods: {
        addType() {
            this.contentTypes.push({
                component: 'contentType',
                contentIndex: this.getNextContentTypeIndex({blockName: this.blockName, contentName: this.content}),
            });
        },
        deleteType(index) {
            const i = this.contentTypes.map(item => item.contentIndex).indexOf(index);
            this.contentTypes.splice(i, 1);
        },
        ...mapActions('cmsEngine', ['addContent'])
    },
    computed: {
        ...mapGetters('cmsEngine', ['getNextContentTypeIndex']),
    }
}
</script>
