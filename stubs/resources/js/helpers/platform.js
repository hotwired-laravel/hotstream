const { userAgent } = window.navigator;

export const isIos = /iPhone|iPad/.test(userAgent)
export const isAndroid = /Android/.test(userAgent)
export const isMobile = isIos || isAndroid

export const isIosApp = /Turbo Native iOS/.test(userAgent)
export const isAndroidApp = /Turbo Native Android/.test(userAgent)
export const isMobileApp = isIosApp || isAndroidApp
