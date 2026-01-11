

var fields = [
    { ref: "sortBy", defaultValue: "BillDate" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));


loadpatient();
async function loadpatient() {
    document.getElementById("loaderOverlay").style.display = "flex";
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'bill-listService');
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
                let tbody = document.getElementById("billTableBody");
                let template = document.getElementById("billRowTemplate");
                tbody.innerHTML = "";

                result.data.forEach(record => {
                    let clone = template.content.cloneNode(true);
                    let refno = "OPD" + formatId(record.reference_number);

                    if (record.transaction_type === 'AMBULATORY') {
                        refno = "AS" + formatId(record.reference_number);
                    }
                    clone.querySelector(".id").textContent = "AP" + formatId(record.id);
                    clone.querySelector(".billid").textContent = "B" + formatId(record.id);
                    clone.querySelector(".billdate").textContent = record.billdate;
                    clone.querySelector(".name").textContent = `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}  `;
                    clone.querySelector(".ReferenceNo").textContent = refno;
                    clone.querySelector(".transactiontype").textContent = record.transaction_type;
                    clone.querySelector(".physician").textContent = record.physician;
                    clone.querySelector(".total").textContent = record.total_amount;
                    clone.querySelector(".paymentType").textContent = record.payment_type;

                    clone.querySelector(".edit-profile-btn").addEventListener("click", async function () {
                        document.getElementById("opd-billno").value = "B" + formatId(record.id);
                        document.getElementById("opd-recordid").value = record.billingid;
                        document.getElementById("opd-patientId").value = record.pid;
                        document.getElementById("opd-referenceid").value = record.reference_number;
                        document.getElementById("opd-billdate").value = record.billdate;
                        document.getElementById("opd-patient").value = `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}`;
                        document.getElementById("opd-physician").value = record.physician;
                        document.getElementById("opd-transactiontype").value = record.transaction_type;

                        var populate = await populateChargesTable(record.billingid);

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("opd-modal"));
                        modal.show();



                    });


                    tbody.appendChild(clone);
                });


                setTimeout(function () {
                    document.getElementById("loaderOverlay").style.display = "none";
                }, 500); // <-- simulate 2 sec delay
            }
        },
        error: function (xhr) {

            console.log(xhr.responseText);
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });




}

function populateChargesTable(bid) {

    var fd = new FormData();
    fd.append('service', 'charge-listService');
    fd.append('ref', bid);
    return new Promise(resolve => {
        const tableBody = document.getElementById("charges_table_body");
        tableBody.innerHTML = ""; // clear existing rows
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success && result.data) {
                    charges = result.data;

                    // Handle JSON string OR array
                    if (typeof charges === "string") {
                        try {
                            charges = JSON.parse(charges);
                        } catch (e) {
                            console.error("Invalid charges JSON", e);
                            return;
                        }
                    }

                    if (!Array.isArray(charges)) return;

                    charges.forEach(charge => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">✖</button>
            </td>
            <td>
                <input type="text" class="form-control charge-item" value="${charge.item ?? ''}">
            </td>
            <td>
                <input type="number" class="form-control text-end charge-amount" value="${charge.amount ?? 0}">
            </td>
        `;

                        // remove row handler
                        row.querySelector(".remove-row").addEventListener("click", () => {
                            row.remove();
                            calculateChargesTotal();
                        });

                        // recalc total on change
                        row.querySelector(".charge-amount").addEventListener("input", calculateChargesTotal());

                        tableBody.appendChild(row);
                    });
                    calculateChargesTotal();
                    resolve(true);
                }
            },
            error: function (xhr) {

                console.log(xhr.responseText);
                promptError('Process Failed', "Error: " + xhr.responseText);
            }

        });


        calculateChargesTotal();

        resolve(true);
    });



}


function pageRefresh(key) {
    addQueryParam(key);
    loadpatient();

}


async function updateBilling() {

    var data = {
        billdate: document.getElementById("opd-billdate").value,
        physician: document.getElementById("opd-physician").value,
        transaction_type: document.getElementById("opd-transactiontype").value,
        billingid: document.getElementById("opd-recordid").value.trim(),
        pid: document.getElementById("opd-patientId").value.trim(),
        reference_number: document.getElementById("opd-referenceid").value.trim(),
        total_amount: document.getElementById("charges_total").value.trim(),
        charges: await getCharges(),
        payment_type: document.getElementById("opd-paymenttype").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "billdate", "payment_type"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Update Profile Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }





    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'billing-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result.success) {


                promptSuccess('Update Successful', 'Billing has been updated.');
                document.querySelector('#opd-modal [data-dismiss="modal"]')?.click();

                loadpatient();
            } else {
                promptError('Update Profile Failed', result.message);
            }
        },
        error: function (xhr) {
            promptError('Update Profile Failed', "Error: " + xhr.responseText);
        }

    });

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
                loadpatient();
            }
        });
    });
}


let debounceTimer;
document.getElementById("searchInput").addEventListener("input", function () {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        addQueryParamWithValue('page', 1); // reset to page 1 on new search
        loadpatient(); // your function

    }, 300); // wait 300ms after user stops typing
});


//OPD-FUNCTIONS
function addChargeRow() {
    const tableBody = document.getElementById("charges_table_body");

    const row = document.createElement("tr");
    row.innerHTML = `
        <td class="text-center">
            <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="removeChargeRow(this)"
                    title="Remove Row">×</button>
        </td>
        <td>
            <input type="text"
                   class="form-control form-control-sm"
                   placeholder="e.g. Consultation Fee">
        </td>
        <td>
            <input type="number"
                   class="form-control form-control-sm text-end"
                   placeholder="0.00"
                   step="0.01"
                   oninput="calculateChargesTotal()">
        </td>
    `;

    tableBody.appendChild(row);
}

/* Remove a row */
function removeChargeRow(btn) {
    const tableBody = document.getElementById("charges_table_body");

    if (tableBody.rows.length === 1) {
        alert("At least one row is required.");
        return;
    }

    btn.closest("tr").remove();
    calculateChargesTotal();
}

function calculateChargesTotal() {

    const tableBody = document.getElementById("charges_table_body");
    let total = 0;

    tableBody.querySelectorAll("tr").forEach(row => {
        const amountInput = row.querySelector("td:nth-child(3) input");
        const value = parseFloat(amountInput.value);

        if (!isNaN(value)) {
            total += value;
        }
    });

    document.getElementById("charges_total").value = total.toFixed(2);

}
/* Collect table data and log JSON */
function getCharges() {

    return new Promise(resolve => {
        const tableBody = document.getElementById("charges_table_body");
        const data = [];

        tableBody.querySelectorAll("tr").forEach(row => {
            const chargeItem = row.querySelector("td:nth-child(2) input").value.trim();
            const amount = row.querySelector("td:nth-child(3) input").value;

            if (chargeItem !== "" || amount !== "") {
                data.push({
                    charge_item: chargeItem,
                    amount: parseFloat(amount) || 0
                });
            }
        });

        resolve(JSON.stringify(data, null, 2));
    });

}