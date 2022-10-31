<template>
    <div class="card bg-light mb-3 card-m" style="overflow:hidden">
        <edit-document
            :document-id="documentId"
            trigger-hash="edit-document"
            :document-elements="documentElements"
            :initial-email="initialEmail"
        >
        </edit-document>
        <add-deadline-rule
            v-for="(deadline) in deadlines" :key="deadline.id"
            :document-id="documentId"
            type="edit_deadline"
            :initial-email="initialEmail"
            :deadline-id="deadline.id"
            :trigger-hash="getEditRuleHash(deadline.id)"
            :calculation-id="calculation.id"
            :document-title="getElementDefaultValueByKey(deadline.interviewData, 'document-title')"
            :elements="deadline.interviewData"
            :exclude-items="['authority-source-frcp']"
        >
        </add-deadline-rule>
        <sync-to-calendar
            :google-link="getGoogleLink()"
            trigger-hash="calendar-sync"
            ref="syncToCalendar"
            :has-subscription="hasSubscription"
            :image-source-banner="imageSourceBanner"
            :image-alt-banner="imageAltBanner"
            :title-text-banner="titleTextBanner"
            :link-banner="linkBanner"
            :link-text-banner="linkTextBanner"
        ></sync-to-calendar>
        <div class="card-header bg-white px-3">
            <div class="d-flex align-items-start align-items-md-center justify-content-between flex-column flex-md-row">
                <div class="header d-flex d-md-block align-items-center mb-2 mb-md-0">
                    Key deadlines and best practices for <br> {{ documentTypeName }}
                    <a href="#edit-document" class="btn btn-light-blue d-print-none"><i class="fa fa-pencil"></i></a>
                </div>
                <a
                    v-if="hasFormattedDate(deadlines)"
                    href="#calendar-sync"
                    :class="{ disabled: calendar.length === 0 }"
                    class="btn btn-orange-soda d-print-none text-nowrap rounded-m"
                >
                    Add <i class="fa fa-calendar d-md-none"></i><span class="d-none d-md-inline">To Calendar</span> ({{ calendar.length }})
                </a>
            </div>
        </div>
        <div class="card-body px-3 pb-2 pt-4 bg-white">
            <template
                v-for="(deadline, index) in deadlines"
            >
                <label
                    v-if="shouldDisplayDeadline(deadline)"
                    :for="`deadline-${deadline.id}`"
                    :key="deadline.id"
                    :class="`d-flex ${(deadline.checkDpsPreciseness && deadline.isDPSLate) ? ' text-muted' : (deadline.isDatePast ? ' text-muted' : '')}`"
                >
                    <div v-if="hasFormattedDate(deadlines)" class="form-check d-print-none">
                        <input class="form-check-input position-static" type="checkbox" :id="`deadline-${deadline.id}`" :value="deadline.id" v-model="calendar">
                    </div>
                    <div style="flex: 1 1 auto">
                        <div>
                            <b :class="{ 'text-danger': deadline.isDatePast || (deadline.checkDpsPreciseness && deadline.isDPSLate) }">{{ deadline.dateFormatted }}</b>
                            <b class="d-block" style="color:#005fac">{{ deadline.title }}</b>
                            <div class="pull-right">
                                <a
                                    :href="`#${getEditRuleHash(deadline.id)}`"
                                    class="btn btn-light-blue d-print-none"
                                >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button
                                    @click="onThumb(deadline.id)"
                                    class="btn btn-light-blue d-print-none ml-1"
                                >
                                    <i :class="`fa ${getThumb(deadline.id).active ? 'fa-thumbs-up' : 'fa-thumbs-o-up'}`"></i>
                                    {{ getThumb(deadline.id).count || ''  }}
                                </button>
                            </div>
                        </div>
                        <div :class="{ 'mb-3': !hasFormattedDate(deadlines) }" class="deadline-name text-break" :id="`deadline-name-${deadline.id}`">
                            {{ deadline.name }}
                        </div>
                        <div v-if="deadline.bestPractices" class="mt-1 py-1 px-2 rounded border border-light-blue best-practices text-break">
                            <pre class="mb-0" style="white-space:pre-wrap;font-size:inherit;font-family:inherit;">{{ deadline.bestPractices.trim() }}</pre>
                        </div>
                        <div v-if="deadline.checkDpsPreciseness && calculation.isDPSLate" class="col-12 mt-2 mb-1">
                            <div class="alert alert-danger mb-0">
                                <strong class="d-block">This document was served late</strong>
                                It should have a Proof of Service Date on or before
                                <b>{{ deadline.dateFormatted }}</b> in order
                                {{ calculation.deliveryArea === 1 ? 'to arrive by this method of delivery from outside the country.' : '' }}
                                {{ calculation.deliveryArea === 2 ? 'to arrive by this method of delivery from outside the state.' : '' }}
                                {{ calculation.deliveryArea !== 1 && calculation.deliveryArea !== 2  ? 'to arrive by this method of delivery from inside the state.' : '' }}
                            </div>
                        </div>
                        <hr v-if="index !== deadlines.length - 1">
                    </div>
                </label>
            </template>
        </div>
        <div v-if="documentBestPractices" class="card-footer" style="white-space: pre-wrap;background-color: #CAE7E7A6;">{{ documentBestPractices.trim() }}</div>
    </div>
