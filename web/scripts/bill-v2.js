

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
                    clone.querySelector(".id").textContent = "AP" + formatId(record.pid);
                    clone.querySelector(".billid").textContent = "B" + formatId(record.billingid);
                    clone.querySelector(".billdate").textContent = record.billdate;
                    clone.querySelector(".name").textContent = `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}  `;
                    clone.querySelector(".ReferenceNo").textContent = refno;
                    clone.querySelector(".transactiontype").textContent = record.transaction_type;
                    clone.querySelector(".physician").textContent = record.physician;
                    clone.querySelector(".total").textContent = record.total_amount;
                    clone.querySelector(".paymentType").textContent = record.payment_type;
                    clone.querySelector(".balance").textContent = record.total_amount ? record.total_amount - record.total_payment : "";

                    clone.querySelector(".edit-profile-btn").addEventListener("click", async function () {
                        document.getElementById("opd-billno").value = "B" + formatId(record.id);
                        document.getElementById("opd-recordid").value = record.billingid;
                        document.getElementById("opd-patientId").value = record.pid;
                        document.getElementById("opd-referenceid").value = record.reference_number;
                        document.getElementById("opd-billdate").value = record.billdate;
                        document.getElementById("opd-patient").value = `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}`;
                        document.getElementById("opd-physician").value = record.physician;
                        document.getElementById("opd-transactiontype").value = record.transaction_type;

                        var populate = await populateChargesTable(record.billingid, record.reference_number);

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("opd-modal"));
                        modal.show();



                    });

                    //payment
                    clone.querySelector(".edit-payment-btn").addEventListener("click", async function () {
                        document.getElementById("payment-billno").value = "B" + formatId(record.id);
                        document.getElementById("payment-recordid").value = record.billingid;
                        document.getElementById("payment-patientId").value = record.pid;
                        document.getElementById("payment-referenceid").value = record.reference_number;
                        document.getElementById("payment-billdate").value = record.billdate;
                        document.getElementById("payment-patient").value = `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}`;
                        document.getElementById("payment-physician").value = record.physician;
                        document.getElementById("payment-transactiontype").value = record.transaction_type;
                        document.getElementById("total-amountDue").value = record.total_amount;

                        // var populate = await populateChargesTable(record.billingid, record.reference_number);
                        var populate = await populatePaymentTable(record.billingid);

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("payment-modal"));
                        modal.show();



                    });
                    clone.querySelector(".edit-print-btn").addEventListener("click", function () {
                        printSoa(
                            record.billingid,
                            record.billdate,
                            record.pid,
                            `${record.last_name} ${record.suffix}, ${record.first_name} ${record.middle_name}`,
                            refno,
                            record.transaction_type,
                            record.physician,
                            record.total_amount,
                            record.payment_type,
                            record.total_amount ? record.total_amount - record.total_payment : "",
                            record.philhealth_number,
                            record.member_type,
                            record.birth_date,
                            record.birth_place,
                            calculateAge(record.birth_date),
                            record.gender

                        );
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

function populateChargesTable(bid, refno) {

    var fd = new FormData();
    fd.append('service', 'charge-listService');
    fd.append('ref', bid);
    fd.append('reference_number', refno);
    fd.append('payment_type', document.getElementById("opd-paymenttype").value);
    return new Promise(resolve => {
        const tableBody = document.getElementById("charges_table_body");
        tableBody.innerHTML = ""; // clear existing rows

        const or_tableBody = document.getElementById("or_charges_table_body");
        or_tableBody.innerHTML = ""; // clear existing rows
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success && (result.other_charges || result.or_charges)) {
                    console.log(result);
                    //OTHER CHARGES
                    charges = result.other_charges
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
                    if (charges.length === 0) {
                        // Add a default empty row if no charges
                        addChargeRow();

                    }
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
                                <input type="number" class="form-control text-end charge-amount" value="${charge.amount ?? 0}" oninput="calculateChargesTotal()" style="text-align:right;">
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
                    //End OTHER CHARGES
                    //OR CHARGES
                    or_charges = result.or_charges
                    // Handle JSON string OR array
                    if (typeof or_charges === "string") {
                        try {
                            or_charges = JSON.parse(or_charges);
                        } catch (e) {
                            console.error("Invalid charges JSON", e);

                        }
                    }

                    if (!Array.isArray(or_charges)) return;
                    if (or_charges.length === 0) {
                        // Add a default empty row if no charges
                        addORChargeRow();


                    }
                    or_charges.forEach(charge => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">✖</button>
                            </td>
                            <td>
                                <input type="text" class="form-control charge-item" value="${charge.item ?? ''}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-end charge-amount" value="${charge.amount ?? 0}" oninput="calculateORChargesTotal()" style="text-align:right;">
                            </td>
                        `;

                        // remove row handler
                        row.querySelector(".remove-row").addEventListener("click", () => {
                            row.remove();
                            calculateORChargesTotal();
                        });

                        // recalc total on change
                        row.querySelector(".charge-amount").addEventListener("input", calculateORChargesTotal());

                        or_tableBody.appendChild(row);
                    });
                    calculateORChargesTotal();

                    resolve(true);
                    return;

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
        orcharges: await getORCharges(),
        or_total_amount: document.getElementById("or_charges_total").value.trim(),
        payment_type: document.getElementById("opd-paymenttype").value.trim(),
        total_amount_due: (parseFloat(document.getElementById("charges_total").value) + parseFloat(document.getElementById("or_charges_total").value)).toFixed(2)
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


//OR Charges
function addORChargeRow() {
    const tableBody = document.getElementById("or_charges_table_body");

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
                   oninput="calculateORChargesTotal()">
        </td>
    `;

    tableBody.appendChild(row);
}



function removeORChargeRow(btn) {
    const tableBody = document.getElementById("or_charges_table_body");

    if (tableBody.rows.length === 1) {
        alert("At least one row is required.");
        return;
    }

    btn.closest("tr").remove();
    calculateChargesTotal();
}


function getORCharges() {

    return new Promise(resolve => {
        const tableBody = document.getElementById("or_charges_table_body");
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

function calculateORChargesTotal() {

    const tableBody = document.getElementById("or_charges_table_body");
    let total = 0;

    tableBody.querySelectorAll("tr").forEach(row => {
        const amountInput = row.querySelector("td:nth-child(3) input");
        const value = parseFloat(amountInput.value);

        if (!isNaN(value)) {
            total += value;
        }
    });

    document.getElementById("or_charges_total").value = total.toFixed(2);

}


function addPaymentRow() {
    const tableBody = document.getElementById("payment_table_body");

    const row = document.createElement("tr");
    row.innerHTML = `
        <td class="text-center">
            <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="removePaymentRow(this)"
                    title="Remove Row">×</button>
        </td>
           <td>
            <input type="number"
                   class="form-control form-control-sm text-end"
                   placeholder="0.00"
                   step="0.01"
                   oninput="calculatePaymentTotal()" style="text-align:right;">
        </td>
         <td>
                                                            <select class="form-control" id="opd-paymenttype">
                                                                <option value="Cash">Cash</option>
                                                                <option value="HMO">HMO</option>
                                                                <option value="PHIC">PhIlhealth</option>
                                                                <option value="PWD/Senior">Bank Transfer</option>
                                                            </select>
                                                        </td>
        <td>
            <input type="date"
                   class="form-control form-control-sm"
                   placeholder="e.g. Consultation Fee">
        </td>
     
        
    `;

    tableBody.appendChild(row);
}


function removePaymentRow(btn) {
    const tableBody = document.getElementById("payment_table_body");

    if (tableBody.rows.length === 1) {
        alert("At least one row is required.");
        return;
    }

    btn.closest("tr").remove();
    calculatePaymentTotal();
}

function getPayments() {

    return new Promise(resolve => {
        const tableBody = document.getElementById("payment_table_body");
        const data = [];

        tableBody.querySelectorAll("tr").forEach(row => {

            const amount = row.querySelector("td:nth-child(2) input").value;
            // const mode = row.querySelector("td:nth-child(3) select").value.trim();
            const selectEl = row.querySelector("td:nth-child(3) select");
            const mode = selectEl.options[selectEl.selectedIndex].text.trim();
            alert(mode);
            const paymentDate = row.querySelector("td:nth-child(4) input").value;

            if (mode !== "" || amount !== "" || paymentDate !== "") {
                data.push({
                    amount: parseFloat(amount) || 0,
                    mode_of_payment: mode,
                    payment_date: paymentDate,
                    bid: document.getElementById("payment-recordid").value.trim(),
                    pid: document.getElementById("payment-patientId").value.trim(),

                });
            }
        });

        resolve(JSON.stringify(data, null, 2));
    });

}

function calculatePaymentTotal() {

    const tableBody = document.getElementById("payment_table_body");
    let total = 0;

    tableBody.querySelectorAll("tr").forEach(row => {
        const amountInput = row.querySelector("td:nth-child(2) input");
        const value = parseFloat(amountInput.value);

        if (!isNaN(value)) {
            total += value;
        }
    });

    document.getElementById("payment_total").value = total.toFixed(2);
    document.getElementById("remaining_balance").value = (parseFloat(document.getElementById("total-amountDue").value) - total).toFixed(2);

    if (parseFloat(document.getElementById("remaining_balance").value) < 0) {
        promptError('Error', 'Payment exceeds total amount due.');
    }

}


async function updatePayment() {

    var data = {
        billingid: document.getElementById("payment-recordid").value.trim(),
        payments: await getPayments(),
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "payments", "billingid"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Update Profile Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }





    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'payment-upsertService');
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
                document.querySelector('#payment-modal [data-dismiss="modal"]')?.click();

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

function populatePaymentTable(bid) {

    var fd = new FormData();
    fd.append('service', 'payment-listService');
    fd.append('ref', bid);
    return new Promise(resolve => {
        const tableBody = document.getElementById("payment_table_body");
        tableBody.innerHTML = ""; // clear existing rows

        const payment_tableBody = document.getElementById("payment_table_body");
        payment_tableBody.innerHTML = ""; // clear existing rows
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success && (result.payments)) {
                    console.log(result.payments);
                    //OTHER CHARGES
                    payments = result.payments
                    // Handle JSON string OR array
                    if (typeof payments === "string") {
                        try {
                            payments = JSON.parse(payments);
                        } catch (e) {
                            console.error("Invalid payment JSON", e);
                            return;
                        }
                    }

                    if (!Array.isArray(payments)) return;
                    if (payments.length === 0) {
                        // Add a default empty row if no charges
                        addPaymentRow();

                    }
                    payments.forEach(payment => {
                        const row = document.createElement("tr");

                        row.innerHTML = `

                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">✖</button>
                            </td>
                            <td>
                                <input type="number" class="form-control text-end payment-amount" value="${payment.amount ?? 0}" oninput="calculatepaymentTotal()" style="text-align:right;">
                            </td>

                             <td>
                                                            <select class="form-control" id="paymenttype">
                                                                 <option value="Cash" ${payment.mode === 'Cash' ? 'selected' : ''}>Cash</option>
                <option value="HMO" ${payment.mode === 'HMO' ? 'selected' : ''}>HMO</option>
                <option value="PHIC" ${payment.mode === 'PHIC' ? 'selected' : ''}>PhilHealth</option>
                <option value="Bank Transfer" ${payment.mode === 'Bank Transfer' ? 'selected' : ''}>Bank Transfer</option>
           
                                                            </select>
                                                        </td>

                              <td>
                                <input type="date-local" class="form-control form-control-sm"
                                    placeholder="e.g. Consultation Fee" value="${payment.payment_date}">
                                                        </td>


                        `;

                        // remove row handler
                        row.querySelector(".remove-row").addEventListener("click", () => {
                            row.remove();
                            calculatePaymentTotal();
                        });

                        // recalc total on change
                        row.querySelector(".payment-amount").addEventListener("input", calculatePaymentTotal());
                        tableBody.appendChild(row);
                    });
                    calculateChargesTotal();
                    //End OTHER CHARGES
                    //OR CHARGES
                    or_charges = result.or_charges
                    // Handle JSON string OR array
                    if (typeof or_charges === "string") {
                        try {
                            or_charges = JSON.parse(or_charges);
                        } catch (e) {
                            console.error("Invalid charges JSON", e);

                        }
                    }

                    if (!Array.isArray(or_charges)) return;
                    if (or_charges.length === 0) {
                        // Add a default empty row if no charges
                        addORChargeRow();


                    }
                    or_charges.forEach(charge => {
                        const row = document.createElement("tr");

                        row.innerHTML = `
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">✖</button>
                            </td>
                            <td>
                                <input type="text" class="form-control charge-item" value="${charge.item ?? ''}">
                            </td>
                            <td>
                                <input type="number" class="form-control text-end charge-amount" value="${charge.amount ?? 0}" oninput="calculateORChargesTotal()" style="text-align:right;">
                            </td>
                        `;

                        // remove row handler
                        row.querySelector(".remove-row").addEventListener("click", () => {
                            row.remove();
                            calculateORChargesTotal();
                        });

                        // recalc total on change
                        row.querySelector(".charge-amount").addEventListener("input", calculateORChargesTotal());

                        or_tableBody.appendChild(row);
                    });
                    calculateORChargesTotal();

                    resolve(true);
                    return;

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


function printSoa(billid, billdate, patientno, patientname, referenceno, transaction_type, physician, total_amount, payment_type, balance, philhealth_number, member_type, birth_date, birth_place, age, gender) {
    var records = {};



    //load payments and charges

    var fd = new FormData();
    fd.append('service', 'bill-detailsService');
    fd.append('ref', billid);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            console.log(result);
            if (result.success) {
                records.billid = "B" + formatId(billid);
                records.billdate = billdate;
                records.patientno = "AP" + formatId(patientno);
                records.referenceno = referenceno;
                records.transaction_type = transaction_type;
                records.patientname = patientname;
                records.total_amount = total_amount;
                records.payment_type = payment_type;
                records.balance = balance;
                records.physician = physician;
                records.philhealth_number = philhealth_number;
                records.member_type = member_type;
                records.birth_date = birth_date;
                records.birth_place = birth_place;
                records.age = age;
                records.gender = gender
                records.payments = result.payments;
                records.or_charges = result.or_charges;
                records.other_charges = result.other_charges;

                const form = document.createElement("form");
                form.method = "POST";
                form.action = "forms/bill_form.php";
                form.target = "_blank"; // Open in a new tab
                // Create a hidden input to hold the data
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "data";
                input.value = JSON.stringify(records);
                // Append input to form
                form.appendChild(input);
                // Append form to body (must be in DOM to submit)
                document.body.appendChild(form);

                // Submit form
                form.submit();
                // Remove form after submission
                document.body.removeChild(form);
            }
        },
        error: function (xhr) {

            console.log(xhr.responseText);
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });




}