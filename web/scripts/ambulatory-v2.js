var fields = [
    { ref: "sortBy", defaultValue: "amid" },
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
    fd.append('service', 'ambulatory-listService');
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
                    rowdata.conref = "AS" + formatId(rowdata.opdcid);
                    rowdata.ages = calculateAge(rowdata.birth_date);
                    rowdata.consultation_datetime = formatDateTime(rowdata.consultation_date);
                    clone.querySelector(".conref").textContent = "AS" + formatId(rowdata.amid);
                    clone.querySelector(".patientid").textContent = rowdata.patient_no;
                    clone.querySelector(".patientname").textContent = rowdata.fullname;
                    clone.querySelector(".procedures").textContent = rowdata.procedures;
                    clone.querySelector(".surgery_date").textContent = rowdata.surgery_date;
                    clone.querySelector(".physician").textContent = rowdata.physician;

                    clone.querySelector(".updated").textContent = rowdata.updated_at;


                    clone.querySelector(".edit-data-btn").addEventListener("click", function () {
                        document.getElementById("ambrefNo").value = "AS" + formatId(rowdata.amid);
                        document.getElementById("recordid").value = rowdata.amid;
                        document.getElementById("surgery_date").value = rowdata.surgery_date;
                        document.getElementById("patientname").value = "P" + formatId(rowdata.pid) + " - " + rowdata.fullname;
                        document.getElementById("pid").value = rowdata.pid;
                        document.getElementById("procedures").value = rowdata.procedures;
                        document.getElementById("physician").value = rowdata.physician;
                        var modal = new bootstrap.Modal(document.getElementById("dataModal"));
                        modal.show();
                    });
                    clone.querySelector(".view-data-btn").addEventListener("click", function () {
                        window.location.href = "ambulatory-surgery-view.php?ref=" + rowdata.amid + "&pid=" + rowdata.pid;
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

        // document.getElementById("ambrefNo").value = "AS" + formatId(rowdata.amid);
        // document.getElementById("recordid").value = rowdata.amid;
        // document.getElementById("surgery_date").value = rowdata.surgery_date;
        // document.getElementById("patientname").value = rowdata.fullname;
        // document.getElementById("pid").value = rowdata.pid;
        // document.getElementById("procedures").value = rowdata.procedures;
        // document.getElementById("physician").value = rowdata.physician;
        ambrefNo: document.getElementById("ambrefNo").value.trim(),
        amid: document.getElementById("recordid").value.trim(),
        surgery_date: document.getElementById("surgery_date").value.trim(),
        patientname: document.getElementById("patientname").value.trim(),
        pid: document.getElementById("pid").value.trim(),
        procedures: document.getElementById("procedures").value.trim(),
        physician: document.getElementById("physician").value.trim(),

    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "pid", "physician", "surgery_date", "procedures"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-upsertService');
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
    document.getElementById("ambrefNo").value = "Auto-generated";
    document.getElementById("recordid").value = "";
    document.getElementById("surgery_date").value = getCurrentDate();
    document.getElementById("patientname").value = "";
    document.getElementById("pid").value = "";
    document.getElementById("procedures").value = "";
    document.getElementById("physician").value = "";


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