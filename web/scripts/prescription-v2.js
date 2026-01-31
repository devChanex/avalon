var fields = [
    { ref: "sortBy", defaultValue: "prescriptid" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));

populateDataList('', 'patientOptions', 'datalist-patient', 'v1');
populateDataList('', 'physicianOptions', 'datalist-physician', 'v2');
loaddata();
function loaddata() {
    document.getElementById("loaderOverlay").style.display = "flex";
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'prescription-listService');
    fd.append('sortBy', sortBy);
    fd.append('sort', sort);
    fd.append('page', page);
    fd.append('filter', filter);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success && result.data) {
                renderPagination(result.page, result.total_pages);
                let tbody = document.getElementById("dataTableBody");
                let template = document.getElementById("dataRowTemplate");
                tbody.innerHTML = "";

                result.data.forEach(rowdata => {
                    let clone = template.content.cloneNode(true);
                    rowdata.ref = "PRS" + formatId(rowdata.prescriptid);
                    rowdata.formatted_prescription_date = formatDateTime(rowdata.prescription_date);
                    rowdata.formatted_next_appointment = formatDateTime(rowdata.next_appointment);
                    rowdata.ages = calculateAge(rowdata.birth_date);
                    clone.querySelector(".prescriptid").textContent = rowdata.ref;
                    clone.querySelector(".patientid").textContent = rowdata.patient_no;
                    clone.querySelector(".patientname").textContent = rowdata.fullname;

                    clone.querySelector(".prescription_date").textContent = rowdata.formatted_prescription_date;
                    clone.querySelector(".physician").textContent = rowdata.physician;
                    clone.querySelector(".next_appointment").textContent = rowdata.formatted_next_appointment;
                    clone.querySelector(".updated").textContent = formatDateTime(rowdata.updated_at);


                    clone.querySelector(".edit-data-btn").addEventListener("click", function () {

                        document.getElementById("prescriptno").value = rowdata.ref;
                        document.getElementById("recordid").value = rowdata.prescriptid;
                        document.getElementById("prescription_date").value = rowdata.prescription_date;
                        document.getElementById("next_appointment").value = rowdata.next_appointment;
                        document.getElementById("patientname").value = rowdata.fullname;
                        document.getElementById("pid").value = rowdata.pid;
                        document.getElementById("physician").value = rowdata.physician
                        document.getElementById("prescription").value = rowdata.prescription;


                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModal"));
                        modal.show();
                    });
                    clone.querySelector(".print-data-btn").addEventListener("click", function () {
                        // Convert rowdata to a URL-safe string
                        const form = document.createElement("form");
                        form.method = "POST";
                        form.action = "forms/prescription_form.php";
                        form.target = "_blank"; // Open in a new tab

                        // Create a hidden input to hold the data
                        const input = document.createElement("input");
                        input.type = "hidden";
                        input.name = "data";
                        input.value = JSON.stringify(rowdata);

                        // Append input to form
                        form.appendChild(input);

                        // Append form to body (must be in DOM to submit)
                        document.body.appendChild(form);

                        // Submit form
                        form.submit();

                        // Remove form after submission
                        document.body.removeChild(form);
                    });

                    tbody.appendChild(clone);
                });


                setTimeout(function () {
                    document.getElementById("loaderOverlay").style.display = "none";
                }, 500); // <-- simulate 2 sec delay
            }
        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });




}

function loadPatientDetails() {
    setDynamicOption('patientOptions', 'patientname', 'pid');

}

function pageRefresh(key) {
    addQueryParam(key);
    loaddata();

}




function UpSertData() {

    var data = {

        recordid: document.getElementById("recordid").value.trim(),
        prescription_date: document.getElementById("prescription_date").value.trim(),
        pid: document.getElementById("pid").value.trim(),
        prescription: document.getElementById("prescription").value.trim(),
        physician: document.getElementById("physician").value.trim(),
        next_appointment: document.getElementById("next_appointment").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "pid", "physician", "prescription", "prescription_date"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'prescription-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                promptSuccess('Result', result.message);
                document.querySelector('#dataModal [data-dismiss="modal"]')?.click();
                loaddata();
            } else {
                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });

}


function clearModal() {
    // Clear inputs
    document.getElementById("prescriptno").value = "Auto-generated";
    document.getElementById("recordid").value = "";
    const now = new Date();
    document.getElementById("prescription_date").value = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
        .toISOString()
        .slice(0, 16);
    // document.getElementById("prescription_date").value = getCurrentDate();

    document.getElementById("next_appointment").value = "";
    document.getElementById("patientname").value = "";
    document.getElementById("pid").value = "";
    document.getElementById("physician").value = "";
    document.getElementById("prescription").value = "";

}
function openModal() {
    clearModal();
    $("#dataModal").modal("show");
}


function renderPagination(currentPage, totalPages) {
    let paginationList = document.getElementById("paginationList");
    paginationList.innerHTML = ""; // clear old pagination

    // First button
    paginationList.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link first" href="#" data-page="1">
                <i class="ik ik-chevrons-left"></i>
            </a>
        </li>
    `;

    // Prev button
    paginationList.innerHTML += `
        <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
            <a class="page-link prev" href="#" data-page="${currentPage - 1}">
                <i class="ik ik-chevron-left"></i>
            </a>
        </li>
    `;

    // --- Page numbers (only show max 4) ---
    let maxVisible = 3;
    let start = Math.max(1, currentPage - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    for (let i = start; i <= end; i++) {
        paginationList.innerHTML += `
            <li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }
    // Next button
    paginationList.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link next" href="#" data-page="${currentPage + 1}">
                <i class="ik ik-chevron-right"></i>
            </a>
        </li>
    `;

    // Last button
    paginationList.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
            <a class="page-link last" href="#" data-page="${totalPages}">
                <i class="ik ik-chevrons-right"></i>
            </a>
        </li>
    `;
    // --- Page info text ---
    let pageInfo = document.getElementById("pageInfo");
    if (pageInfo) {
        pageInfo.textContent = `Showing page ${currentPage} of ${totalPages} pages`;
    }

    // Attach click handlers
    document.querySelectorAll("#paginationList a").forEach(el => {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            const page = parseInt(this.dataset.page);
            if (!isNaN(page) && page >= 1 && page <= totalPages) {
                // update query param
                const url = new URL(window.location.href);
                url.searchParams.set("page", page);
                window.history.pushState({}, "", url);

                // reload table data
                loaddata();
            }
        });
    });
}


let debounceTimer;
document.getElementById("searchInput").addEventListener("input", function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        addQueryParamWithValue('page', 1); // reset to page 1 on new search
        loaddata(); // your function

    }, 300); // wait 300ms after user stops typing
});