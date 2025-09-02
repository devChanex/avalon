function register() {

    var data = {
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

        isAgree: document.getElementById("isAgree").checked
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