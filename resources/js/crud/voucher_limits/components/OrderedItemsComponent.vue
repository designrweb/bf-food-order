<template>
    <td :class="tdClass">
        <div class="ordered-items-wrapper text-left">
            <div class="d-block align-items-center">
                <div class="flex-3">
                    <b-input-group>
                        <template #append>
                            <b-input-group-text>%</b-input-group-text>
                        </template>
                        <b-form-input :id="`menu-id-${menuId}-day-${day}`" type="number" min="0" @change="updateItem" :value="dayValue"></b-form-input>
                    </b-input-group>
                </div>
            </div>
        </div>
    </td>
</template>

<script>

export default {
    name:     "OrderedItemsComponent",
    props:    {
        dayValue: Number,
        menuId:   Number,
        day:      Number
    },
    data:     () => ({}),
    computed: {
        tdClass: function () {
            return {
                'p-2 border': true,
            };
        }
    },
    methods:  {
        updateItem: function (item) {
            this.$emit('updateOrderItem', item);
        },
    },
    watch:    {}
}
</script>

<style scoped>
td {
    vertical-align: top;
    position: relative;
}
</style>
