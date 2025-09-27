//Get Query Parameter
function getQueryParam(key) {
    return new URLSearchParams(window.location.search).get(key);
}
function addQueryParam(key) {
    const select = document.getElementById(key);
    const value = select.value;

    const url = new URL(window.location.href);

    if (value) {
        url.searchParams.set(key, value);
    } else {
        url.searchParams.delete(key); // remove if empty
    }
    // Update the URL without reloading
    window.history.pushState({}, "", url);
}

function addQueryParamWithValue(key, value) {


    const url = new URL(window.location.href);

    if (value) {
        url.searchParams.set(key, value);
    } else {
        url.searchParams.delete(key); // remove if empty
    }
    // Update the URL without reloading
    window.history.pushState({}, "", url);
}

function populateFieldsFromQuery(ref, defaultValue) {
    document.getElementById(ref).value = getQueryParam(ref) || defaultValue;
    addQueryParam(ref);
}

function formatDateForDatepicker(dateStr) {
    if (!dateStr) return "";

    const parts = dateStr.split("-"); // [YYYY, MM, DD]
    return `${parts[1]}/${parts[2]}/${parts[0]}`; // MM/DD/YYYY
}

function formatId(id) {
    return String(id).padStart(6, "0");
}