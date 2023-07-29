import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="reveal"
export default class extends Controller {
    static values = {
        show: Boolean,
    }

    show() {
        this.showValue = true
    }

    hide() {
        this.showValue = false
    }

    toggle() {
        this.showValue = ! this.showValue
    }

    // private

    showValueChanged() {
        if (this.showValue) {
            this.element.classList.remove('hidden')
        } else {
            this.element.classList.add('hidden')
        }
    }
}
