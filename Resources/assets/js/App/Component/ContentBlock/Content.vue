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
                <select class="form-control" v-model="type" v-if="availableTypes" @change="getTypeContent">
                    <optgroup :label="key" v-for="(types, key) in availableTypes">
                        <option v-for="type in types" :value="type">{{type}}</option>
                    </optgroup>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import axios from "axios";

export default {
    name: "Content",
    props: ['content'],
    data: function () {
        return {
            selectedType: null,
            type: null,
            availableTypes: null,
        }
    },
    methods: {
        getAvailableTypes() {
            let url = '/cms/api/content/available-type/' + this.selectedType;
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

        }
    },
    computed: {
        ...mapGetters('cmsEngine', ['getContentTypes']),
    }
}
</script>
