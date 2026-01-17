
loaddata();
loadgeneraldata();
loadgeneraldata_2();

loadAllDatalists();
async function loadAllDatalists() {
    try {
        await populateDataList('', 'ms_medication_input_options', 'datalist-medication', 'v2');
        await populateDataList('', 'consent_nurse_options', 'datalist-nurse', 'v2');
        await populateDataList('', 'discharge_nurse_options', 'datalist-nurse', 'v2');
        await populateDataList('', 'discharge_surgeon_options', 'datalist-physician', 'v2');
        await populateDataList('', 'ms_nurse_nurse_input_options', 'datalist-nurse', 'v2');
        await populateDataList('', 'optech_surgeon_input_options', 'datalist-physician', 'v2');
        await populateDataList('', 'optech_assistant_input_options', 'datalist-physician', 'v2');
        await populateDataList('', 'optech_anesthesiologist_input_options', 'datalist-physician', 'v2');
        await populateDataList('', 'optech_scrub_nurse_input_options', 'datalist-nurse', 'v2');
        await populateDataList('', 'optech_circulating_nurse_input_options', 'datalist-nurse', 'v2');

        console.log('All datalists loaded in order');
    } catch (err) {
        promptError('Process Failed', err);
    }
}


let vitalDataCache = null;
let ampoDataCache = null;
let ampnDataCache = null;
let msDataCache = null;
let ms_nurseDataCache = null;
let instrumentDataCache = null;
let instrumentCountDataCache = null;
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
                    document.getElementById("general_birthplace").value = rowdata.birth_place;
                    document.getElementById("general_age").value = calculateAge(rowdata.birth_date);
                    document.getElementById("general_phic_no").value = rowdata.philhealth_number ?? '';
                    document.getElementById("general_member_type").value = rowdata.member_type ?? '';

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
            document.getElementById("discharge_surgeon").value = document.getElementById("general_physician").value;

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
                    document.getElementById("preop_allergies").value = rowdata.allergies ?? 'None';
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

                    document.getElementById("anesthesia_plan").value = rowdata.anesthesia ?? '';

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
                let tbody = document.getElementById("dataTableBody_vital");
                let template = document.getElementById("vital_rowtemplate");
                tbody.innerHTML = "";
                vitalDataCache = result.ambulatoryvital; // cache the latest vital data

                result.ambulatoryvital.forEach(rowdata => {
                    let clone = template.content.cloneNode(true);

                    const dt = new Date(rowdata.vital_datetime);

                    // Get date only (MM/DD/YYYY)
                    const dateOnly = `${(dt.getMonth() + 1).toString().padStart(2, '0')}/` +
                        `${dt.getDate().toString().padStart(2, '0')}/` +
                        `${dt.getFullYear()}`;

                    // Get time only (HH:MM AM/PM)
                    let hours = dt.getHours();
                    const minutes = dt.getMinutes().toString().padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12; // convert 0 -> 12
                    const timeOnly = `${hours}:${minutes} ${ampm}`;
                    clone.querySelector(".vital_date").textContent = dateOnly;
                    clone.querySelector(".vital_time").textContent = timeOnly;
                    clone.querySelector(".vital_bp").textContent = rowdata.bp;
                    clone.querySelector(".vital_rr").textContent = rowdata.rr;
                    clone.querySelector(".vital_pr").textContent = rowdata.pr;
                    clone.querySelector(".vital_osat").textContent = rowdata.osat;

                    clone.querySelector(".vital_temp").textContent = rowdata.temp;
                    clone.querySelector(".vital_remarks").textContent = rowdata.remarks;



                    clone.querySelector(".vital-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("vital_amvid_input").value = rowdata.amvid;

                        document.getElementById("vital_datetime_input").value = rowdata.vital_datetime;
                        document.getElementById("vital_bp_input").value = rowdata.bp;
                        document.getElementById("vital_rr_input").value = rowdata.rr;

                        document.getElementById("vital_pr_input").value = rowdata.pr;

                        document.getElementById("vital_osat_input").value = rowdata.osat;
                        document.getElementById("vital_temp_input").value = rowdata.temp;
                        document.getElementById("vital_remarks_input").value = rowdata.remarks;

                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalVital"));
                        modal.show();
                    });
                    clone.querySelector(".vital-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_vital', rowdata.amvid, 'amvid', loaddata);
                    });

                    tbody.appendChild(clone);
                });

                let tbodyampo = document.getElementById("dataTableBody_ampo");
                let templateampo = document.getElementById("ampo_rowtemplate");
                tbodyampo.innerHTML = "";
                ampoDataCache = result.ambulatoryampo; // cache the latest vital data

                result.ambulatoryampo.forEach(rowdata => {
                    let clone = templateampo.content.cloneNode(true);

                    const dt = new Date(rowdata.ampo_datetime);

                    // Get date only (MM/DD/YYYY)
                    const dateOnly = `${(dt.getMonth() + 1).toString().padStart(2, '0')}/` +
                        `${dt.getDate().toString().padStart(2, '0')}/` +
                        `${dt.getFullYear()}`;

                    // Get time only (HH:MM AM/PM)
                    let hours = dt.getHours();
                    const minutes = dt.getMinutes().toString().padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12; // convert 0 -> 12
                    const timeOnly = `${hours}:${minutes} ${ampm}`;
                    clone.querySelector(".ampo_date").textContent = dateOnly;
                    clone.querySelector(".ampo_time").textContent = timeOnly;
                    clone.querySelector(".ampo_note").textContent = rowdata.ampo_note;
                    clone.querySelector(".ampo_order").textContent = rowdata.ampo_order;



                    clone.querySelector(".ampo-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("ampoid_input").value = rowdata.ampoid;

                        document.getElementById("ampo_datetime_input").value = rowdata.ampo_datetime;
                        document.getElementById("ampo_note_input").value = rowdata.ampo_note;
                        document.getElementById("ampo_order_input").value = rowdata.ampo_order;


                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalAmpo"));
                        modal.show();
                    });
                    clone.querySelector(".ampo-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_progress_order', rowdata.ampoid, 'ampoid', loaddata);
                    });

                    tbodyampo.appendChild(clone);
                });

                let tbodyampn = document.getElementById("dataTableBody_ampn");
                let templateampn = document.getElementById("ampn_rowtemplate");
                tbodyampn.innerHTML = "";
                ampnDataCache = result.ambulatoryampn; // cache the latest vital data

                result.ambulatoryampn.forEach(rowdata => {
                    let clone = templateampn.content.cloneNode(true);

                    const dt = new Date(rowdata.ampn_datetime);

                    // Get date only (MM/DD/YYYY)
                    const dateOnly = `${(dt.getMonth() + 1).toString().padStart(2, '0')}/` +
                        `${dt.getDate().toString().padStart(2, '0')}/` +
                        `${dt.getFullYear()}`;

                    // Get time only (HH:MM AM/PM)
                    let hours = dt.getHours();
                    const minutes = dt.getMinutes().toString().padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12; // convert 0 -> 12
                    const timeOnly = `${hours}:${minutes} ${ampm}`;
                    clone.querySelector(".ampn_date").textContent = dateOnly;
                    clone.querySelector(".ampn_time").textContent = timeOnly;
                    clone.querySelector(".ampn_focus").textContent = rowdata.ampn_focus;
                    clone.querySelector(".ampn_data").textContent = rowdata.ampn_data;



                    clone.querySelector(".ampn-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("ampnid_input").value = rowdata.ampnid;

                        document.getElementById("ampn_datetime_input").value = rowdata.ampn_datetime;
                        document.getElementById("ampn_focus_input").value = rowdata.ampn_focus;
                        document.getElementById("ampn_data_input").value = rowdata.ampn_data;


                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalAmpn"));
                        modal.show();
                    });
                    clone.querySelector(".ampn-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_progress_nurse', rowdata.ampnid, 'ampnid', loaddata);
                    });

                    tbodyampn.appendChild(clone);
                });
                result.ambulatorytechnique.forEach(rowdata => {
                    document.getElementById("amtechid_input").value = rowdata.amtechid ?? '';
                    document.getElementById("ref").value = rowdata.amid ?? '';
                    document.getElementById("optech_datetime_started").value = rowdata.optech_started ?? '';
                    document.getElementById("optech_datetime_ended").value = rowdata.optech_ended ?? '';
                    document.getElementById("optech_preop_diagnosis_input").value = rowdata.optech_preop_diagnosis ?? '';
                    document.getElementById("optech_posop_diagnosis_input").value = rowdata.optech_posop_diagnosis ?? '';
                    document.getElementById("optech_op_procedure_input").value = rowdata.optech_op_procedure ?? '';
                    document.getElementById("optech_narative_input").value = rowdata.optech_narative ?? '';
                    displayImages(rowdata.images ?? '', 'images');
                    document.getElementById("optech_surgeon_input").value = rowdata.optech_surgeon ?? '';
                    document.getElementById("optech_anesthesiologist_input").value = rowdata.optech_anesthesiologist ?? '';
                    document.getElementById("optech_assistant_input").value = rowdata.optech_assistant ?? '';
                    document.getElementById("optech_scrub_nurse_input").value = rowdata.optech_scrub_nurse ?? '';
                    document.getElementById("optech_circulating_nurse_input").value = rowdata.optech_circulating_nurse ?? '';
                    document.getElementById("optech_instrument_count_input").value = rowdata.optech_instrument_count ?? '';
                    document.getElementById("optech_needle_count_input").value = rowdata.optech_needle_count ?? '';
                    document.getElementById("optech_sponge_count_input").value = rowdata.optech_sponge_count ?? '';
                });
                //Medication Sheet
                let tbodyms = document.getElementById("dataTableBody_ms");
                let templatems = document.getElementById("medication_sheet_rowtemplate");
                tbodyms.innerHTML = "";
                msDataCache = result.ambulatorymedicationsheet; // cache the latest vital data

                result.ambulatorymedicationsheet.forEach(rowdata => {
                    let clone = templatems.content.cloneNode(true);

                    const dt = new Date(rowdata.ms_datetime);

                    // Get date only (MM/DD/YYYY)
                    const dateOnly = `${(dt.getMonth() + 1).toString().padStart(2, '0')}/` +
                        `${dt.getDate().toString().padStart(2, '0')}/` +
                        `${dt.getFullYear()}`;

                    // Get time only (HH:MM AM/PM)
                    let hours = dt.getHours();
                    const minutes = dt.getMinutes().toString().padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12; // convert 0 -> 12
                    const timeOnly = `${hours}:${minutes} ${ampm}`;
                    clone.querySelector(".ms_medication").textContent = rowdata.medication;
                    clone.querySelector(".ms_stock_dose").textContent = rowdata.stock_dose;
                    clone.querySelector(".ms_dosage").textContent = rowdata.dosage;
                    clone.querySelector(".ms_route").textContent = rowdata.route;
                    clone.querySelector(".ms_frequency").textContent = rowdata.frequency;

                    clone.querySelector(".ms_date").textContent = dateOnly;
                    clone.querySelector(".ms_time").textContent = timeOnly;


                    clone.querySelector(".ms-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("ms_msid_input").value = rowdata.msid;

                        document.getElementById("ms_datetime_input").value = rowdata.ms_datetime;
                        document.getElementById("ms_medication_input").value = rowdata.medication;
                        document.getElementById("ms_stock_dose_input").value = rowdata.stock_dose;
                        document.getElementById("ms_dosage_input").value = rowdata.dosage;
                        document.getElementById("ms_route_input").value = rowdata.route;
                        document.getElementById("ms_frequency_input").value = rowdata.frequency;



                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalMs"));
                        modal.show();
                    });
                    clone.querySelector(".ms-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_medication_sheet', rowdata.msid, 'msid', loaddata);
                    });

                    tbodyms.appendChild(clone);
                });

                //Medication Sheet Nurse
                let tbodyms_nurse = document.getElementById("dataTableBody_ms_nurse");
                let templatems_nurse = document.getElementById("medication_sheet_nurse_rowtemplate");
                tbodyms_nurse.innerHTML = "";
                ms_nurseDataCache = result.ambulatorymedicationsheetnurse; // cache the latest vital data

                result.ambulatorymedicationsheetnurse.forEach(rowdata => {
                    let clone = templatems_nurse.content.cloneNode(true);

                    const dt = new Date(rowdata.ms_nurse_datetime);

                    // Get date only (MM/DD/YYYY)
                    const dateOnly = `${(dt.getMonth() + 1).toString().padStart(2, '0')}/` +
                        `${dt.getDate().toString().padStart(2, '0')}/` +
                        `${dt.getFullYear()}`;

                    // Get time only (HH:MM AM/PM)
                    let hours = dt.getHours();
                    const minutes = dt.getMinutes().toString().padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12 || 12; // convert 0 -> 12
                    const timeOnly = `${hours}:${minutes} ${ampm}`;
                    clone.querySelector(".ms_nurse_nurse").textContent = rowdata.nurse;
                    clone.querySelector(".ms_nurse_date").textContent = dateOnly;
                    clone.querySelector(".ms_nurse_time").textContent = timeOnly;
                    clone.querySelector(".ms_nurse_remarks").textContent = rowdata.remarks;



                    clone.querySelector(".ms-nurse-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("ms_nurse_msnid_input").value = rowdata.msnid;

                        document.getElementById("ms_nurse_datetime_input").value = rowdata.ms_nurse_datetime;
                        document.getElementById("ms_nurse_nurse_input").value = rowdata.nurse;
                        document.getElementById("ms_nurse_remarks_input").value = rowdata.remarks;



                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalMsNurse"));
                        modal.show();
                    });
                    clone.querySelector(".ms-nurse-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_medication_sheet_nurse', rowdata.msnid, 'msnid', loaddata);
                    });

                    tbodyms_nurse.appendChild(clone);
                });


                //instrument count
                let tbodyinstrument = document.getElementById("dataTableBody_ins");
                let template_instrument = document.getElementById("instrument_rowtemplate");
                tbodyinstrument.innerHTML = "";
                instrumentDataCache = result.ambulatoryinstrumentcount; // cache the latest vital data

                result.ambulatoryinstrumentcount.forEach(rowdata => {
                    let clone = template_instrument.content.cloneNode(true);
                    clone.querySelector(".ins_supid").textContent = rowdata.supid;
                    clone.querySelector(".ins_classification").textContent = rowdata.classification;
                    clone.querySelector(".ins_instument").textContent = rowdata.itemname;
                    const qtyCell = clone.querySelector(".ins_qty");
                    qtyCell.innerHTML = `<input type="text" class="form-control ins_qty_input" value="${rowdata.qty}">`;
                    tbodyinstrument.appendChild(clone);
                });

                let dataTableBody_ICS = document.getElementById("dataTableBody_ICS");
                let ICS_rowtemplate = document.getElementById("ICS_rowtemplate");
                dataTableBody_ICS.innerHTML = "";
                instrumentCountDataCache = result.ambulatoryics; // cache the latest vital data

                result.ambulatoryics.forEach(rowdata => {
                    let clone = ICS_rowtemplate.content.cloneNode(true);
                    clone.querySelector(".ics_baseline").textContent = rowdata.baseline ?? '';
                    clone.querySelector(".ics_instrument").textContent = rowdata.instrument ?? '';
                    clone.querySelector(".ics_initial_counting").textContent = rowdata.initial_counting ?? '';
                    clone.querySelector(".ics_added").textContent = rowdata.added ?? '';
                    clone.querySelector(".ics_removed").textContent = rowdata.removed ?? '';
                    clone.querySelector(".ics_final_count").textContent = rowdata.final_count ?? '';
                    clone.querySelector(".ics_remarks").textContent = rowdata.remarks ?? '';


                    clone.querySelector(".ics-edit-data-btn").addEventListener("click", function () {

                        document.getElementById("ics_icsid_input").value = rowdata.icsid ?? '';
                        document.getElementById("ics_instrument_input").value = rowdata.instrument ?? '';
                        document.getElementById("ics_baseline_input").value = rowdata.baseline ?? '';
                        document.getElementById("ics_initial_counting_input").value = rowdata.initial_counting ?? '';
                        document.getElementById("ics_added_input").value = rowdata.added ?? '';
                        document.getElementById("ics_removed_input").value = rowdata.removed ?? '';
                        document.getElementById("ics_final_count_input").value = rowdata.final_count ?? '';
                        document.getElementById("ics_remarks_input").value = rowdata.remarks ?? '';
                        // Show modal (Bootstrap 5 way)
                        var modal = new bootstrap.Modal(document.getElementById("dataModalICS"));
                        modal.show();
                    });
                    clone.querySelector(".ics-delete-data-btn").addEventListener("click", function () {
                        deleteRecord('ambulatory_instrument_count', rowdata.icsid, 'icsid', loaddata);
                    });

                    dataTableBody_ICS.appendChild(clone);
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

function displayImages(imagesJson) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    if (!imagesJson) return;

    let images;
    try {
        images = JSON.parse(imagesJson);
    } catch (e) {
        console.error('Invalid images JSON', e);
        return;
    }

    images.forEach((imgObj, index) => {
        const container = document.createElement('div');
        container.className = 'image-item';
        container.style.display = 'inline-block';
        container.style.margin = '5px';
        container.style.border = '1px solid #ccc';
        container.style.padding = '5px';
        container.style.position = 'relative';
        container.dataset.index = index;

        const img = document.createElement('img');
        img.src = imgObj.src;
        img.style.width = '96px';   // 1 inch
        img.style.height = '96px';
        img.style.display = 'block';

        const caption = document.createElement('input');
        caption.type = 'text';
        caption.value = imgObj.caption || '';
        caption.placeholder = 'Caption';
        caption.style.width = '100%';

        // 🔴 REMOVE BUTTON
        const removeBtn = document.createElement('button');
        removeBtn.textContent = '✖';
        removeBtn.style.position = 'absolute';
        removeBtn.style.top = '2px';
        removeBtn.style.right = '2px';
        removeBtn.style.background = 'red';
        removeBtn.style.color = 'white';
        removeBtn.style.border = 'none';
        removeBtn.style.cursor = 'pointer';
        removeBtn.style.fontSize = '12px';

        removeBtn.onclick = () => container.remove();

        container.appendChild(removeBtn);
        container.appendChild(img);
        container.appendChild(caption);
        preview.appendChild(container);
    });
}



function computeFinalCount() {
    const initialCounting = parseInt(document.getElementById("ics_initial_counting_input").value) || 0;
    const added = parseInt(document.getElementById("ics_added_input").value) || 0;
    const removed = parseInt(document.getElementById("ics_removed_input").value) || 0;
    const finalCount = initialCounting + added - removed;
    document.getElementById("ics_final_count_input").value = finalCount;

}
function saveAllInstruments() {
    const rows = document.querySelectorAll("#dataTableBody_ins tr"); // get all rows
    const allData = [];

    rows.forEach(row => {
        const supid = row.querySelector(".ins_supid").textContent;
        const classification = row.querySelector(".ins_classification").textContent;
        const instrument = row.querySelector(".ins_instument").textContent;
        const qtyInput = row.querySelector(".ins_qty_input");
        const qty = qtyInput ? qtyInput.value : ""; // safe check

        allData.push({
            supid: supid,
            classification: classification,
            instrument: instrument,
            qty: qty
        });
    });

    var data = {
        amid: document.getElementById("ref").value.trim(),
        instrumentList: allData
    };

    console.log('Data to be sent:', data);
    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "instrumentList", "amid"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-instument-count-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            console.log(result);
            if (result.success) {

                promptSuccess('Result', result.message);
                loaddata();


            } else {

                promptError('Result', result.message);
            }
        },
        error: function (xhr) {
            console.log('Failed Result:', "Error: " + xhr.responseText);
            promptError('Failed Result:', "Error: " + xhr.responseText);
        }

    });


}

