<template>
    <td :class="tdClass" @click="setAutoOrderStatus">
        <div class="ordered-items-wrapper text-left">
            <p class="m-0">{{menuCategory.name}}</p>
            <p>{{menuCategory.presaleprice}} &euro;</p>
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
                    // 'auto-ordered': this.menuCategory.is_ordered
                };
            }
        },
        methods:  {
            setAutoOrderStatus: function () {
                return;
                // let updatedCategory        = {...this.menuCategory};
                // updatedCategory.is_ordered = !this.menuCategory.is_ordered;
                // this.$emit('updateAutoOrderStatus', updatedCategory);
            },
        },
    }
</script>

<style scoped>
    td {
        vertical-align: top;
        /*cursor: pointer;*/
    }

    /*td:hover {*/
    /*    background: rgba(119, 211, 174, 0.28);*/
    /*}*/
</style>
