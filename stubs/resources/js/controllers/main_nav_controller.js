import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="main-nav"
export default class extends Controller {
    static targets = ['link']
    static classes = ['selected']

    connect() {
        this.higlightCurrentNavLink()
    }

    higlightCurrentNavLink() {
        const { pathname } = window.location

        for (const link of this.linkTargets) {
            const pattern = new RegExp(link.dataset.navPattern)

            if (pathname.match(pattern) !== null) {
                link.classList.add(this.selectedClass)
            } else {
                link.classList.remove(this.selectedClass)
            }
        }
    }
}