function openModalVital() {
    clearModalVital();
    $("#dataModalVital").modal("show");
}


function openModalics() {
    clearModalVital();
    $("#dataModalICS").modal("show");
}
function openModalMS() {
    clearModalMS();
    $("#dataModalMs").modal("show");
}
function openModalMSNurse() {
    clearModalMSNurse();
    $("#dataModalMsNurse").modal("show");
}
function clearModalMSNurse() {
    document.getElementById("ms_nurse_msnid_input").value = "";
    document.getElementById("ms_nurse_datetime_input").value = "";
    document.getElementById("ms_nurse_nurse_input").value = "";
    document.getElementById("ms_nurse_remarks_input").value = "";
}

function clearModalMS() {
    document.getElementById("ms_msid_input").value = "";
    document.getElementById("ms_medication_input").value = "";
    document.getElementById("ms_stock_dose_input").value = "";
    document.getElementById("ms_dosage_input").value = "";
    document.getElementById("ms_route_input").value = "";
    document.getElementById("ms_frequency_input").value = "";
    document.getElementById("ms_datetime_input").value = "";
}
function clearModalVital() {
    document.getElementById("vital_amvid_input").value = "";
    document.getElementById("vital_datetime_input").value = "";
    document.getElementById("vital_bp_input").value = "";
    document.getElementById("vital_rr_input").value = "";
    document.getElementById("vital_pr_input").value = "";
    document.getElementById("vital_osat_input").value = "";
    document.getElementById("vital_temp_input").value = "";
    document.getElementById("vital_remarks_input").value = "";

}

