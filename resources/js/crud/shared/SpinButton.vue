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
            v-model="newValue"
            :value="value"
            min="0"
            :max="max"
            :step="step"
            class="border-secondary text-center"
            number
            :placeholder="min"
            @focusout="valueChange($event.target.value)"
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

    data() {
        return {
            newValue: null
        }
    },

    methods: {
        valueChange(newValue) {
            newValue = parseInt(newValue)
            if (!this.validate(newValue)) {
                if (newValue > this.max) newValue = this.max;
                if (newValue < this.min) newValue = this.min;
                this.newValue = parseInt(newValue);
            } else {
                this.newValue = parseInt(newValue);
            }

            this.$emit('change', this.newValue)
        },
        increment() {
            let value = parseInt(this.newValue) + parseInt(this.step);
            if (!this.validate(value)) {
                this.newValue = parseInt(this.max);
                return
            }
            this.newValue = value;
            //
            this.$emit('change', this.newValue)
        },
        decrement() {
            let value = parseInt(this.newValue) - parseInt(this.step);

            if (!this.validate(value))  {
                this.newValue = this.min;
                return
            }

            this.newValue = value;
            this.$emit('change', this.newValue)

        },
        validate(value) {
            value = parseInt(value);
            return value >= parseInt(this.min) && value <= parseInt(this.max);
        }
    },
    mounted() {
        this.newValue = this.value;
    },
    watch: {
        value: {
            handler(val) {
                this.newValue = val;
            }
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