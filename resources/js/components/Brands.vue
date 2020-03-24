<template>
    <div>
        <div class="card mb-3" v-for="brand in brands.data" :key="brand.id">
            <div class="card-header">
                {{ brand.name }}
                <div class="float-right">
                    <a href="#" class="btn btn-sm btn-light ml-3" title="Edit">
                        <font-awesome-icon icon="pencil-alt" class=""/>
                    </a>
                    <a href="#" class="btn btn-sm btn-light ml-3" title="Mark as duplication" data-toggle="modal"
                       data-target="#brandDuplicationModal">
                        <font-awesome-icon icon="exchange-alt" class=""/>
                    </a>
                    <a href="#" class="btn btn-sm btn-light ml-3" title="Move to blacklist">
                        <font-awesome-icon icon="times-circle" class=""/>
                    </a>
                    <a href="#" class="btn btn-sm btn-light ml-3" title="Remove">
                        <font-awesome-icon icon="trash-alt" class=""/>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <brand-name-mappings :name_mappings="brand.name_mappings"></brand-name-mappings>
            </div>
        </div>
        <duplicated-brands-modal :brands="brands"></duplicated-brands-modal>
    </div>
</template>

<script>
    import BrandNameMappings from "./BrandNameMappings";
    import DuplicatedBrandsModal from "./DuplicatedBrandsModal";

    export default {
        components: {BrandNameMappings, DuplicatedBrandsModal},
        props: ['brands'],
        data() {
            return {}
        },
        mounted() {
        }
    }
</script>
