ensurePageParam();
function ensurePageParam(defaultPage = 1) {
    const url = new URL(window.location.href);

    if (!url.searchParams.has("page")) {
        url.searchParams.set("page", defaultPage);
        // Update the URL without reloading
        window.history.replaceState({}, "", url);
    }

    return url.searchParams.get("page");
}