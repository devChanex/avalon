function memberTypeChange() {
    var memberType = document.getElementById("MemberType").value;

    if (memberType === "P - Lifetime Member" || memberType === "None Member" || memberType === "I - Indigent") {
        document.getElementById("PhilHealthEmployerNumber").value = "N/A";
        document.getElementById("PhilhealthEmployerName").value = "N/A";
    }
}
function register() {

    var data = {
        firstName: document.getElementById("Firstname").value.trim(),
        middleName: document.getElementById("Middlename").value.trim(),
        lastName: document.getElementById("Lastname").value.trim(),
        suffix: document.getElementById("Suffix").value.trim(),

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
        memberType: document.getElementById("MemberType").value.trim(),
        philHealthEmployerNumber: document.getElementById("PhilHealthEmployerNumber").value.trim(),
        philhealthEmployerName: document.getElementById("PhilhealthEmployerName").value.trim(),

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


    // Agreement must be checked
    if (!data.isAgree) {

        promptError('Registration Failed', 'You must confirm that the information provided is correct.');
        return;
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'registerPatientService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            if (result.success) {
                promptSuccessRedirect('Registration Successful', 'You will be redirected shortly', 'index.php');
            } else {
                promptError('Registration Failed', result.message);
            }
        },
        error: function (xhr) {
            promptError('Registration Failed', "Error: " + xhr.responseText);
        }

    });

}