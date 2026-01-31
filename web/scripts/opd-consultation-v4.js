var fields = [
    { ref: "sortBy", defaultValue: "opdcid" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));

populateDataList('', 'patientOptions', 'datalist-patient', 'v1');
populateDataList('', 'physicianOptions', 'datalist-physician', 'v2');
populateDataList('', 'serviceOptions', 'datalist-services', 'v2');
loaddata();
function loaddata() {
    document.getElementById("loaderOverlay").style.display = "flex";
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'opd-consultationService');
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
                    rowdata.conref = "OPDC" + formatId(rowdata.opdcid);
                    rowdata.ages = calculateAge(rowdata.birth_date);
                    rowdata.consultation_datetime = formatDateTime(rowdata.consultation_date);
                    clone.querySelector(".conref").textContent = "OPDC" + formatId(rowdata.opdcid);
                    clone.querySelector(".patientid").textContent = rowdata.patient_no;
                    clone.querySelector(".patientname").textContent = rowdata.fullname;
                    clone.querySelector(".service").textContent = rowdata.service;
                    clone.querySelector(".consultation_date").textContent = rowdata.consultation_date;
                    clone.querySelector(".physician").textContent = rowdata.physician;
                    clone.querySelector(".chiefcomplaint").textContent = rowdata.chief_complaint;
                    clone.querySelector(".updated").textContent = rowdata.updated_at;


                    clone.querySelector(".edit-data-btn").addEventListener("click", function () {



                        document.getElementById("conrefNo").value = "OPDC" + formatId(rowdata.opdcid);
                        document.getElementById("recordid").value = rowdata.opdcid;
                        document.getElementById("consultation_date").value = rowdata.consultation_date;
                        document.getElementById("patientname").value = "P" + formatId(rowdata.pid) + " - " + rowdata.fullname;
                        document.getElementById("pid").value = rowdata.pid
                        document.getElementById("service").value = rowdata.service;
                        document.getElementById("physician").value = rowdata.physician
                        document.getElementById("chief_complaint").value = rowdata.chief_complaint;
                        document.getElementById("bp").value = rowdata.bp;
                        document.getElementById("rr").value = rowdata.rr;
                        document.getElementById("hr").value = rowdata.hr;

                        document.getElementById("weight").value = rowdata.weight;
                        document.getElementById("height").value = rowdata.height;
                        document.getElementById("temp").value = rowdata.temp;
                        document.getElementById("saturation").value = rowdata.saturation;
                        document.getElementById("lmp").value = rowdata.lmp;
                        document.getElementById("allergies").value = rowdata.allergies;

                        document.getElementById("past").value = rowdata.past;

                        document.getElementById("current").value = rowdata.current_medication;
                        document.getElementById("note").value = rowdata.note;

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModal"));
                        modal.show();
                    });
                    clone.querySelector(".print-data-btn").addEventListener("click", function () {
                        // Convert rowdata to a URL-safe string
                        const form = document.createElement("form");
                        form.method = "POST";
                        form.action = "forms/consultation_form.php";
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
    var recordid = document.getElementById("recordid").value;
    var pid = document.getElementById("pid").value;

    if (recordid.trim() == "") {
        var fd = new FormData();
        fd.append('service', 'data-patient');
        fd.append('pid', pid);
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {
                if (result.success && result.data) {

                    result.data.forEach(rowdata => {

                        // document.getElementById("allergies").value = 

                        const data = JSON.parse(rowdata.allergies);
                        let text = "";

                        if (data.none) {
                            text = "None";
                        } else {
                            const parts = [];
                            if (data.drug?.checked) parts.push(`Drug: ${data.drug.specify}`);
                            if (data.food?.checked) parts.push(`Food: ${data.food.specify}`);
                            if (data.others?.checked) parts.push(`Others: ${data.others.specify}`);
                            text = parts.join(", ");
                        }

                        document.getElementById("allergies").value = text;
                    });

                }
            },
            error: function (xhr) {
                promptError('Process Failed', "Error: " + xhr.responseText);
            }

        });




    }
}

function pageRefresh(key) {
    addQueryParam(key);
    loaddata();

}




function UpSertData() {

    var data = {
        conrefNo: document.getElementById("conrefNo").value.trim(),
        recordid: document.getElementById("recordid").value.trim(),
        consultation_date: document.getElementById("consultation_date").value.trim(),
        patientname: document.getElementById("patientname").value.trim(),
        pid: document.getElementById("pid").value.trim(),
        service: document.getElementById("service").value.trim(),
        physician: document.getElementById("physician").value.trim(),
        chief_complaint: document.getElementById("chief_complaint").value.trim(),
        bp: document.getElementById("bp").value.trim(),
        rr: document.getElementById("rr").value.trim(),
        hr: document.getElementById("hr").value.trim(),
        weight: document.getElementById("weight").value.trim(),
        height: document.getElementById("height").value.trim(),
        temp: document.getElementById("temp").value.trim(),
        saturation: document.getElementById("saturation").value.trim(),
        allergies: document.getElementById("allergies").value.trim(),
        past: document.getElementById("past").value.trim(),
        current_medication: document.getElementById("current").value.trim(),
        chief_complaint: document.getElementById("chief_complaint").value.trim(),
        note: document.getElementById("note").value.trim(),
        lmp: document.getElementById("lmp").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "pid", "physician", "consultation_date", "chief_complaint"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'opd-upsertService');
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
    document.getElementById("conrefNo").value = "Auto-generated";
    document.getElementById("recordid").value = "";
    document.getElementById("consultation_date").value = getCurrentDate();
    document.getElementById("patientname").value = "";
    document.getElementById("pid").value = "";
    document.getElementById("service").value = "";
    document.getElementById("physician").value = "";
    document.getElementById("chief_complaint").value = "";
    document.getElementById("bp").value = "";
    document.getElementById("rr").value = "";
    document.getElementById("hr").value = "";
    document.getElementById("bp").value = "";
    document.getElementById("weight").value = "";
    document.getElementById("height").value = "";
    document.getElementById("temp").value = "";
    document.getElementById("saturation").value = "";
    document.getElementById("allergies").value = "";
    document.getElementById("lmp").value = "";

    document.getElementById("past").value = "";
    document.getElementById("current").value = "";
    document.getElementById("note").value = "";

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