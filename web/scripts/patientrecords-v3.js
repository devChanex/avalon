

var fields = [
    { ref: "sortBy", defaultValue: "Fullname" },
    { ref: "sort", defaultValue: "Asc" }
];
fields.forEach(f => populateFieldsFromQuery(f.ref, f.defaultValue));


loadpatient();
function loadpatient() {
    var sortBy = getQueryParam('sortBy');
    var sort = getQueryParam('sort');
    var page = getQueryParam('page');
    var filter = document.getElementById("searchInput").value;


    var fd = new FormData();
    fd.append('service', 'patient-record-listService');
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
                let tbody = document.getElementById("patientTableBody");
                let template = document.getElementById("patientRowTemplate");
                tbody.innerHTML = "";

                result.data.forEach(patient => {
                    let clone = template.content.cloneNode(true);

                    clone.querySelector(".id").textContent = formatId(patient.id);
                    clone.querySelector(".name").textContent = `${patient.first_name} ${patient.middle_name} ${patient.last_name}`;
                    clone.querySelector(".birth_date").textContent = patient.birth_date;
                    clone.querySelector(".gender").textContent = patient.gender;
                    clone.querySelector(".age").textContent = calculateAge(patient.birth_date);
                    clone.querySelector(".contact").textContent = patient.contact_number;
                    clone.querySelector(".email").textContent = patient.email_address;
                    clone.querySelector(".edit-profile-btn").addEventListener("click", function () {

                        document.getElementById("patientId").value = patient.id;
                        document.getElementById("Firstname").value = patient.first_name;
                        document.getElementById("Middlename").value = patient.middle_name;
                        document.getElementById("Lastname").value = patient.last_name;
                        document.getElementById("datepicker").value = formatDateForDatepicker(patient.birth_date);
                        document.getElementById("patientNo").textContent = formatId(patient.id);
                        document.getElementById("BirthPlace").value = patient.birth_place;
                        document.getElementById("Nationality").value = patient.nationality;
                        document.getElementById("Religion").value = patient.religion;
                        document.getElementById("Gender").value = patient.gender;
                        document.getElementById("MaritalStatus").value = patient.marital_status;
                        document.getElementById("PresentAddress").value = patient.present_address;
                        document.getElementById("ContactNumber").value = patient.contact_number;
                        document.getElementById("EmailAddress").value = patient.email_address;
                        document.getElementById("Occupation").value = patient.occupation;
                        document.getElementById("OfficeAddress").value = patient.office_address;
                        document.getElementById("PhilHealthNumber").value = patient.philhealth_number;
                        document.getElementById("AccountType").value = patient.account_type;
                        document.getElementById("PleaseSpecify").value = patient.please_specify;
                        document.getElementById("EmergencyContactPerson").value = patient.emergency_contact_person;
                        document.getElementById("EmergencyContactNumber").value = patient.emergency_contact_number;
                        document.getElementById("Relationship").value = patient.relationship;
                        populateAllergies(patient);
                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("patientModal"));
                        modal.show();
                    });


                    tbody.appendChild(clone);
                });

                renderPagination(result.page, result.total_pages);
            }
        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });


}

function populateAllergies(patient) {
    if (patient.allergies) {
        let allergies = JSON.parse(patient.allergies);

        // None
        document.getElementById("allergyNone").checked = allergies.none || false;

        // Drug
        document.getElementById("allergyDrug").checked = allergies.drug?.checked || false;
        document.getElementById("drugSpecify").value = allergies.drug?.specify || "";

        // Food
        document.getElementById("allergyFood").checked = allergies.food?.checked || false;
        document.getElementById("foodSpecify").value = allergies.food?.specify || "";

        // Others
        document.getElementById("allergyOthers").checked = allergies.others?.checked || false;
        document.getElementById("othersSpecify").value = allergies.others?.specify || "";
    }

    // Current medication
    document.getElementById("currentMedications").value = patient.currentmedication || "";
}

function calculateAge(birthDateStr) {
    let birthDate = new Date(birthDateStr);
    let ageDifMs = Date.now() - birthDate.getTime();
    let ageDate = new Date(ageDifMs);
    return Math.abs(ageDate.getUTCFullYear() - 1970);
}

function pageRefresh(key) {
    addQueryParam(key);
    loadpatient();

}


function UpdateProfile() {

    var data = {
        patientId: document.getElementById("patientId").value,
        firstName: document.getElementById("Firstname").value.trim(),
        middleName: document.getElementById("Middlename").value.trim(),
        lastName: document.getElementById("Lastname").value.trim(),

        birthDate: document.getElementById("datepicker").value.trim(),
        birthPlace: document.getElementById("BirthPlace").value.trim(),
        nationality: document.getElementById("Nationality").value.trim(),

        gender: document.getElementById("Gender").value.trim(),
        maritalStatus: document.getElementById("MaritalStatus").value.trim(),
        religion: document.getElementById("Religion").value.trim(),

        presentAddress: document.getElementById("PresentAddress").value.trim(),
        contactNumber: document.getElementById("ContactNumber").value.trim(),
        emailAddress: document.getElementById("EmailAddress").value.trim(),

        occupation: document.getElementById("Occupation").value.trim(),
        officeAddress: document.getElementById("OfficeAddress").value.trim(),

        philHealthNumber: document.getElementById("PhilHealthNumber").value.trim(),
        accountType: document.getElementById("AccountType").value.trim(),
        pleaseSpecify: document.getElementById("PleaseSpecify").value.trim(),

        emergencyContactPerson: document.getElementById("EmergencyContactPerson").value.trim(),
        emergencyContactNumber: document.getElementById("EmergencyContactNumber").value.trim(),
        relationship: document.getElementById("Relationship").value.trim(),

        isAgree: document.getElementById("isAgree").checked,
        allergies: {
            none: document.getElementById("allergyNone").checked,
            drug: {
                checked: document.getElementById("allergyDrug").checked,
                specify: document.getElementById("drugSpecify").value.trim()
            },
            food: {
                checked: document.getElementById("allergyFood").checked,
                specify: document.getElementById("foodSpecify").value.trim()
            },
            others: {
                checked: document.getElementById("allergyOthers").checked,
                specify: document.getElementById("othersSpecify").value.trim()
            }
        },

        // New field - Current Medications
        currentMedications: document.getElementById("currentMedications").value.trim()
    };

    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "firstName", "lastName", "birthDate", "birthPlace", "nationality",
        "gender", "maritalStatus", "religion", "presentAddress",
        "contactNumber", "emailAddress",
        "emergencyContactPerson", "emergencyContactNumber", "relationship"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Registration Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // If AccountType = HMO or Company -> PleaseSpecify is required
    if ((data.accountType === "HMO" || data.accountType === "Company") && !data.pleaseSpecify) {
        promptError('Registration Failed', 'Please specify the ' + data.accountType + ' name.');
        return;
    }

    // Agreement must be checked
    if (!data.isAgree) {

        promptError('Registration Failed', 'You must confirm that the information provided is correct.');
        return;
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'patient-record-updateService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result.success) {
                promptSuccessReload('Update Successful', 'You will be redirected shortly');
            } else {
                promptError('Registration Failed', result.message);
            }
        },
        error: function (xhr) {
            promptError('Registration Failed', "Error: " + xhr.responseText);
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

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {
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
        loadpatient(); // your function
    }, 300); // wait 300ms after user stops typing
});