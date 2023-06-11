import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="attribute-removal"
export default class extends Controller {
    static values = ['attribute']

    remove() {
        this.element.removeAttribute(this.attributeValue)
    }
}
