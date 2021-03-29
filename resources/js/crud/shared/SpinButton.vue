<template>
    <b-input-group>
        <b-input-group-prepend>
            <b-button variant="outline-dark" class="py-0" size="sm" @click="decrement">
                <b-icon icon="dash" font-scale="1.6"/>
            </b-button>
        </b-input-group-prepend>

        <b-form-input
            :size="size"
            type="number"
            v-model="value"
            :value="value"
            min="0"
            :max="max"
            :step="1"
            class="border-secondary text-center"
            number
            @input="valueChange"
        />

        <b-input-group-append>
            <b-button variant="outline-dark" class="py-0" size="sm" @click="increment">
                <b-icon icon="plus" font-scale="1.6"/>
            </b-button>
        </b-input-group-append>
    </b-input-group>
</template>

<script>
import {BIcon, BIconDash, BIconPlus} from 'bootstrap-vue'

export default {
    name: 'TheFormSpinbuttonWithInput',

    components: {
        BIcon,

        /* eslint-disable vue/no-unused-components */
        BIconDash,
        BIconPlus
    },

    props: {
        max: String,
        min: {
            type: String,
            default: 0
        },
        size: {
            type:      String,
            required:  false,
            default:   'md',
            validator: function (value) {
                return ['sm', 'md', 'lg'].includes(value)
            }
        },
        step: {
            default: '1'
        },

        value: {
            type:     Number,
            required: true
        }
    },

    methods: {
        valueChange(newValue) {
            if (!this.validate(newValue)) return;

            this.$emit('change', newValue)
        },
        increment() {
            let value = parseInt(this.value) + parseInt(this.step);

            if (!this.validate(value)) this.value = this.max; return

            this.value = value;
            this.$emit('change', this.value)
        },
        decrement() {
            let value = parseInt(this.value) - parseInt(this.step);

            if (!this.validate(value)) return;

            this.value -= value;
            this.validate(this.value)
        },
        validate(value) {
            value = parseInt(value);
            return value >= parseInt(this.min) && value <= parseInt(this.max);
        }
    }
}
</script>

<style scoped>
/* Remove up and down arrows inside number input */
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>