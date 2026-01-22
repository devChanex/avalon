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
function calculateAge(birthDate) {
    const birth = new Date(birthDate);
    const today = new Date();
    let age = today.getFullYear() - birth.getFullYear();
    const monthDiff = today.getMonth() - birth.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
    }
    return age;
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
function getCurrentDate() {

    return new Date().toISOString().split('T')[0];

}
function formatDateTime(datetimeStr) {
    const date = new Date(datetimeStr);

    if (isNaN(date)) return ""; // handle invalid dates

    const options = {
        month: "2-digit",
        day: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        hour12: true
    };

    return date.toLocaleString("en-US", options);
}


function setDynamicOption(optionid, inputid, hiddenInputId) {
    var supplyText = document.getElementById(inputid).value;

    let hiddenInput = document.getElementById(hiddenInputId);
    let options = document.getElementById(optionid).options;

    hiddenInput.value = ""; // clear first

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === supplyText) {
            hiddenInput.value = options[i].dataset.value; // store only code
            break;
        }
    }

}
const dataListCache = {}; // key: service, value: result.data
function populateDataList(prefix, datalistid, service, version) {
    return new Promise((resolve, reject) => {

        // 🔹 Serve from cache immediately
        if (dataListCache[service]) {
            console.log('Serving from cache for service:', service);
            renderDataList(prefix, datalistid, dataListCache[service], version);
            resolve();
            return;
        }
        console.log('Fetching data for service:', service);
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

                    // cache per service
                    dataListCache[service] = result.data;

                    renderDataList(prefix, datalistid, result.data, version);
                    resolve();
                } else {
                    reject('Invalid response');
                }
            },
            error: function (xhr) {
                reject(xhr.responseText);
            }
        });
    });
}

function renderDataList(prefix, datalistid, data, version) {
    let datalist = $("#" + datalistid);
    datalist.empty();

    data.forEach(function (item) {

        if (version === 'v2') {
            datalist.append(
                $("<option>")
                    .attr("value", item.attrVal)
                    .attr("data-value", item.attrVal)
            );
        } else {
            datalist.append(
                $("<option>")
                    .attr(
                        "value",
                        prefix + formatId(item.id) + " - " + item.attrVal
                    )
                    .attr("data-value", item.id)
            );
        }
    });
}


function populateDataListold(prefix, datalistid, service, version) {

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

                    if (version && version === 'v2') {
                        datalist.append(
                            $("<option>")
                                .attr("value", item.attrVal)
                                .attr("data-value", item.attrVal)
                        );

                    } else {
                        datalist.append(
                            $("<option>")
                                .attr("value", prefix + formatId(item.id) + " - " + item.attrVal)
                                .attr("data-value", item.id)
                        );
                    }

                });

            }
        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });

}

function deleteRecord(table, id, key, callback) {
    if (confirm("Are you sure you want to delete this record?")) {

        var fd = new FormData();
        fd.append('service', 'deleteRecord-Service');
        fd.append('table', table);
        fd.append('key', key);
        fd.append('id', id);

        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {
                if (result.success) {
                    promptSuccess('Result', result.message);
                    if (callback) callback();
                } else {

                    promptError('Result', result.message);
                }
            },
            error: function (xhr) {
                console.log(xhr);
                promptError('Failed Result:', "Error: " + xhr.responseText);
            }
        });
    }
}

function compressHtml(html) {
    return html
        .replace(/\s{2,}/g, ' ')
        .replace(/>\s+</g, '><')
        .replace(/\n|\r|\t/g, '')
        .trim();
}