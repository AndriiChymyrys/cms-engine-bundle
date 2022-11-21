<template>
    <div class="card-header">
        <h3 class="card-title">{{ content }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-2">
                <select class="form-control" v-model="selectedType" @change="getAvailableTypes">
                    <option v-for="content in getContentTypes" :value="content">{{content}}</option>
                </select>
            </div>
            <div class="col-2">
                <select class="form-control" v-model="contentKey" v-if="availableTypes" @change="getTypeContent">
                    <optgroup :label="key" v-for="(types, key) in availableTypes">
                        <option v-for="(type, key) in types" :value="key">{{type}}</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="row" v-html="contentView"></div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import axios from "axios";

export default {
    name: "Content",
    props: ['content', 'blockTitle'],
    data: function () {
        return {
            selectedType: null,
            contentKey: null,
            availableTypes: null,
            contentView: null,
        }
    },
    mounted() {
        this.addContent({blockName: this.blockTitle, contentName: this.content});
    },
    methods: {
        getAvailableTypes() {
            let url = '/cms/api/content/available-type/' + this.selectedType;
            this.availableTypes = this.contentKey = null;
            axios.get(url)
                .then(response => {
                    if (response.data.available) {
                        this.availableTypes = response.data.available;
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        getTypeContent() {
            let url = '/cms/api/content/edit-view/{pageId}/{contentBlock}/{content}/{contentType}/{contentKey}';
            url = url.replace('{pageId}', this.getPage.id)
            url = url.replace('{contentBlock}', this.blockTitle)
            url = url.replace('{content}', this.content)
            url = url.replace('{contentType}', this.selectedType)
            url = url.replace('{contentKey}', this.contentKey)

            axios.get(url)
                .then(response => {
                    if (response.data.view) {
                        this.contentView = response.data.view;
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        ...mapActions('cmsEngine', ['addContent'])
    },
    computed: {
        ...mapGetters('cmsEngine', ['getContentTypes', 'getPage']),
    }
}
</script>
