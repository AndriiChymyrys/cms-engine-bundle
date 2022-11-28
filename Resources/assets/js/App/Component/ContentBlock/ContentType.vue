<template>
    <div class="row">
        <div class="col-md-12">
            <div class="row" v-if="!contentData.saved">
                <div class="col-md-2 mb-4">
                    <select class="form-control" v-model="selectedType" @change="getAvailableTypes">
                        <option v-for="content in getContentTypes" :value="content">{{ content }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" v-model="contentKey" v-if="availableTypes" @change="getTypeContent">
                        <optgroup :label="theme" v-for="(types, theme) in availableTypes">
                            <option v-for="(name, type) in types" :value="type">{{ name }}</option>
                        </optgroup>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" v-if="action.canDelete" class="btn btn-danger" @click="removeType">
                        Del
                    </button>
                </div>
            </div>
            <div class="row" v-if="contentData.saved">
                <div class="col-md-2 mb-4">
                    {{ selectedType }}
                </div>
                <div class="col-md-2 mb-4">
                    {{ typeTheme }}
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
            <div class="row" v-html="contentView" :id="this.contentData.contentHtmlId"></div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import axios from "axios";

export default {
    name: "ContentType",
    props: ['blockName', 'contentName', 'contentData', 'contentId'],
    data: function () {
        return {
            selectedType: this.contentData.saved ? this.contentData.contentType : null,
            typeTheme: this.contentData.saved ? this.contentData.typeTheme : null,
            contentKey: this.contentData.saved ? this.contentData.contentKey : null,
            availableTypes: null,
            contentView: this.contentData.saved ? this.contentData.editView : null,
            action: {
                canDelete: this.contentData.saved,
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
            this.findTypeTheme();

            let url = '/cms/api/content/edit-view/{contentType}/{theme}/{contentKey}'
                .replace('{contentType}', this.selectedType)
                .replace('{theme}', this.typeTheme)
                .replace('{contentKey}', this.contentKey)

            axios.get(url)
                .then(response => {
                    if (response.data.view) {
                        this.contentView = response.data.view;
                        this.action.canDelete = true;

                        this.updateContentTypeById({
                            blockName: this.blockName,
                            contentName: this.contentName,
                            id: this.contentId,
                            data: {
                                contentType: this.selectedType,
                                typeTheme: this.typeTheme,
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
                id: this.contentId,
            });
        },
        findTypeTheme() {
            for (let theme in this.availableTypes) {
                for (let type in this.availableTypes[theme]) {
                    if (type === this.contentKey) {
                        this.typeTheme = theme;

                        break;
                    }
                }
            }
        },
        ...mapActions('cmsEngine', ['updateContentTypeById', 'deleteContent'])
    },
    computed: {
        ...mapGetters('cmsEngine', ['getContentTypes', 'getPage']),
    }
}
</script>
