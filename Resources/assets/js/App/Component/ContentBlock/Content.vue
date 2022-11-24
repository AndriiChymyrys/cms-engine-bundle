<template>
    <div class="card-header">
        <h3 class="card-title">{{ contentName }}</h3>
    </div>
    <div class="card-body">
        <component
            :is="type.component"
            v-for="type in contentTypes"
            :key="type.component"
            :block-name="blockName"
            :content-name="contentName"
            :content-index="type.contentIndex"
            :content-data="type.data"
            :saved="type.saved"
            :content-html-id="generateContentId()"
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
    props: ['contentName', 'contentData', 'blockName'],
    components: {
        ContentType,
    },
    data: function () {
        return {
            contentTypes: [],
        }
    },
    mounted() {
        this.addContent({
            blockName: this.blockName,
            contentName: this.contentName,
            contentData: this.contentData
        });

        this.contentData.forEach((data) => {
            // Add saved content types
            this.contentTypes.push({
                component: 'contentType',
                contentIndex: data.id,
                saved: true,
                data: {
                    selectedType: data.contentType,
                    contentKey: data.contentKey,
                    editView: data.editView,
                },
            });
        })
    },
    methods: {
        generateContentId() {
            let templateRow = '{type}_{key}_{unique}';
            templateRow = templateRow.replace('{type}', this.blockName);
            templateRow = templateRow.replace('{key}', this.contentName);
            templateRow = templateRow.replace('{unique}', Math.random().toString(36).substr(2, 5));

            return templateRow;
        },
        addType() {
            this.contentTypes.push({
                component: 'contentType',
                contentIndex: this.getNextContentTypeIndex({blockName: this.blockName, contentName: this.contentName}),
                savedId: null,
                saved: false,
                data: {},
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
