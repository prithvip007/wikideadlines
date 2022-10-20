<template>
    <div class="container-fluid">
        <div class="col-12">
            <h1>Interview Data</h1>
            <div>
                <div class="form-group">
                    <label class="font-weight-bold" for="document-type-id">
                        Status
                    </label>
                    <div class="d-flex">
                        <select style="flex: 1 1 auto;min-width: 0;" ref="documentType" v-select2="{placeholder: 'Search Pleadings and Documents by Title'}"
                                v-model="status"
                                id="document-type-id" class="form-control"
                                name="document_type_id" required>
                            <option></option>
                            <option v-for="type in ['Approved', 'Rejected', 'Review Later']" :value="type" :key="type"
                                    :data-select2-description="type.small_description"
                                    :data-select2-keywords="type.keywords">
                                {{ type }}
                            </option>
                        </select>
                        <button :disabled="isSaving" class="btn btn-success d-flex align-items-center justify-content-center ml-4" type="submit">
                            Save
                            <div v-if="isSaving" class="spinner-border spinner-border-sm ml-2" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <section
                    v-for="data, index in interview"
                    :key="index"
                >
                    <h6 class="font-weight-bold">{{ data.title }}</h6>
                    <p>{{ data.value }}</p>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            documentName: {
                type: String,
                required: true
            },
            requestEmail: {
                type: String,
                required: false
            },
            interview: {
                type: Array,
                required: true
            }
        },
        data() {
            return {
                isSaving: false,
                status: '',
                interview: (new Array(20)).fill(1).map(() => ({ title: 'Enter the title of the document or event', value: 'dssgfdg' }))
            }
        },
        methods: {

        }
    }
</script>
