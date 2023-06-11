import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="autosubmitter"
export default class extends Controller {
    static targets = ['submit', 'input']

    submit() {
        this.submitTarget.click()
    }
}
