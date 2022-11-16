<template>
    <div>
         <h1>  hear add new  select box</h1>

    </div>
    <div class="form-group">
<label class="font-weight-bold" for="document-type-id">
    Document or Pleading Title
</label>
<select ref="documentType" v-select2="{placeholder: 'Search Pleadings and Documents by Title'}"
        v-model="form.document_type_id"
        id="document-type-id"
        class="form-control"
        name="document_type_id" required>
    <option></option>
    <option v-for="type in documentTypes" :value="type.id" :key="type.id"
            :data-select2-description="type.small_description"
            :data-select2-keywords="type.keywords">
        {{ type.name }}
    </option>
</select>
<span v-for="error, index in getErrors('document_type_id')" class="invalid-feedback d-block" :key="index">
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