function openModalAmpo() {
    clearModalAmpo();
    $("#dataModalAmpo").modal("show");
}

function clearModalAmpo() {
    document.getElementById("ampoid_input").value = "";
    document.getElementById("ampo_datetime_input").value = "";
    document.getElementById("ampo_note_input").value = "";
    document.getElementById("ampo_order_input").value = "";
}

function openModalAmpn() {
    clearModalAmpn();
    $("#dataModalAmpn").modal("show");
}

function clearModalAmpn() {
    document.getElementById("ampnid_input").value = "";
    document.getElementById("ampn_datetime_input").value = "";
    document.getElementById("ampn_focus_input").value = "";
    document.getElementById("ampn_data_input").value = "";
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
        anesthesia: document.getElementById("anesthesia_plan").value.trim(),
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
                result.record.birthdate = document.getElementById("general_birthdate").value;
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

function printVitalSheet() {
    var records = {};
    records.vitalSigns = vitalDataCache;
    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.member_type = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_vitalsigns_form.php";
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

function printInstrumentCountSheet() {
    var records = {};
    records.instrumentcount = instrumentCountDataCache;
    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.membertype = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    // console.log(JSON.stringify(records));
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_instrument_count_form.php";
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



function printORCharges() {
    var records = {};
    records.orcharges = instrumentDataCache;
    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.membertype = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_or_charges_form.php";
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
function printMedicationSheet() {
    var records = {};
    records.medication = msDataCache;
    records.nurse_medication = ms_nurseDataCache;
    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.member_type = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_medication_sheet_form.php";
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
function UpSertVitalData() {

    var data = {
        amvid: document.getElementById("vital_amvid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        vital_datetime: document.getElementById("vital_datetime_input").value.trim(),
        bp: document.getElementById("vital_bp_input").value.trim(),
        rr: document.getElementById("vital_rr_input").value.trim(),
        pr: document.getElementById("vital_pr_input").value.trim(),
        osat: document.getElementById("vital_osat_input").value.trim(),
        temp: document.getElementById("vital_temp_input").value.trim(),
        remarks: document.getElementById("vital_remarks_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "vital_datetime"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-vital-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalVital').modal('hide');

                promptSuccess('Result', result.message);
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


function UpSertInstrumentCountdata() {

    var data = {
        icsid: document.getElementById("ics_icsid_input").value.trim(),
        instrument: document.getElementById("ics_instrument_input").value.trim(),
        baseline: document.getElementById("ics_baseline_input").value.trim(),
        initial_counting: document.getElementById("ics_initial_counting_input").value.trim(),
        added: document.getElementById("ics_added_input").value.trim(),
        removed: document.getElementById("ics_removed_input").value.trim(),
        final_count: document.getElementById("ics_final_count_input").value.trim(),
        remarks: document.getElementById("ics_remarks_input").value.trim(),
        amid: document.getElementById("ref").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "instrument"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-ics-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalICS').modal('hide');

                promptSuccess('Result', result.message);
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
function UpSertAmpoData() {

    var data = {
        ampoid: document.getElementById("ampoid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        ampo_datetime: document.getElementById("ampo_datetime_input").value.trim(),
        ampo_note: document.getElementById("ampo_note_input").value.trim(),
        ampo_order: document.getElementById("ampo_order_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "ampo_datetime"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-ampo-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalAmpo').modal('hide');

                promptSuccess('Result', result.message);
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


function UpSertAmpnData() {

    var data = {
        ampnid: document.getElementById("ampnid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        ampn_datetime: document.getElementById("ampn_datetime_input").value.trim(),
        ampn_focus: document.getElementById("ampn_focus_input").value.trim(),
        ampn_data: document.getElementById("ampn_data_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "ampn_datetime"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-ampn-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalAmpn').modal('hide');

                promptSuccess('Result', result.message);
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

function UpSertMSData() {

    var data = {
        msid: document.getElementById("ms_msid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        ms_datetime: document.getElementById("ms_datetime_input").value.trim(),
        medication: document.getElementById("ms_medication_input").value.trim(),
        stock_dose: document.getElementById("ms_stock_dose_input").value.trim(),
        dosage: document.getElementById("ms_dosage_input").value.trim(),
        route: document.getElementById("ms_route_input").value.trim(),
        frequency: document.getElementById("ms_frequency_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "medication"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-ms-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalMs').modal('hide');

                promptSuccess('Result', result.message);
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

function UpSertMSNurseData() {

    var data = {
        msnid: document.getElementById("ms_nurse_msnid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        ms_nurse_datetime: document.getElementById("ms_nurse_datetime_input").value.trim(),
        nurse: document.getElementById("ms_nurse_nurse_input").value.trim(),
        remarks: document.getElementById("ms_nurse_remarks_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "amid", "remarks"
    ];
    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }
    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-ms-nurse-upsertService');
    fd.append('data', JSON.stringify(data));
    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            if (result.success) {
                $('#dataModalMsNurse').modal('hide');

                promptSuccess('Result', result.message);
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

function printAmpnSheet() {
    var records = {};
    records.ampn = ampnDataCache;
    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.membertype = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_ampn_form.php";
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

function printAmpoSheet() {
    var records = {};
    records.ampo = ampoDataCache;

    records.fullname = document.getElementById("general_fullname").value;
    records.birthdate = document.getElementById("general_birthdate").value;
    records.birth_place = document.getElementById("general_birthplace").value;
    records.gender = document.getElementById("general_gender").value;
    records.age = document.getElementById("general_age").value;
    records.physician = document.getElementById("general_physician").value;
    records.patientno = document.getElementById("general_pid").value;
    records.caseno = document.getElementById("general_amid").value;
    records.phic_no = document.getElementById("general_phic_no").value;
    records.member_type = document.getElementById("general_member_type").value;
    records.arrival = document.getElementById("tab2_arrival").value;
    // console.log(JSON.stringify(records));
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "forms/ambulatory_ampo_form.php";
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

// Operative Technique Form
function UpSertOperativeTechnique() {

    var data = {
        amtechid: document.getElementById("amtechid_input").value.trim(),
        amid: document.getElementById("ref").value.trim(),
        optech_started: document.getElementById("optech_datetime_started").value.trim(),
        optech_ended: document.getElementById("optech_datetime_ended").value.trim(),
        optech_preop_diagnosis: document.getElementById("optech_preop_diagnosis_input").value.trim(),
        optech_posop_diagnosis: document.getElementById("optech_posop_diagnosis_input").value.trim(),
        optech_op_procedure: document.getElementById("optech_op_procedure_input").value.trim(),
        optech_narative: document.getElementById("optech_narative_input").value.trim(),
        images: JSON.stringify(getImagesWithCaptions()),
        optech_surgeon: document.getElementById("optech_surgeon_input").value.trim(),
        optech_anesthesiologist: document.getElementById("optech_anesthesiologist_input").value.trim(),
        optech_assistant: document.getElementById("optech_assistant_input").value.trim(),
        optech_scrub_nurse: document.getElementById("optech_scrub_nurse_input").value.trim(),
        optech_circulating_nurse: document.getElementById("optech_circulating_nurse_input").value.trim(),
        optech_instrument_count: document.getElementById("optech_instrument_count_input").value.trim(),
        optech_needle_count: document.getElementById("optech_needle_count_input").value.trim(),
        optech_sponge_count: document.getElementById("optech_sponge_count_input").value.trim()
    };


    // ---------------- VALIDATIONS ----------------

    // Required fields (all except philHealthNumber, accountType, pleaseSpecify)
    let requiredFields = [
        "optech_started", "optech_preop_diagnosis"
    ];

    for (let field of requiredFields) {
        if (!data[field]) {
            promptError('Transaction Failed', field.toUpperCase() + ' is required.');
            return;
        }
    }

    // ---------------- FORM DATA ----------------
    var fd = new FormData();
    fd.append('service', 'ambulatory-optech-upsertService');
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
                form.action = "forms/ambulatory_technique_form.php";
                form.target = "_blank"; // Open in a new tab

                result.record.caseno = document.getElementById("general_amid").value;

                result.record.patientno = document.getElementById("general_pid").value;
                result.record.fullname = document.getElementById("general_fullname").value;
                result.record.birth_date = document.getElementById("general_birthdate").value;
                result.record.birth_place = document.getElementById("general_birthplace").value;
                result.record.gender = document.getElementById("general_gender").value;
                result.record.age = document.getElementById("general_age").value;
                result.record.phic_no = document.getElementById("general_phic_no").value;
                result.record.member_type = document.getElementById("general_member_type").value;

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
const uploadBtn = document.getElementById('upload-btn');
const fileInput = document.getElementById('file-input');
const preview = document.getElementById('image-preview');

// Click the button → open file picker
uploadBtn.addEventListener('click', () => fileInput.click());

// Handle file selection
fileInput.addEventListener('change', e => {
    for (const file of e.target.files) {
        addImagePreview(file);
    }
});

// Handle pasted images (still works)
document.addEventListener('paste', e => {
    const items = e.clipboardData.items;
    for (const item of items) {
        if (item.type.indexOf('image') !== -1) {
            const file = item.getAsFile();
            addImagePreview(file);
        }
    }
});

// Resize image to 1 inch (96px) + preview
function addImagePreview(file) {
    const reader = new FileReader();
    reader.onload = function (e) {
        const img = new Image();
        img.onload = function () {
            const canvas = document.createElement('canvas');
            canvas.width = 96;  // 1 inch
            canvas.height = 96; // 1 inch
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, 96, 96);
            const resizedBase64 = canvas.toDataURL('image/png');

            const container = document.createElement('div');
            container.style.marginBottom = '10px';
            container.style.border = '1px solid #ccc';
            container.style.padding = '5px';
            container.style.display = 'inline-block';
            container.style.textAlign = 'center';
            container.style.position = 'relative';

            const previewImg = document.createElement('img');
            previewImg.src = resizedBase64;
            previewImg.style.width = '96px';
            previewImg.style.height = '96px';
            previewImg.style.display = 'block';
            previewImg.style.marginBottom = '5px';

            const caption = document.createElement('input');
            caption.type = 'text';
            caption.placeholder = 'Enter caption';
            caption.style.width = '100%';

            const removeBtn = document.createElement('button');
            removeBtn.textContent = '✖';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '2px';
            removeBtn.style.right = '2px';
            removeBtn.style.background = 'red';
            removeBtn.style.color = 'white';
            removeBtn.style.border = 'none';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.fontSize = '10px';
            removeBtn.addEventListener('click', () => container.remove());

            container.appendChild(previewImg);
            container.appendChild(caption);
            container.appendChild(removeBtn);
            preview.appendChild(container);
        }
        img.src = e.target.result;
    }
    reader.readAsDataURL(file);
}

// Collect images + captions
function getImagesWithCaptions() {
    const result = [];
    preview.querySelectorAll('div').forEach(div => {
        const img = div.querySelector('img');
        const caption = div.querySelector('input').value;
        result.push({
            src: img.src,
            caption: caption
        });
    });
    return result;
}

// Example save
document.getElementById('saveBtn').addEventListener('click', () => {
    const text = document.getElementById('notes').value;
    const images = getImagesWithCaptions();
    const jsonData = JSON.stringify({ text: text, images: images });

    console.log('Data to save:', jsonData);
    // Send jsonData to your server via AJAX or form submission
});