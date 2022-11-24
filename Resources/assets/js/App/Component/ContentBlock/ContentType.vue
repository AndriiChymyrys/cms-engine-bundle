<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row" v-if="!saved">
                <div class="col-md-2 mb-4">
                    <select class="form-control" v-model="selectedType" @change="getAvailableTypes">
                        <option v-for="content in getContentTypes" :value="content">{{ content }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" v-model="contentKey" v-if="availableTypes" @change="getTypeContent">
                        <optgroup :label="key" v-for="(types, key) in availableTypes">
                            <option v-for="(type, key) in types" :value="key">{{ type }}</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" v-if="action.canDelete" class="btn btn-danger" @click="removeType">
                        Del
                    </button>
                </div>
            </div>
            <div class="row" v-if="saved">
                <div class="col-md-2 mb-4">
                    {{ selectedType }}
                </div>
                <div class="col-md-2">
                    {{ contentKey }}
                </div>
                <div class="col-md-2">
                    <button type="button" v-if="action.canDelete" class="btn btn-danger" @click="removeType">
                        Del
                    </button>
                </div>
            </div>
            <div class="row" v-html="contentView" :id="contentHtmlId"></div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import axios from "axios";

export default {
    name: "ContentType",
    props: ['blockName', 'contentName', 'contentIndex', 'saved', 'contentData', 'contentHtmlId'],
    data: function () {
        return {
            selectedType: this.saved ? this.contentData.selectedType : null,
            contentKey: this.saved ? this.contentData.contentKey : null,
            availableTypes: null,
            contentView: this.saved ? this.contentData.editView : null,
            action: {
                canDelete: this.saved,
            }
        }
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
            url = url.replace('{contentBlock}', this.blockName)
            url = url.replace('{content}', this.contentName)
            url = url.replace('{contentType}', this.selectedType)
            url = url.replace('{contentKey}', this.contentKey)

            axios.get(url)
                .then(response => {
                    if (response.data.view) {
                        this.contentView = response.data.view;
                        this.action.canDelete = true;

                        this.addContentType({
                            blockName: this.blockName,
                            contentName: this.contentName,
                            data: {
                                contentHtmlId: this.contentHtmlId,
                                id: this.contentIndex,
                                contentType: this.selectedType,
                                contentKey: this.contentKey,
                            },
                        });
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        },
        removeType() {
            this.deleteContent({
                blockName: this.blockName,
                contentName: this.contentName,
                id: this.contentIndex,
            });

            this.$emit('contentTypeDeleted', this.contentIndex);
        },
        ...mapActions('cmsEngine', ['addContentType', 'deleteContent'])
    },
    computed: {
        ...mapGetters('cmsEngine', ['getContentTypes', 'getPage']),
    }
}
</script>
