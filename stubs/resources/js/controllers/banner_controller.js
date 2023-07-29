import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="banner"
export default class extends Controller {
    static targets = ['button', 'icon', 'content']

    static values = {
        style: { type: String, default: 'default' },
        message: { type: String, default: '' },
    }

    static classes = ['success', 'danger', 'default', 'buttonSuccess', 'buttonDanger', 'iconSuccess', 'iconDanger']

    setMessage(event) {
        this.styleValue = event.detail.style
        this.messageValue = event.detail.message
    }

    // private

    messageValueChanged() {
        this.contentTarget.innerText = this.messageValue
    }

    styleValueChanged() {
        this.toggleStyleClasses()
        this.toggleButtonStyleClasses()
        this.toggleStyleIcons()
    }

    toggleStyleClasses() {
        this.element.classList.remove(...this.allClasses)
        this.element.classList.add(...this.currentStyleClasses)
    }

    toggleButtonStyleClasses() {
        this.buttonTarget.classList.remove(...this.allButtonClasses)
        this.buttonTarget.classList.add(...this.currentStyleButtonClasses)
    }

    toggleStyleIcons() {
        this.iconTarget.classList.remove(...this.allIconClasses)
        this.iconTarget.classList.add(...this.currentStyleIconClasses)

        Array.from(this.iconTarget.children).forEach(icon => {
            if (icon.dataset.style === this.styleValue) {
                icon.classList.remove('hidden')
            } else {
                icon.classList.add('hidden')
            }
        })
    }

    get allIconClasses() {
        return [...this.iconSuccessClasses, ...this.iconDangerClasses]
    }

    get currentStyleIconClasses() {
        return {
            success: this.iconSuccessClasses,
            danger: this.iconDangerClasses,
        }[this.styleValue] || []
    }

    get currentStyleButtonClasses() {
        return {
            success: this.buttonSuccessClasses,
            danger: this.buttonDangerClasses,
        }[this.styleValue] || []
    }

    get allButtonClasses() {
        return [...this.buttonSuccessClasses, ...this.buttonDangerClasses]
    }

    get allClasses() {
        return [...this.successClasses, ...this.dangerClasses, ...this.defaultClasses]
    }

    get currentStyleClasses() {
        return {
            success: this.successClasses,
            danger: this.dangerClasses,
        }[this.styleValue] || this.defaultClasses
    }
}
