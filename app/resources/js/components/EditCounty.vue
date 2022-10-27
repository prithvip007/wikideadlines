<template>
    <tr>
        <td><i class="fa fa-home"></i></td>
        <td style="padding-bottom: 0.7rem;">
            <label class="mb-0">County</label>
            <div class="font-weight-bold">
                {{ currentName }}
            </div>
        </td>
        <td>
            <a
                href="#county"
                class="btn btn-light-blue d-print-none"
            >
                <i class="fa fa-pencil"></i>
            </a>
        </td>
        <modal :trigger-hash="triggerHash">
            <modal-header-primary
                :lines="['Update County']">
            </modal-header-primary>
            <form @submit.prevent="save" method="post">
                <modal-body>
                    <div class="form-group mb-4">
                        <label class="font-weight-bold" for="county-id">
                            County
                        </label>
                        <select v-select2="{placeholder: 'Select a County'}" v-model="form.county_id" id="county-id"
                                class="form-control"
                                name="county_id" required>
                            <option></option>
                            <option v-for="county in counties" :value="county.id" :key="county.id">{{ county.name }}</option>
                        </select>
                        <div class="small text-muted mt-2">
                            County will be updated for all calculations under current case name
                        </div>
                        <span v-for="error, index in (errors['county_id'] || [])" class="invalid-feedback d-block" :key="index">
                            {{ error }}
                        </span>
                    </div>
                </modal-body>
                <modal-footer-button :loading="isSaving">
                    Save
                </modal-footer-button>
            </form>
        </modal>
    </tr>
</template>

<script>
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';
    import ModalFooterButton from './Modal/ModalFooterButton';
    import ModalBody from './Modal/ModalBody';
    import { client } from '../client';

    export default {
        props: {
            triggerHash: Modal.props.triggerHash,
            caseName: {
                type: String,
                required: true
            },
            initialCounty: {
                type: Object,
                required: false,
                default: () =>({ name: 'Not Selected', id: 0 })
            },
            counties: {
                type: Array,
                required: false
            }
        },
        components: {
            Modal,
            ModalHeaderPrimary,
            ModalBody,
            ModalFooterButton
        },
        data() {
            return {
                currentName: this.initialCounty.name,
                form: { county_id: this.initialCounty.id, case_name: this.caseName },
                isSaving: false,
                errors: {}
            };
        },
        methods: {
            async save() {
                this.errors = {};
                this.isSaving = true;

                try {
                    await client.updateCountyForCaseName(this.form);
                    this.currentName = this.counties.find(({ id }) => id === this.form.county_id).name;
                    
                    toaster.add('County updated', 'County has been successfully updated');
                } catch (e) {
                    if (e?.response?.data?.errors) {
                        this.errors = e.response.data.errors;
                    } else {
                        console.error(e);
                    }
                } finally {
                    this.isSaving = false;
                }
            },
        },
        created() {
            
        }
    }
</script>
