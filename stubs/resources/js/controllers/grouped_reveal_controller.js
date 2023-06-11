import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="grouped-reveal"
export default class extends Controller {
    static targets = ['reveal']
    static values = {
        'initial': String,
    }
    static classes = ['toggle']

    connect() {
        this._showOnlyElementsOfGroup(this.initialValue)
    }

    toggle({ target }) {
        this._showOnlyElementsOfGroup(target.dataset.revealGroupToggle)
    }

    // private

    _showOnlyElementsOfGroup(group) {
        for (const el of this.revealTargets) {
            if (el.dataset.revealGroup == group) {
                el.classList.remove(this.toggleClass)
            } else {
                el.classList.add(this.toggleClass)
            }
        }
    }
}
