import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="reveal"
export default class extends Controller {
    static targets = ['visibleWhenShown', 'hiddenWhenShown']

    static values = {
        show: { type: Boolean, default: false },
        toggleCurrentElement: { type: Boolean, default: true },
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
        this.toggleElementVisibility()
        this.toggleVisibleElements()
    }

    toggleElementVisibility() {
        if (! this.toggleCurrentElementValue) return

        if (this.showValue) {
            this.element.classList.remove('hidden')
        } else {
            this.element.classList.add('hidden')
        }
    }

    toggleVisibleElements() {
        if (this.showValue) {
            this.hideElements(this.hiddenWhenShownTargets)
            this.showElements(this.visibleWhenShownTargets)
        } else {
            this.hideElements(this.visibleWhenShownTargets)
            this.showElements(this.hiddenWhenShownTargets)
        }
    }

    hideElements(elements) {
        elements.forEach(el => {
            if (el.dataset.shown) el.classList.remove(el.dataset.shown)

            el.classList.add('hidden')
        })
    }

    showElements(elements) {
        elements.forEach(el => {
            el.classList.remove('hidden')
            if (el.dataset.shown) el.classList.add(el.dataset.shown)
        })
    }
}
