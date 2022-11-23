<template>
    <div ref="body">
        <div v-if="hasOptionalElements(elements)" class="d-flex justify-content-end pb-1">
            <button
                :class="`btn btn-sm ${hideOptional ? 'btn-warning': 'btn-primary'} rounded-m`"
                type="button"
                @click="onHideOptional"
            >
                {{
                    hideOptional ? 'Show Optional Questions': 'Hide Optional Questions'
                }}
            </button>
        </div>
        <template v-for="element in elements">
            <div
                :key="element.id"
                class="form-group"
                :class="getSpacingClassName(element)"
                v-if="isElementExcluded(element.key) === false && checkConditions(element) && shouldDisplay(element)"
            >
                <template v-if="element.type === 'input-radio'">
                    <label class="font-weight-bold" v-if="getElementTitle(element)">
                        {{ getElementTitle(element) }}
                        <small
                            v-if="element.data.required === false"
                            class="text-muted"
                        >
                            (optional)
                        </small>
                        <i
                            v-if="element.data.help"
                            data-toggle="tooltip"
                            data-placement="top"
                            :title="element.data.help"
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                        <small v-if="element.data.smallDescription" class="text-muted d-block">
                            {{ element.data.smallDescription }}
                        </small>
                    </label>
                    <div
                        :key="radio.id"
                        v-for="radio in element.data.items"
                        class="custom-control custom-radio"
                    >
                        <input
                            class="custom-control-input"
                            type="radio"
                            v-model="fields[generateModel(element).key]"
                            :id="`id-${radio.id}-${element.id}-${idSeed}`"
                            :name="`name-${element.id}-${idSeed}`"
                            :value="radio.title"
                            :required="element.data.required"
                            :disabled="readonly"
                        >
                        <label
                            :for="`id-${radio.id}-${element.id}-${idSeed}`"
                            class="custom-control-label"
                        >
                            {{ radio.title }}
                        </label>
                        <small
                            v-if="radio.smallDescription"
                            class="text-muted d-block"
                        >
                            {{ radio.smallDescription }}
                        </small>
                    </div>
                </template>
                <template v-else-if="element.type === 'input-checkbox'">
                    <label class="font-weight-bold" v-if="element.data.title">
                        {{ element.data.title }}
                        <small v-if="element.data.smallDescription" class="text-muted d-block">
                            {{ element.data.smallDescription }}
                        </small>
                    </label>
                    <div :class="{ 'ml-3': element.intend }">
                    <div
                        :key="checkbox.id"
                        v-for="checkbox in element.data.items"
                        class="custom-control custom-checkbox"
                        :class="{ 'mt-2': checkbox.rowUp }"
                    >
                        <input
                            v-model="fields[generateModel(element).key]"
                            type="checkbox"
                            class="custom-control-input"
                            :value="checkbox.title"
                            :required="element.data.required"
                            :id="`id-${checkbox.id}-${element.id}-${idSeed}`"
                            :name="`${generateModel(element).key}-${idSeed}`"
                            :disabled="readonly"
                        >
                        <label
                            :for="`id-${checkbox.id}-${element.id}-${idSeed}`"
                            class="custom-control-label"
                        >
                            {{ checkbox.title }}
                            <i
                                v-if="checkbox.help"
                                data-toggle="tooltip"
                                data-placement="top"
                                :title="checkbox.help"
                                class="fa fa-question-circle-o help ml-1"
                            ></i>
                        </label>
                        <small
                            v-if="checkbox.smallDescription"
                            class="text-muted d-block"
                        >
                            {{ checkbox.smallDescription }}
                        </small>
                    </div>
                    </div>
                </template>
                <template v-else-if="element.type.match(/input-.+/)">
                    <label class="font-weight-bold">
                        {{ element.data.title }}
                        <small
                            v-if="element.data.required === false"
                            class="text-muted"
                        >
                            (optional)
                        </small>
                        <i
                            v-if="element.data.help"
                            data-toggle="tooltip"
                            data-placement="top"
                            :title="element.data.help"
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                    </label>
                    <input
                        :maxlength="element.data.maxlength"
                        v-model="fields[generateModel(element).key]"
                        :type="element.type.match(/-(.+)/)[1]"
                        :required="element.data.required"
                        class="form-control"
                        :disabled="readonly"
                        :class="{'is-invalid': hasError(element.key)}"
                    >
                    <small
                        v-if="element.data.smallDescription"
                        class="text-muted"
                    >
                        {{ element.data.smallDescription }}
                    </small>
                    <span :key="error" v-for="error in getErrors(element.key)" class="invalid-feedback">
                        {{ error }}
                    </span>
                </template>
                <template v-else-if="element.type === 'select'">
                    <label class="font-weight-bold" v-if="element.data.title">
                        {{ element.data.title }}
                        <small v-if="element.data.smallDescription" class="text-muted d-block">
                            {{ element.data.smallDescription }}
                        </small>
                    </label>
                    <select
                        v-model="fields[generateModel(element).key]"
                        v-select2="{placeholder: element.data.placeholder, minimumResultsForSearch: 15}"
                        class="form-control"
                        :name="`name-${element.id}-${idSeed}`"
                        :required="element.data.required"
                        :disabled="readonly"
                        :class="{'is-invalid': hasError(element.key)}"
                    >
                        <option></option>
                        <template v-for="item in element.data.items">
                            <option
                                v-if="isItemExcluded(item.key) === false"
                                :key="item.id"
                                :data-select2-description="item.smallDescription"
                                :value="item.title"
                            >
                                {{ item.title }}
                            </option>
                        </template>
                    </select>
                    <span :key="error" v-for="error in getErrors(element.key)" class="invalid-feedback">
                        {{ error }}
                    </span>
                </template>
                <template v-else-if="element.type === 'textarea'">
                    <label
                        class="font-weight-bold"
                        v-if="element.data.title"
                    >
                        <template v-if="Array.isArray(element.data.title)">
                            <template v-for="title, index in element.data.title">
                                <br v-if="index !== 0" :key="title">
                                {{ title }}
                            </template>
                        </template>
                        <template v-else>{{ element.data.title }}</template>
                        <small
                            v-if="element.data.required === false"
                            class="text-muted"
                        >
                            (optional)
                        </small>
                        <i
                            v-if="element.data.help"
                            data-toggle="tooltip"
                            data-placement="top"
                            :title="element.data.help"
                            class="fa fa-question-circle-o help ml-1"
                        ></i>
                    </label>
                    <textarea
                        :maxlength="element.data.maxlength"
                        :placeholder="element.data.placeholder"
                        class="form-control"
                        :class="{'is-invalid': hasError(element.key)}"
                        :rows="element.data.rows"
                        v-model="fields[generateModel(element).key]"
                        :required="element.data.required"
                        :disabled="readonly"
                    ></textarea>
                    <small
                        v-if="element.data.smallDescription"
                        class="text-muted"
                    >
                        {{ element.data.smallDescription }}
                    </small>
                    <span :key="error" v-for="error in getErrors(element.key)" class="invalid-feedback">
                        {{ error }}
                    </span>
                </template>
                <template v-else-if="element.type === 'multiselect'">
                    <label class="font-weight-bold" v-if="element.data.title">
                        {{ element.data.title }}
                        <small v-if="element.data.smallDescription" class="text-muted d-block">
                            {{ element.data.smallDescription }}
                        </small>
                    </label>
                    <multiselect
                        :multiple="true"
                        v-model="fields[generateModel(element).key]"
                        label="title"
                        track-by="id"
                        :class="{'is-invalid': hasError(element.key)}"
                        :options="element.data.items"
                    ></multiselect>
                    <span :key="error" v-for="error in getErrors(element.key)" class="invalid-feedback">
                        {{ error }}
                    </span>
                </template>
            </div>
        </template>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            Multiselect
        },
        props: {
            excludeItems: {
                type: Array,
                required: false
            },
            errors: {
                type: Object,
                required: false
            },
            excludeElements: {
                type: Array,
                required: false
            },
            readonly: {
                type: Boolean,
                required: false
            },
            elements: {
                type: Array,
                required: true
            }
        },
        watch: {
             elements() {
                this.fields = this.generateModalFields();
            },
            errors() {
                this.$nextTick(() => {
                    this.scrollFirstErrorIntoView();
                });
            }
        },
        data() {
            return {
                fields: this.generateModalFields(),
                idSeed: '',
                hideOptional: false
            }
        },
        methods: {
            generateModel(item) {
                const { id, type, data: { defaultValue, items }, key } = item;

                const fieldKey = key || `${type}-${id}`;

                if (
                    type === 'input-checkbox' ||
                    type === 'multiselect'
                ) {
                    return {
                        key: fieldKey,
                        value: items.reduce((accumulator, { title, defaultChecked }) => {
                            if (defaultChecked) {
                                accumulator.push(title);
                            }

                            return accumulator;
                        }, [])
                    };
                }

                if (
                    /input-.+/.test(type) || 
                    type === 'textarea' || 
                    type === 'select'
                ) {
                    return {
                        key: fieldKey,
                        value: defaultValue === undefined || defaultValue === null ? '' : defaultValue
                    };  
                }

                throw new Error(`Unsupported element type: ${type}`);
            },
            checkModelValue({ elementId, itemId, operator }) {
                const element = this.elements.find(({ id }) => id === elementId);

                const { key } = this.generateModel(element);

                const currentModelValue = this.fields[key];
                const expectedValue = element.data.items.find(({ id }) => id === itemId).title;

                if (Array.isArray(currentModelValue)) {
                    return operator === 'ne'
                        ? !currentModelValue.includes(expectedValue)
                        : currentModelValue.includes(expectedValue)
                } else {
                    return operator === 'ne'
                        ? currentModelValue && currentModelValue !== expectedValue
                        : currentModelValue === expectedValue
                }
            },
            getElementTitle(element) {
                if (!element.data.pattern) {
                    return Array.isArray(element.data.title) ? element.data.title.join(' ') : element.data.title;
                }

                const { keys, title } = element.data.pattern;

                let result = title;

                Object.keys(keys).forEach((key) => {
                    const $key = `$${key}`;
                    const { elementId, itemId } = keys[key];

                    const element = this.elements.find(({ id }) => elementId === id);
                    const { key: fieldKey } = this.generateModel(element);
                    const data = this.fields[fieldKey];

                    result = result.replace($key, data);
                });

                return result;
            },
            checkConditions(element) {
                if (!element.conditions) {
                    return true;
                }

                return element.conditions.every(({ rule, items }) => {
                    if (rule.toUpperCase() === 'OR') {
                        return items.some(this.checkModelValue);
                    }

                    if (rule.toUpperCase() === 'AND') {
                        return items.every(this.checkModelValue);
                    }
                })
            },
            getMeta(element) {
                const { key } = this.generateModel(element);
                const value = this.fields[key];
                const { type, data: { items } } = element;

                if (
                    type === 'input-checkbox' ||
                    type === 'multiselect'
                ) {
                    return {
                        key,
                        item: items.reduce((accumulator, { id, title, referenceKey }) => {
                                if (value.includes(title)) {
                                    accumulator.id.push(id);
                                    accumulator.referenceKeys.push(referenceKey);
                                }

                                return accumulator;
                        }, { id: [], referenceKeys: [] })
                    };
                }
                if (type === 'input-radio') {
                    return {
                        key,
                        item: { id: items.find(({ title }) => title === value)?.id }
                    };
                }

                if (type === 'select') {
                    return {
                        key,
                        item: {
                            id: items.find(({ title }) => title === value)?.id,
                            referenceKey: items.find(({ title }) => title === value)?.referenceKey
                        }
                    };  
                }

                if (
                    /input-.+/.test(type) ||
                    type === 'textarea'
                ) {
                    return {
                        key
                    };  
                }
            },
            generateOutput(opts = {}) {
                const defaultOptions = {
                    includeMeta: true,
                };

                const options = {...defaultOptions, ...opts};

                const output = [];

                this.elements.forEach((element) => {
                    if (this.checkConditions(element) === false || this.shouldDisplay(element) === false) {
                        return;
                    }

                    const { key } = this.generateModel(element);
                    const title = this.getElementTitle(element);

                    let value = '';
                    if (element.type === 'multiselect') {
                        value = this.fields[key].map(({ title }) => title).join(', ');
                    } else {
                        value = Array.isArray(this.fields[key]) ? this.fields[key].join(', ') : String(this.fields[key]);
                    }

                    const data = { title, value };

                    if (options.includeMeta) {
                        const meta = this.getMeta(element);
                        data.meta = meta;
                    }

                    output.push(data);
                });

                return output;
            },
            initializeTooltips() {
                this.$nextTick(() => {
                    $(this.$refs.body).find('.help').tooltip();
                });
            },
            scrollFirstErrorIntoView() {
                const element = $(this.$refs.body).find('.is-invalid')[0];

                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
            },
            getSpacingClassName(element) {
                const { spacing } = element.data;

                if (!spacing) {
                    return '';
                }

                return Object.keys(spacing).reduce((accumulator, spacingKey) => {
                    const type = spacingKey.charAt(0);

                    Object.keys(spacing[spacingKey]).forEach((sizeKey) => {
                        const side = sizeKey.charAt(0);
                        const size = spacing[spacingKey][sizeKey];

                        const className = `${type}${side}-${size}`;

                        accumulator.push(className);
                    });

                    return accumulator;
                }, []);
            },
            isItemExcluded(key) {
                return this.excludeItems ? this.excludeItems.includes(key) : false;
            },
            isElementExcluded(key) {
                return this.excludeElements ? this.excludeElements.includes(key) : false;
            },
            generateModalFields() {
                const fields = this.elements.reduce((fields, item) => {
                    const model = this.generateModel(item);
                    const { key, value } = model;

                    fields[key] = value;

                    return fields;
                }, {});

                return fields;
            },
            getErrors(key) {
                return this?.errors?.[key];
            },
            hasError(key) {
                return !!this?.errors?.[key]?.length;
            },
            onHideOptional() {
                this.hideOptional = !this.hideOptional;
            },
            shouldDisplay(element) {
                // as checkboxes are always optional we should display them anyway
                if (element.type === 'input-checkbox') {
                    return true;
                }

                return element.data.required ? true : !this.hideOptional;
            },
            hasOptionalElements(elements) {
                return elements.some((element) => element.data.required === false);
            }
        },
        created: function () {
            this.idSeed = String(Math.random());
            this.initializeTooltips();
        },
        updated: function () {
            this.initializeTooltips();
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

