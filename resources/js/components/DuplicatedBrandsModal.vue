<template>
    <!-- Duplication Modal -->
    <div class="modal fade" id="brandDuplicationModal" tabindex="-1" role="dialog"
         aria-labelledby="brandDuplicationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Move duplicated brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="duplicatedBrand">Duplicated Brand:</label>
                                <select class="form-control form-control-sm" name="duplicatedBrand"
                                        id="duplicatedBrand">
                                    <option value="">Choose duplicated brand</option>
                                    <option v-for="brand in brands.data" :value="brand.id" v-text="brand.name"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="moveUnderBrand">Move Under Brand:</label>
                                <select class="form-control form-control-sm" name="moveUnderBrand"
                                        id="moveUnderBrand">
                                    <option value="">Choose move to brand</option>
                                    <option v-for="brand in brands.data" :value="brand.id" v-text="brand.name"></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Move Brand</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['brands'],
        data() {
            return {}
        },
        mounted() {
        }
    }
</script>
