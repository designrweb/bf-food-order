<template>
    <div>
        <b-overlay
            :show="isLoading"
            rounded
            opacity="0.6"
            spinner-small
            :class="'d-inline-block ' + classes">
            <a :class="[isProfileCompleted ? 'btn btn-success ' : 'btn btn-outline-secondary disabled ']"
               :href="mainRoute">
                {{ label }}
            </a>
        </b-overlay>
    </div>
</template>
<script>
import {get} from "../../api/profile";

export default {
    name:  "CreateConsumerButton",
    props: {
        mainRoute: String,
        label:     String,
        classes:   String,
    },
    data() {
        return {
            isProfileCompleted: false,
            isLoading:          false,
        }
    },
    methods: {
        async _isProfileCompleted() {
            this.isLoading = true;

            let data                = await get('/user/profile/completed-profile');
            this.isProfileCompleted = data.data;

            this.isLoading = false;
        },
    },
    async mounted() {
        await this._isProfileCompleted();
    },
}
</script>

<style scoped>
a {
    justify-content: center;
    align-items: center;
}
</style>