</template>

<style scoped>
    .header {
        font-size: 16px;
    }

    .best-practices {
        background-color: #CAE7E7A6;
        color: black;
        border-radius: 10px !important;
    }
</style>

<script>
    import SyncToCalendar, { bannerProps } from './SyncToCalendar.vue';
    import AddDeadlineRule from './Interviews/AddDeadlineRule';
    import EditDocument from './Interviews/EditDocument.vue';
    import { client } from '../client';

    export default {
        components: {
            SyncToCalendar,
            AddDeadlineRule,
            EditDocument
        },
        props: {
            documentId: {
                type: Number,
                required: false
            },
            documentBestPractices: {
                type: String,
                required: false
            },
            documentElements: {
                type: Array,
                required: true
            },
            googleLink: {
                type: String,
                required: true
            },
            documentTypeName: {
                type: String,
                required: true
            },
            calculation: {
                type: Object,
                required: true
            },
            initialEmail: {
                type: String,
                required: false,
                default: ''
            },
            deadlines: {
                type: Array,
                required: true
            },
            hasSubscription: SyncToCalendar.props.hasSubscription,
            ...bannerProps
        },
        data() {
           return {
               requestingThumb: false,
               thumbs: this.deadlines.map(({ id, thumbsCount, thumbActive }) => ({  deadlineId: id, count: thumbsCount, active: thumbActive })),
                calendar: this.deadlines.reduce((acc, { id, title, visibilityScopes }) => {
                    const scopes = visibilityScopes || [];
                    if (scopes.some((scope) => scope === `no_check:${this.calculation.type}`)) {
                        return acc;
                    }

                    if (!title) {
                        acc.push(String(id));
                        return acc;
                    }

                    const matched = [['file', 'motion'], ['serve','motion']].some((tokens) => {
                        return tokens.every((token) => {
                            return title.toLowerCase().search(token.toLowerCase()) > -1;
                        });
                    });

                    if (!matched) {
                        acc.push(String(id));
                    }

                    return acc;
                }, [])
           }
        },
        methods: {
            shouldDisplayDeadline(deadline) {
                const scopes = deadline.visibilityScopes || [];
                return scopes.some((scope) => scope === `no_display:${this.calculation.type}`) === false;
            },
            hasFormattedDate(deadlines) {
                return deadlines.some(({ dateFormatted }) => Boolean(dateFormatted));
            },
            getElementDefaultValueByKey(elements, key) {
                const element = elements.find(({ key: elKey }) => elKey === key);

                if (!element) {
                    return;
                }


                return element.data.defaultValue;
            },
            async onThumb(deadlineId) {
                if (this.requestingThumb) {
                    return;
                }

                const thumb = this.getThumb(deadlineId);

                try {
                    this.requestingThumb = true;

                    if (thumb.active) {
                        await client.deleteThumb(deadlineId, this.calculation.id);
                    } else {
                        await client.createThumb(deadlineId, { calculation_id: this.calculation.id });
                    }

                    thumb.active = !thumb.active;
                    thumb.count = thumb.active ? thumb.count + 1 : thumb.count - 1
                } catch (e) {
                    console.error(e);
                } finally {
                    this.requestingThumb = false;
                }
            },
            getThumb(id) {
                return this.thumbs.find(({ deadlineId }) => id === deadlineId);
            },
            getGoogleLink() {
                try {
                    const { origin, pathname, search } = new URL(this.googleLink);

                    const calendarParameters = this.calendar.reduce((accumulator, current, index, array) => {
                        const isFirst = index === 0;
                        const arrayCharacter = encodeURIComponent('[]');
                        const value = encodeURIComponent(current);
                        const parameter = `id${arrayCharacter}=${value}`;

                       return isFirst ? parameter : `${accumulator}&${parameter}`;
                    }, '');

                    const query = search.length === 0 ? `?${calendarParameters}` : `${search}&${calendarParameters}`;

                    const url = `${origin}${pathname}${query}`;

                    return url;
                } catch(e) {
                    console.error(e);
                    return '';
                }
            },
            getEditRuleHash(id) {
                return `edit-rule-${id}`;
            }
        }
    }
</script>
