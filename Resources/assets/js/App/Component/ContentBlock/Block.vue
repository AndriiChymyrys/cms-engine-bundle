<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Content Blocks</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <content-block v-for="(contents, blockName) in contentBlocks"
                           :block-title="blockName"
                           :content-types="contentTypes"
                           :page="page"
                           :contents="contents"/>
        </div>
    </div>
</template>

<script>
import ContentBlock from "./ContentBlock";

export default {
    name: "Block",
    props: ['page', 'contentTypes', 'contentBlocks'],
    components: [
        ContentBlock
    ]
}
</script>
