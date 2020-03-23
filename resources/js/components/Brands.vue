<template>
    <div>
        <div class="card mb-3" v-for="brand in brands.data" :key="brand.id">
            <div class="card-header">
                {{ brand.name }}
                <div class="float-right">
                    <font-awesome-icon icon="pencil-alt" class="ml-3"/>
                    <font-awesome-icon icon="trash-alt" class="ml-3"/>
                </div>
            </div>

            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="badge badge-info mr-2" v-for="name_mapping in brand.name_mappings">
                        {{ name_mapping.name }}

                    </li>
                    <li>
                        <div class="form-group">
                            <label for="nameMapping">Add new name mapping:</label>
                            <input type="text" class="form-control" name="nameMapping" id="nameMapping"
                                   placeholder="New Name Mapping">
                        </div>
                    </li>
                </ul>
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
