import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="focus"
export default class extends Controller {
    focusNextTick({ target }) {
        setTimeout(() => {
            document.querySelector(target.dataset.focusTarget).focus();
        });
    }
}
