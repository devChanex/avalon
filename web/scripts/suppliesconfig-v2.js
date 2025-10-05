

var fields = [
    { ref: "sortBy", defaultValue: "itemname" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));


loaddata();
function loaddata() {
    document.getElementById("loaderOverlay").style.display = "flex";
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'supplies-configService');
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

                    clone.querySelector(".id").textContent = "S" + formatId(rowdata.supid);
                    clone.querySelector(".name").textContent = `${rowdata.itemname}`;
                    clone.querySelector(".description").textContent = rowdata.description;
                    clone.querySelector(".prize").textContent = rowdata.prize;
                    clone.querySelector(".type").textContent = rowdata.type;
                    clone.querySelector(".isConsumable").textContent = (rowdata.isConsumable === "1" || rowdata.isConsumable === 1) ? "Yes" : "No";
                    clone.querySelector(".rsv").textContent = rowdata.rsv;
                    clone.querySelector(".rsv").textContent = rowdata.rsv;
                    clone.querySelector(".qtyOnhand").textContent = rowdata.qty_onhand;
                    clone.querySelector(".remarks").textContent = rowdata.latest_expiry;


                    const rsv = parseFloat(rowdata.rsv) || 0;
                    const qty = parseFloat(rowdata.qty_onhand) || 0;
                    if (rsv > qty) {

                        const rsvCell = clone.querySelector(".qtyOnhand");
                        rsvCell.style.backgroundColor = "red";
                        rsvCell.style.color = "white"; // optional, makes text visible
                        rsvCell.style.fontWeight = "bold";
                    }
                    // Highlight red if within 1 month
                    if (rowdata.latest_expiry && rowdata.latest_expiry !== "0000-00-00") {
                        const expiryDate = new Date(rowdata.latest_expiry);
                        const today = new Date();
                        const diffDays = (expiryDate - today) / (1000 * 60 * 60 * 24);

                        if (diffDays <= 30 && diffDays >= 0) {

                            const rsvCell = clone.querySelector(".remarks");
                            rsvCell.style.backgroundColor = "red";
                            rsvCell.style.color = "white"; // optional, makes text visible
                            rsvCell.style.fontWeight = "bold";

                        }
                    }
                    clone.querySelector(".status").textContent = rowdata.status;
                    clone.querySelector(".created_at").textContent = rowdata.created_at;
                    clone.querySelector(".updated_at").textContent = rowdata.updated_at;

                    clone.querySelector(".edit-data-btn").addEventListener("click", function () {

                        document.getElementById("itemid").textContent = "S" + formatId(rowdata.supid);
                        document.getElementById("recordid").value = rowdata.supid;
                        document.getElementById("itemname").value = rowdata.itemname;
                        document.getElementById("type").value = rowdata.type;
                        document.getElementById("isConsumable").value = rowdata.isConsumable;

                        document.getElementById("description").value = rowdata.description;
                        document.getElementById("status").value = rowdata.status;
                        document.getElementById("prize").value = rowdata.prize;
                        document.getElementById("rsv").value = rowdata.rsv;

                        // populateAllergies(patient);
                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModal"));
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


function UpSertData() {

    var data = {
        supid: document.getElementById("recordid").value,
        itemname: document.getElementById("itemname").value.trim(),
        isConsumable: document.getElementById("isConsumable").value,
        type: document.getElementById("type").value.trim(),
        description: document.getElementById("description").value.trim(),
        prize: document.getElementById("prize").value,
        status: document.getElementById("status").value,
        rsv: document.getElementById("rsv").value
    };

    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "itemname", "prize", "status", "type", "isConsumable"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Update Profile Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'supplies-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result.success) {
                // promptSuccessReload('Update Successful', 'You will be redirected shortly');

                // Bootstrap 4

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
    document.getElementById("recordid").value = "";
    document.getElementById("itemid").innerText = "";
    document.getElementById("itemname").value = "";
    document.getElementById("type").value = "";
    document.getElementById("isConsumable").value = "";
    document.getElementById("rsv").value = 1.00;
    document.getElementById("description").value = "";
    document.getElementById("prize").value = 0.00;
    document.getElementById("status").value = "";

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