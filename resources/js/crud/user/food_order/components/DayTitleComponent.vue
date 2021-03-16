<template>
    <th class="">
        <div class="day-title-wrapper">
            <span class="day-title">{{ title }}</span>
        </div>
    </th>
</template>

<script>
export default {
    name:    "DayTitleComponent",
    props:   {
        title: String,
    },
    methods: {}
}
</script>


<style scoped>
th {
    width: 16.66%;
}

th:not(.active) .day-title-wrapper {
    border: 1px solid #dee2e6;
}
</style>
