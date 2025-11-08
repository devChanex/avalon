
loaddata();
loadgeneraldata();
loadgeneraldata_2()
function loadgeneraldata() {

    let ref = document.getElementById("consentpid").value;
    var fd = new FormData();

    fd.append('service', 'patient-record-fetch');
    fd.append('ref', ref);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            // promptSuccess('Process Successful', result.data.fullname);
            if (result.success && result.data) {
                result.data.forEach(rowdata => {
                    document.getElementById("general_fullname").value = rowdata.fullname;
                    document.getElementById("general_pid").value = "P" + formatId(rowdata.id);
                    document.getElementById("general_gender").value = rowdata.gender;
                    document.getElementById("general_birthdate").value = rowdata.birth_date;
                    document.getElementById("general_age").value = calculateAge(rowdata.birth_date);
                    document.getElementById("general_phic_no").value = rowdata.philhealth_number ?? '';

                });

            }
        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });

}

function loadgeneraldata_2() {

    let ref = document.getElementById("ref").value;
    var fd = new FormData();

    fd.append('service', 'ambulatorymain-record-fetch');
    fd.append('ref', ref);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {

            // promptSuccess('Process Successful', result.data.fullname);
            if (result.success && result.data) {
                result.data.forEach(rowdata => {
                    document.getElementById("general_amid").value = "AS" + formatId(rowdata.amid);
                    document.getElementById("general_physician").value = rowdata.physician;
                    document.getElementById("general_procedure").value = rowdata.procedures ?? '';
                    document.getElementById("general_datetime").value = rowdata.surgery_date ?? '';

                });

            }
        },
        error: function (xhr) {
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
function loaddata() {
    document.getElementById("loaderOverlay").style.display = "flex";
    let ref = document.getElementById("ref").value;
    var fd = new FormData();
    fd.append('service', 'ambulatory-viewService');
    fd.append('ref', ref);
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            // promptSuccess('Process Successful', result.data.fullname);
            if (result.success && result.data) {
                result.data.forEach(rowdata => {
                    document.getElementById("consent_fullname").value = rowdata.fullname;
                    document.getElementById("consentid").value = rowdata.acid ?? '';
                    document.getElementById("consentpid").value = rowdata.pid ?? '';
                    document.getElementById("consent_physician").value = rowdata.physician;
                    document.getElementById("consent_nurse").value = rowdata.nurse_in_charge ?? '';
                    document.getElementById("consent_surgery_date").value = rowdata.surgery_date ?? rowdata.procedure_datetime;
                    document.getElementById("consent_procedure").value = rowdata.procedures ?? '';
                    document.getElementById("consent_exception").value = rowdata.exception ?? '';
                });

                result.preop.forEach(rowdata => {
                    document.getElementById("preopid").value = rowdata.preopcheckid ?? '';
                    // 🩺 Clinical Assessment
                    document.getElementById("preop_bp").value = rowdata.BP ?? '';
                    document.getElementById("preop_rr").value = rowdata.RR ?? '';
                    document.getElementById("preop_o2sat").value = rowdata.OSat ?? '';
                    document.getElementById("preop_height").value = rowdata.HT ?? '';
                    document.getElementById("preop_hr").value = rowdata.HR ?? '';
                    document.getElementById("preop_temp").value = rowdata.TEMP ?? '';
                    document.getElementById("preop_lmp").value = rowdata.LMP ?? '';
                    document.getElementById("preop_weight").value = rowdata.WT ?? '';

                    // 🧬 Pre-op Info
                    document.getElementById("preop_allergies").value = rowdata.allergies ?? '';
                    document.getElementById("preop_meal").value = rowdata.last_meal ?? '';
                    document.getElementById("preop_lab").value = rowdata.lab_result ?? '';
                    document.getElementById("preop_dose").value = rowdata.last_dose ?? '';
                    document.getElementById("preop_diagnosis").value = rowdata.diagnosis ?? '';
                });

                result.ambulatorydata.forEach(rowdata => {

                    // IDs & References
                    document.getElementById("amdataid").value = rowdata.amdataid ?? '';

                    // 🩺 Clinical Assessment
                    document.getElementById("tab2_bp").value = rowdata.bp ?? '';
                    document.getElementById("tab2_pr").value = rowdata.pr ?? '';
                    document.getElementById("tab2_temp").value = rowdata.temp ?? '';
                    document.getElementById("tab2_rr").value = rowdata.rr ?? '';
                    document.getElementById("tab2_height").value = rowdata.height ?? '';
                    document.getElementById("tab2_weight").value = rowdata.weight ?? '';
                    document.getElementById("tab2_chiefComplaint").value = rowdata.chief_complaint ?? '';
                    document.getElementById("tab2_arrival").value = rowdata.surgery_date ?? rowdata.arrival;

                    // 😖 Pain Rating
                    document.getElementById("painScaleInput").value = rowdata.pain_rating ?? '';

                    // reset pain buttons visual
                    document.querySelectorAll('.pain-btn').forEach(b => {
                        b.classList.remove('btn-primary');
                        b.classList.add('btn-outline-primary');
                        b.style.color = '#007bff';
                        b.style.backgroundColor = 'transparent';
                    });

                    // highlight selected pain level (if any)
                    if (rowdata.pain_rating) {
                        const btn = document.querySelector(`.pain-btn[data-value="${rowdata.pain_rating}"]`);
                        if (btn) {
                            btn.classList.remove('btn-outline-primary');
                            btn.classList.add('btn-primary');
                            btn.style.backgroundColor = '#007bff';
                            btn.style.color = '#fff';
                        }
                    }

                    // 📋 Medical & Surgical Info
                    document.getElementById("tab2_illness_history").value = rowdata.illness_history ?? '';
                    document.getElementById("tab2_past_medical_history").value = rowdata.past_medical_history ?? '';
                    document.getElementById("tab2_initial_impression").value = rowdata.initial_impression ?? '';
                    document.getElementById("tab2_surgical_plan").value = rowdata.surgical_plan ?? '';
                    document.getElementById("tab2_preop_orders").value = rowdata.preop_orders ?? '';

                    // 💉 Anesthesia Plan (decode JSON string to array)
                    let anesthesia = [];
                    try {
                        anesthesia = typeof rowdata.anesthesia === "string" ? JSON.parse(rowdata.anesthesia) : (rowdata.anesthesia || []);
                    } catch (e) {
                        anesthesia = [];
                    }

                    // Reset anesthesia inputs
                    document.getElementById('anesthesia_local').checked = false;
                    document.getElementById('anesthesia_regional').checked = false;
                    document.getElementById('anesthesia_sedation').checked = false;
                    document.querySelectorAll('input[name="anesthesia_route"]').forEach(r => r.checked = false);

                    // Check matching anesthesia options
                    anesthesia.forEach(item => {
                        if (item === 'local') document.getElementById('anesthesia_local').checked = true;
                        if (item === 'regional') document.getElementById('anesthesia_regional').checked = true;
                        if (item === 'sedation') document.getElementById('anesthesia_sedation').checked = true;
                        if (item === 'oral' || item === 'iv') {
                            const routeInput = document.querySelector(`input[name="anesthesia_route"][value="${item}"]`);
                            if (routeInput) routeInput.checked = true;
                        }
                    });


                    //discharge
                    document.getElementById("discharge_datetime").value = rowdata.discharge_datetime ?? '';
                    document.getElementById("discharge_bp").value = rowdata.discharge_bp ?? '';
                    document.getElementById("discharge_pr").value = rowdata.discharge_pr ?? '';
                    document.getElementById("discharge_osat").value = rowdata.discharge_osat ?? '';
                    document.getElementById("discharge_temp").value = rowdata.discharge_temp ?? '';
                    document.getElementById("discharge_rr").value = rowdata.discharge_rr ?? '';
                    document.getElementById("discharge_nurse").value = rowdata.discharge_nurse ?? '';
                    document.getElementById("discharge_surgeon").value = rowdata.discharge_surgeon ?? '';
                    // discharge condition
                    if (rowdata.discharge_condition) {
                        const conditionInput = document.querySelector(`input[name="condition_of_discharge"][value="${rowdata.discharge_condition}"]`);
                        if (conditionInput) conditionInput.checked = true;
                    }
                    // discharge parameters
                    if (rowdata.discharge_parameter) {
                        const checkedNums = rowdata.discharge_parameter
                            .replace(/[{}]/g, '')     // remove { and }
                            .split(',')               // split by comma
                            .map(num => parseInt(num)) // convert to numbers
                            .filter(num => !isNaN(num)); // remove invalid entries

                        const checkboxes = document.querySelectorAll('.form-check-input-discharge-param');
                        let num = 0;

                        checkboxes.forEach((box) => {
                            num++;
                            if (checkedNums.includes(num)) {
                                box.checked = true;
                            } else {
                                box.checked = false;
                            }
                        });
                    }
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
document.querySelectorAll('.pain-btn').forEach(btn => {
    // apply base inline style
    btn.style.border = '1px solid #007bff';
    btn.style.borderRight = 'none'; // remove right border except last one
    btn.style.backgroundColor = 'transparent';
    btn.style.color = '#007bff';
    btn.style.padding = '10px';
    btn.style.textAlign = 'center';
    btn.style.transition = 'all 0.2s';
    btn.style.cursor = 'pointer';
    btn.style.display = 'flex';
    btn.style.flexDirection = 'column';
    btn.style.justifyContent = 'center';

    btn.addEventListener('click', function () {
        const value = this.getAttribute('data-value');
        document.getElementById('painScaleInput').value = value;

        document.querySelectorAll('.pain-btn').forEach(b => {
            b.style.backgroundColor = 'transparent';
            b.style.color = '#007bff';
        });

        this.style.backgroundColor = '#007bff';
        this.style.color = '#fff';
    });
});

// add right border only on last button
const allBtns = document.querySelectorAll('.pain-btn');
allBtns[allBtns.length - 1].style.borderRight = '1px solid #007bff';

function collectAnesthesiaPlan() {
    const selected = [];

    // collect modalities
    if (document.getElementById('anesthesia_local').checked) selected.push('local');
    if (document.getElementById('anesthesia_regional').checked) selected.push('regional');
    if (document.getElementById('anesthesia_sedation').checked) selected.push('sedation');

    // collect route (if any)
    const route = document.querySelector('input[name="anesthesia_route"]:checked');
    if (route) selected.push(route.value);

    return selected;
}



function UpSertConsentData() {

    var data = {

        consentid: document.getElementById("consentid").value.trim(),
        pid: document.getElementById("consentpid").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        fullname: document.getElementById("consent_fullname").value.trim(),
        physician: document.getElementById("consent_physician").value.trim(),
        nurse_in_charge: document.getElementById("consent_nurse").value.trim(),
        surgery_date: document.getElementById("consent_surgery_date").value.trim(),
        procedures: document.getElementById("consent_procedure").value.trim(),
        exception: document.getElementById("consent_exception").value.trim(),
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "pid", "physician", "surgery_date", "procedures", "nurse_in_charge", "exception"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-consent-upsertService');
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
                loaddata();
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "forms/ambulatory_consent_form.php";
                form.target = "_blank"; // Open in a new tab

                // Create a hidden input to hold the data
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "data";
                input.value = JSON.stringify(result.record);

                // Append input to form
                form.appendChild(input);

                // Append form to body (must be in DOM to submit)
                document.body.appendChild(form);

                // Submit form
                form.submit();

                // Remove form after submission
                document.body.removeChild(form);

            } else {

                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });

}

function UpSertAmbulatoryData() {

    var data = {
        amdataid: document.getElementById("amdataid").value.trim(),
        pid: document.getElementById("consentpid").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        chief_complaint: document.getElementById("tab2_chiefComplaint").value.trim(),
        bp: document.getElementById("tab2_bp").value.trim(),
        pr: document.getElementById("tab2_pr").value.trim(),
        temp: document.getElementById("tab2_temp").value.trim(),
        rr: document.getElementById("tab2_rr").value.trim(),
        height: document.getElementById("tab2_height").value.trim(),
        weight: document.getElementById("tab2_weight").value.trim(),
        pain_rating: document.getElementById("painScaleInput").value.trim(),
        // Additional notes
        illness_history: document.getElementById("tab2_illness_history").value.trim(),
        past_medical_history: document.getElementById("tab2_past_medical_history").value.trim(),
        initial_impression: document.getElementById("tab2_initial_impression").value.trim(),
        surgical_plan: document.getElementById("tab2_surgical_plan").value.trim(),
        anesthesia: collectAnesthesiaPlan(),
        preop_orders: document.getElementById("tab2_preop_orders").value.trim(),
        arrival: document.getElementById("tab2_arrival").value.trim()

    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "chief_complaint"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-data-upsertService');
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
                loaddata();

                const form = document.createElement("form");
                form.method = "POST";
                form.action = "forms/ambulatory_data_form.php";
                form.target = "_blank"; // Open in a new tab

                result.record.fullname = document.getElementById("general_fullname").value;
                result.record.birthDate = document.getElementById("general_birthdate").value;
                result.record.gender = document.getElementById("general_gender").value;
                result.record.age = document.getElementById("general_age").value;
                result.record.physician = document.getElementById("general_physician").value;
                result.record.patientno = document.getElementById("general_pid").value;
                result.record.caseno = document.getElementById("general_amid").value;
                result.record.phic_no = document.getElementById("general_phic_no").value;
                result.record.membertype = result.patient.member_type;
                result.record.birth_place = result.patient.birth_place;
                result.record.religion = result.patient.religion;
                result.record.marital_status = result.patient.marital_status;
                result.record.present_address = result.patient.present_address;
                result.record.office_address = result.patient.office_address;
                result.record.emergency_contact_person = result.patient.emergency_contact_person;
                result.record.emergency_contact_number = result.patient.emergency_contact_number;
                result.record.emergency_relationship = result.patient.relationship;
                result.record.occupation = result.patient.occupation;
                result.record.contact_number = result.patient.contact_number;
                result.record.allergies = result.patient.allergies;
                result.record.currentmedication = result.patient.currentmedication;
                result.record.nationality = result.patient.nationality;




                // Create a hidden input to hold the data
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "data";
                input.value = JSON.stringify(result.record);

                // Append input to form
                form.appendChild(input);

                // Append form to body (must be in DOM to submit)
                document.body.appendChild(form);

                // Submit form
                form.submit();

                // Remove form after submission
                document.body.removeChild(form);

            } else {

                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });

}


function UpSertAmbulatoryDischarge() {
    let discharge_condition_value = "";
    const selected = document.querySelector('input[name="condition_of_discharge"]:checked');

    if (selected) {
        discharge_condition_value = selected.value;
    }
    const checkboxes = document.querySelectorAll('.form-check-input-discharge-param');
    const checkedValues = [];
    var num = 0;
    checkboxes.forEach((box) => {
        num++;
        if (box.checked) {
            checkedValues.push(num); // convert "1" -> 1
        }
    });
    const param = `{${checkedValues.join(',')}}`;
    var data = {
        amdataid: document.getElementById("amdataid").value.trim(),
        pid: document.getElementById("consentpid").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        discharge_datetime: document.getElementById("discharge_datetime").value.trim(),
        discharge_bp: document.getElementById("discharge_bp").value.trim(),
        discharge_pr: document.getElementById("discharge_pr").value.trim(),
        discharge_osat: document.getElementById("discharge_osat").value.trim(),
        discharge_temp: document.getElementById("discharge_temp").value.trim(),
        discharge_rr: document.getElementById("discharge_rr").value.trim(),
        discharge_bp: document.getElementById("discharge_bp").value.trim(),
        discharge_condition: discharge_condition_value,
        discharge_nurse: document.getElementById("discharge_nurse").value.trim(),
        discharge_surgeon: document.getElementById("discharge_surgeon").value.trim(),
        discharge_parameter: param
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "discharge_nurse", "discharge_surgeon", "discharge_condition"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-discharge-upsertService');
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
                loaddata();

                const form = document.createElement("form");
                form.method = "POST";
                form.action = "forms/ambulatory_discharge_form.php";
                form.target = "_blank"; // Open in a new tab

                result.record.caseno = document.getElementById("general_amid").value;




                // Create a hidden input to hold the data
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "data";
                input.value = JSON.stringify(result.record);

                // Append input to form
                form.appendChild(input);

                // Append form to body (must be in DOM to submit)
                document.body.appendChild(form);

                // Submit form
                form.submit();

                // Remove form after submission
                document.body.removeChild(form);

            } else {

                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });

}


function UpSertPreopData() {

    var data = {
        preopcheckid: document.getElementById("preopid").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        BP: document.getElementById("preop_bp").value.trim(),
        RR: document.getElementById("preop_rr").value.trim(),
        OSat: document.getElementById("preop_o2sat").value.trim(),
        HR: document.getElementById("preop_hr").value.trim(),
        TEMP: document.getElementById("preop_temp").value.trim(),
        LMP: document.getElementById("preop_lmp").value.trim(),
        HT: document.getElementById("preop_height").value.trim(),
        WT: document.getElementById("preop_weight").value.trim(),
        allergies: document.getElementById("preop_allergies").value.trim(),
        last_meal: document.getElementById("preop_meal").value.trim(),
        lab_result: document.getElementById("preop_lab").value.trim(),
        last_dose: document.getElementById("preop_dose").value.trim(),
        diagnosis: document.getElementById("preop_diagnosis").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "diagnosis"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-preops-upsertService');
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
                loaddata();
                result.record.fullname = document.getElementById("general_fullname").value;
                result.record.birthDate = document.getElementById("general_birthdate").value;
                result.record.gender = document.getElementById("general_gender").value;
                result.record.age = document.getElementById("general_age").value;

                const form = document.createElement("form");
                form.method = "POST";
                form.action = "forms/ambulatory_preops_checklist_form.php";
                form.target = "_blank"; // Open in a new tab

                // Create a hidden input to hold the data
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "data";
                input.value = JSON.stringify(result.record);

                // Append input to form
                form.appendChild(input);

                // Append form to body (must be in DOM to submit)
                document.body.appendChild(form);

                // Submit form
                form.submit();

                // Remove form after submission
                document.body.removeChild(form);

            } else {

                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });

}

function toggleChecklistDetails(id, iconId) {
    const details = document.getElementById(id);
    const icon = document.getElementById(iconId);

    if (details.style.display === 'none') {
        details.style.display = 'block';
        if (icon) icon.textContent = '▼';
    } else {
        details.style.display = 'none';
        if (icon) icon.textContent = '▶';
    }
}

async function populate_form_data_general() {
    const data = {
        amid: document.getElementById("general_amid").value.trim(),
        pid: document.getElementById("general_pid").value.trim(),
        fullname: document.getElementById("general_fullname").value.trim(),
        gender: document.getElementById("general_gender").value.trim(),
        birthdate: document.getElementById("general_birthdate").value.trim(),
        age: document.getElementById("general_age").value.trim(),
        phic_no: document.getElementById("general_phic_no").value.trim(),
        physician: document.getElementById("general_physician").value.trim(),
        procedure: document.getElementById("general_procedure").value.trim(),
        datetime: document.getElementById("general_datetime").value.trim()
    };

    return data;
}

async function printWHO() {
    const data = await populate_form_data_general();
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_who_form.php";
    form.target = "_blank"; // Open in a new tab

    // Create a hidden input to hold the data
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "data";
    input.value = JSON.stringify(data);

    // Append input to form
    form.appendChild(input);

    // Append form to body (must be in DOM to submit)
    document.body.appendChild(form);

    // Submit form
    form.submit();

    // Remove form after submission
    document.body.removeChild(form);
}
