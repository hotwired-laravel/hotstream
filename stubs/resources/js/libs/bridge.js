import { isMobileApp } from "helpers/platform";

if (isMobileApp) {
    document.documentElement.classList.add('native');
}
