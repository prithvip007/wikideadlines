<template>
    <modal :trigger-hash="triggerHash">
        <div ref="card" class="card">
            <!-- <h5 class="card-header text-center">Sync to Google Calendar</h5> -->
        <modal-header-primary :lines="['Sync to Google Calendar']"></modal-header-primary>
            <div class="card-body">
                <picture-banner
                    v-if="hasSubscription === false"
                    :imageSource="imageSourceBanner"
                    :imageAlt="imageAltBanner"
                    :titleText="titleTextBanner"
                    :link="linkBanner"
                    :linkText="linkTextBanner"
                ></picture-banner>
                <template v-else>
                    <copy :text="googleLink" :options="() => ({ container: $refs.card })"></copy>
                    <div class="text-muted d-flex mt-3 d-flex align-items-start flex-column flex-sm-row">
                        <ol class="pl-3">
                            <li>Copy the link above</li>
                            <li>Go to <a href="https://calendar.google.com/" rel="noopener noreferrer" target="_blank">Google Calendar</a></li>
                            <li>In the bottom left, find <strong>Other calendars</strong></li>
                            <li>Select <strong>From URL</strong> from the menu then copy and paste the address provided above</li>
                        </ol>
                        <img style="width: 203px;" src="/images/google-calendar.png">
                    </div>
                </template>
            </div>
        </div>
    </modal>
</template>

<script>
    import Copy from './Copy';
    import PictureBanner from './PictureBanner';
    import Modal from './Modal/Modal';
    import ModalHeaderPrimary from './Modal/ModalHeaderPrimary';


    export const bannerProps = Object.keys(PictureBanner.props).reduce((accumulator, key) => {
        accumulator[`${key}Banner`] = PictureBanner.props[key];
        return accumulator;
    }, {}); 

    export default {
        components: {
            Copy,
            ModalHeaderPrimary,
            PictureBanner,
            Modal
        },
        props: {
            hasSubscription: {
                type: Boolean,
                required: true
            },
            triggerHash: {
                type: String,
                default: 'calendar-sync',
            },
            googleLink: {
                type: String,
                required: true
            },
            ...bannerProps
        }
    }
</script>
