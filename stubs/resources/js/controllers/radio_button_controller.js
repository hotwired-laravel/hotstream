import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="radio-button"
export default class extends Controller {
    static targets = ['input', 'button']
    static classes = ['selected']

    connect() {
        if (this.inputTarget.value) {
            this._setValue(this.inputTarget.value)
        }
    }

    select({ target }) {
        const value = target.dataset.radioValue || target.closest('[data-radio-value]').dataset.radioValue

        this._setValue(value)
    }

    // private

    _setValue(value) {
        this.inputTarget.value = value
        this.inputTarget.dispatchEvent(new CustomEvent('input', { bubbles: true }))

        for (const button of this.buttonTargets) {
            if (button.dataset.radioValue === value) {
                button.classList.add(this.selectedClass)
            } else {
                button.classList.remove(this.selectedClass)
            }
        }
    }
}
