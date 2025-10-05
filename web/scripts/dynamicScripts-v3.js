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

function populateDataList(prefix, datalistid, service) {

    var fd = new FormData();
    fd.append('service', service);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success && result.data) {
                let datalist = $("#" + datalistid);
                datalist.empty(); // clear old items

                result.data.forEach(function (item) {
                    // display = "supid - itemname", value = "supid"
                    datalist.append(
                        $("<option>")
                            .attr("value", prefix + formatId(item.id) + " - " + item.itemname)
                            .attr("data-value", item.id)
                    );
                });

            }
        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });

}