

var fields = [
    { ref: "sortBy", defaultValue: "invid" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));

populateDataList('S', 'medicineOptions', 'datalist-supplies');
loaddata();
function loaddata() {
    document.getElementById("loaderOverlay").style.display = "flex";
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'inventory-listService');
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

                    clone.querySelector(".invid").textContent = "INV" + formatId(rowdata.invid);
                    clone.querySelector(".supid").textContent = "S" + formatId(rowdata.supid);
                    clone.querySelector(".itemname").textContent = rowdata.itemname;
                    clone.querySelector(".date_received").textContent = rowdata.date_received;
                    clone.querySelector(".qty_received").textContent = rowdata.qty_received;
                    clone.querySelector(".qty_onhand").textContent = rowdata.qty_onhand;
                    clone.querySelector(".qty_consumed").textContent = rowdata.qty_consumed;
                    clone.querySelector(".qty_dispossed").textContent = rowdata.qty_received - rowdata.qty_onhand - rowdata.qty_consumed;
                    clone.querySelector(".date_expiry").textContent = rowdata.date_expiry;
                    clone.querySelector(".remarks").textContent = rowdata.remarks;
                    clone.querySelector(".updated_at").textContent = rowdata.updated_at;

                    clone.querySelector(".edit-data-btn").addEventListener("click", function () {

                        document.getElementById("itemid").textContent = "INV" + formatId(rowdata.invid);
                        document.getElementById("recordid").value = rowdata.invid;
                        document.getElementById("itemname").value = 'S' + formatId(rowdata.supid) + ' - ' + rowdata.itemname;
                        document.getElementById("qty_received").value = rowdata.qty_received;
                        document.getElementById("date_received").value = rowdata.date_received;
                        document.getElementById("date_expiry").value = rowdata.date_expiry;
                        document.getElementById("invidmodal").value = rowdata.supid;

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModal"));
                        modal.show();
                    });

                    clone.querySelector(".dispose-data-btn").addEventListener("click", function () {

                        document.getElementById("dispossalitemid").textContent = "INV" + formatId(rowdata.invid);
                        document.getElementById("dispossalItemName").textContent = rowdata.itemname;
                        document.getElementById("dispossal_recordid").value = rowdata.invid;
                        document.getElementById("qty_dispossal").value = 0;
                        document.getElementById("dispossal_date").value = "";

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("disposaldataModal"));
                        modal.show();
                    });

                    clone.querySelector(".history-data-btn").addEventListener("click", async function () {

                        document.getElementById("historyitemid").textContent = "INV" + formatId(rowdata.invid);
                        document.getElementById("historyItemName").textContent = rowdata.itemname;
                        document.getElementById("history_recordid").value = rowdata.invid;
                        document.getElementById("qty_dispossal").value = 0;
                        document.getElementById("dispossal_date").value = "";

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("historydataModal"));

                        await historyloaddata();
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
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });




}

function historyloaddata() {

    return new Promise((resolve, reject) => {
        // document.getElementById("loaderOverlay").style.display = "flex";

        var ref = document.getElementById("history_recordid").value;


        var fd = new FormData();
        fd.append('service', 'inventory-historylistService');
        fd.append('ref', ref);

        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {
                if (result.success && result.data) {

                    let tbody = document.getElementById("historydataTableBody");
                    let template = document.getElementById("historydataRowTemplate");
                    tbody.innerHTML = "";
                    console.log(result);
                    result.data.forEach(rowdata => {
                        let clone = template.content.cloneNode(true);

                        clone.querySelector(".invsubid").textContent = "IS" + formatId(rowdata.invsubid);
                        clone.querySelector(".type").textContent = rowdata.type;

                        clone.querySelector(".history_date").textContent = rowdata.transaction_date;
                        clone.querySelector(".history_qty").textContent = rowdata.qty;




                        tbody.appendChild(clone);
                    });

                    resolve(result);
                    // setTimeout(function () {
                    //     document.getElementById("loaderOverlay").style.display = "none";
                    // }, 500); // <-- simulate 2 sec delay
                }
            },
            error: function (xhr) {
                promptError('Process Failed', "Error: " + xhr.responseText);
            }

        });

    });


}


function setSupplyId() {
    var supplyText = document.getElementById("itemname").value;

    let hiddenInput = document.getElementById("invidmodal");
    let options = document.getElementById("medicineOptions").options;

    hiddenInput.value = ""; // clear first

    for (let i = 0; i < options.length; i++) {
        if (options[i].value === supplyText) {
            hiddenInput.value = options[i].dataset.value; // store only code
            break;
        }
    }

}


function calculateAge(birthDateStr) {
    let birthDate = new Date(birthDateStr);
    let ageDifMs = Date.now() - birthDate.getTime();
    let ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function pageRefresh(key) {
    addQueryParam(key);
    loaddata();

}

function itemdisposal() {
    var data = {
        invid: document.getElementById("dispossal_recordid").value.trim(),
        transaction_date: document.getElementById("dispossal_date").value.trim(),
        qty_dispossal: document.getElementById("qty_dispossal").value,

    };

    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "transaction_date", "qty_dispossal"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'inventory-disposalService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: async function (result) {

            if (result.success) {
                promptSuccess('Result', result.message);


                await stockRecompute(data.invid);
                document.querySelector('#disposaldataModal [data-dismiss="modal"]')?.click();
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

function stockRecompute(refid) {
    return new Promise((resolve, reject) => {
        var data = {
            invid: refid,
        };



        // ---------------- FORM DATA ----------------
        var fd = new FormData();
        fd.append('service', 'inventory-stockrecomputeService');
        fd.append('data', JSON.stringify(data));
        $.ajax({
            url: "api.php",
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                if (result.success) {

                    resolve(result);
                } else {
                    promptError('Result', result.message);
                }
            },
            error: function (xhr) {
                promptError('Failed Result:', "Error: " + xhr.responseText);
            }

        });
    });


}
function UpSertData() {

    var data = {
        invid: document.getElementById("recordid").value.trim(),
        supid: document.getElementById("invidmodal").value.trim(),
        qty_received: document.getElementById("qty_received").value.trim(),
        date_received: document.getElementById("date_received").value.trim(),
        date_expiry: document.getElementById("date_expiry").value.trim(),
    };

    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "qty_received", "date_received"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Update Profile Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'inventory-upsertService');
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

function openModal() {
    // Clear inputs
    document.getElementById("itemid").textContent = "New Stock";
    document.getElementById("recordid").value = "";
    document.getElementById("itemname").value = "";
    document.getElementById("qty_received").value = "";
    document.getElementById("date_received").value = "";
    document.getElementById("date_expiry").value = "";
    document.getElementById("invidmodal").value = "";

    // Show modal
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