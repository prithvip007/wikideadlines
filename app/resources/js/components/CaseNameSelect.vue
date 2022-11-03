<template>
    <div class="form-group">
        <label class="font-weight-bold" for="case-name">
            Matter / Case Name
            <span class="text-muted">(Optional - for your reference)</span>
        </label>

        <select
            v-if="dynamic"
            v-select2="getOptions()"
            v-on:change="handleChange"
            id="case_name"
            class="form-control"
            name="case_name"
            required
            placeholder='Select a Matter / Case Name Or Type'
        >
            <option v-if="value" selected="true" :value="value">
                {{ value }}
            </option>
        </select>

        <input
            v-else
            :class="{'form-control': true, 'is-invalid': errors.length > 0}"
            name="case_name"
            id="case-name"
            placeholder= 'Select a Matter / Case Name Or Type'
            
        >
        <span
            v-for="(error, index) in errors"
            class="invalid-feedback"
            :key="index"
        >
            {{ error }}
        </span>
    </div>
</template>

<script>
import { client } from '../client';

export default {
    props: {
        dynamic: {
            type: Boolean,
            required: false,
            default: true
        },
        errors: {
            type: Array,
            required: false,
            default: () => []
        },
        value: {
            type: String,
            required: false,
            default: ""
        }
    },
    data() {
        return {
            cache: {},
            current: []
        }
    },
    methods: {
        getOptions() {
            const self = this;

            return {
                tags: true,
                allowClear: true,
                placeholder: {
                    id: '-1', // the value of the option
                    text: ''
                },
                ajax: {
                    delay: 100,
                    transport: function (params, success, failure) {
                        function _success(data) {
                            self.current = data.results;
                            success(data);
                        }

                        const cacheKey = `${params.data.q}|${params.data.page}`;

                        if (params.cache && self.cache[cacheKey]) {
                            setTimeout(() => _success(self.cache[cacheKey]));
                            return;
                        }

                        client
                            .getCaseNames(params.data.q, params.data.page)
                            .then((response) => {
                                self.cache[cacheKey] = response.data;
                                _success(self.cache[cacheKey]);
                            })
                            .catch(failure)
                    },
                    cache: true
                },
                placeholder: 'Select a Matter / Case Name Or Type'
               // minimumInputLength: 1
            };
        },
        handleChange(event) {
            const result = this.current.find(({ id }) => event.currentTarget.value === id);
            this.$emit("input", event.currentTarget.value, result);
        }
    }
};
</script>
