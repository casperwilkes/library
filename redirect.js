// Inline //
window.location.replace('location/to/redirect.html');

// Functions.js //
/**
 * Redirects user to specified location.
 * @param {string} redLocation Location to send user to
 * @returns {void}
 */
function redirect(redLocation) {
    if (redLocation !== 'undefined') {
        location.href = redLocation;
    }
}