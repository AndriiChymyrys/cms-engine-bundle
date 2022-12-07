<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item" v-for="(templateConf, templateName) in contentTemplates">
                            <b>{{ templateName }}</b> <a class="float-right btn btn-primary" @click="openContentTemplate(templateName)">Open</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <content-template-fields></content-template-fields>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import ContentTemplateFields from "./ContentTemplateFields.vue";

export default {
    name: "ContentTemplate",
    props: ['contentTemplates', 'page'],
    components: {
        ContentTemplateFields
    },
    methods: {
        openContentTemplate(templateName) {
            let url = '/cms/api/content-template/{templateName}/fields/{pageId}'
                .replace('{templateName}', templateName)
                .replace('{pageId}', this.page.id)

            axios.get(url);
        }
    }
}
</script>
