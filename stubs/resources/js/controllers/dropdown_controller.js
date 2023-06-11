import { Controller } from "@hotwired/stimulus"
import { enter, leave } from "el-transition"

// Connects to data-controller="dropdown"
export default class extends Controller {
    static targets = ['content']

    static values = {
        open: {type: Boolean, default: false},
    }

    open() {
        this.openValue = true
    }

    close() {
        this.openValue = false
    }

    toggle() {
        this.openValue = !this.openValue
    }

    closeWhenClickedOutside({ target }) {
        if (! this.openValue) return
        if (this.element.contains(target)) return

        this.close()
    }

    closeWhenTargetTop({ target }) {
        let trigger = ['a', 'button', 'form'].includes(target.nodeName)
            ? target
            : (target.closest('a') ?? target.closest('button[type=submit]'))

        if (trigger.dataset?.turboFrame !== '_top') return

        this.close()
    }

    // private

    openValueChanged() {
        if (this.openValue) {
            enter(this.contentTarget)
        } else {
            leave(this.contentTarget)
        }
    }
}
