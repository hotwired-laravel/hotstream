import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="autoselect"
export default class extends Controller {
    connect() {
        this.element.select()
    }
}
