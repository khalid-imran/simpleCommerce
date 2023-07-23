<template>
    <popup-modal ref="popup">
        <div class="text-center">
            <img class="delete mb-3 mt-2" width="45" height="45">
            <p class="text-danger mb-4 fs-4">{{message}}</p>
        </div>
        <div class="text-center">
            <button class="btn btn-secondary me-2 btn-width" @click="_cancel">{{cancelButton}}</button>
            <span class="btn btn-danger btn-width" v-if="!loading" @click="_confirm">{{okButton}}</span>
            <span class="btn btn-danger btn-width" v-if="loading" >
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </div>
    </popup-modal>
</template>


<script>
import PopupModal from './PopupModal.vue'
export default {
    name: 'ConfirmDialogue',

    components: { PopupModal },

    data: () => ({
        // Parameters that change depending on the type of dialogue
        message: undefined, // Main text content
        okButton: undefined, // Text for confirm button; leave it empty because we don't know what we're using it for
        cancelButton: 'Cancel', // text for cancel button
        loading: false,
        // Private variables
        resolvePromise: undefined,
        rejectPromise: undefined,
    }),

    methods: {
        show(opts = {}) {
            this.message = opts.message
            this.okButton = opts.okButton
            if (opts.cancelButton) {
                this.cancelButton = opts.cancelButton
            }
            // Once we set our config, we tell the popup modal to open
            this.$refs.popup.open()
            return new Promise((resolve, reject) => {
                this.resolvePromise = resolve
                this.rejectPromise = reject
            })
        },

        _confirm() {
            this._loading(true)
            this.resolvePromise(true)
        },
        _hide() {
            this.$refs.popup.close()
        },
        _cancel() {
           this._hide()
            this.resolvePromise(false)
        },
        _loading (type) {
            this.loading = type
        }
    },
}
</script>


<style scoped>


</style>
