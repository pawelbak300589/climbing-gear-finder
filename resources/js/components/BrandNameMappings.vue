<template>
    <ul class="list-unstyled">
        <li class="badge badge-info mr-2" v-for="name_mapping in name_mappings">
            {{ name_mapping.name }}
            <font-awesome-icon icon="times" class="ml-2"/>
        </li>
        <li>
            <div class="form-group">
                <label for="nameMapping">Add new name mapping:</label>
                <input type="text" class="form-control form-control-sm" name="nameMapping" id="nameMapping"
                       placeholder="New Name Mapping">
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['name_mappings'],
        data() {
            return {}
        },
        mounted() {
        }
    }
</script>
