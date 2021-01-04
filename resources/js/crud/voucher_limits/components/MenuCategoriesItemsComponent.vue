<template>
    <td :class="tdClass">
        <div class="ordered-items-wrapper text-left">
            <p class="m-0">{{menuCategory.name}}</p>
        </div>
    </td>
</template>

<script>
    export default {
        name:     "MenuCategoriesItemsComponent",
        props:    {
            menuCategory: Object,
        },
        data:     () => ({}),
        computed: {
            tdClass: function () {
                return {
                    'p-2 border': true,
                };
            }
        },
    }
</script>

<style scoped>
    td {
        vertical-align: top;
    }
</style>
