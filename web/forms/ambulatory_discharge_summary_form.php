<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consultation Record</title>
    <link rel="stylesheet" href="../ccss/forms.css">
</head>

<body>

    <header>
        <img src="../img/logo/logo.png" alt="Clinic Logo">
        <div class="clinic-info">
            <h1>Avalon Wound Care Center</h1>
            <p>4th Flr. Tri-Ax Three Center, 35 Manila S. Rd., Brgy. San Antonio, Binan, Laguna </p>
            <p>avalonwouldcare2024@gmail.com | +63 921 496 7592</p>
        </div>
    </header>
    <h2 class="form-title-long-nomargin">Discharge Summary</h2>
    <div class="section">
        <table style="border: none; width: 100%; border-collapse: collapse;">

            <tr>
                <td>Patient Name: <span id="fullname"></span> </td>
                <td>Case Number: <span id="caseno"></span> </td>
            </tr>
            <tr>
                <td>Birthdate: <span id="birthdate"></span> </td>
                <td>Age / Gender: <span id="age"></span> / <span id="gender"></span> </td>
            </tr>
            <tr>
                <td>Procedure Date: <span id="procedure_datetime"></span> </td>
                <td>Discharge Date: <span id="discharge_datetime"></span> </td>
            </tr>

            <tr>
                <td>Attending Physician: <span id="physician"></span> </td>
            </tr>

            <tr>
                <td colspan="2">
                    <hr>
                </td>
            </tr>





        </table>
        <strong>Reason of Procedure:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="reason_procedure"></span></p>

        <strong>History of Present Illness:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="history_present_illness"></span></p>

        <strong>Type of Procedure:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="type_of_procedure"></span></p>

        <strong>Ambulatory Surgical Clinic Course:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="ambulatory_surgical_clinic_course"></span></p>

        <strong>Discharge Vital Signs</strong><br>
        <p style="margin-top: 0px;padding-top:0px;">
            <strong>BP: </strong>
            <span id="discharge_bp"></span>
            <strong>HR: </strong>
            <u><span id="discharge_hr"></span></u>
            <strong>RR: </strong>
            <u><span id="discharge_rr"></span></u>
            <strong>TEMP: </strong>
            <u><span id="discharge_temp"></span></u>
            <strong>O2 Sat: </strong>
            <u><span id="discharge_o2_sat"></span></u>
        </p>

        <strong>Condition at Discharge:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_condition"></span></p>

        <strong>Medication on Discharge:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_medication"></span></p>

        <strong>Allergies:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_allergies"></span></p>

        <strong>Follow-up care:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_followup"></span></p>

        <strong>Diet:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_diet"></span></p>

        <strong>Activity:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_activity"></span></p>
        <br>
        <br>
        <strong>DISCHARGE PHYSICIAN:</strong><br>
        <p style="margin-top: 0px;padding-top:0px;"><span id="discharge_physician"></span></p>

    </div>




    <div class="text-center no-print" style="text-align:center; margin-top:40px;">
        <button onclick="window.print()" style="padding:8px 18px; font-size:14pt;">🖨️ Print</button>
        <button onclick="window.close()" style="padding:8px 18px; font-size:14pt;">Close</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            try {
                // PHP echoes the POSTed data into JS
                const data = <?php echo json_encode($_POST['data'] ?? '{}'); ?>;
                const row = JSON.parse(data);
                console.log(data);
                for (const key in row) {
                    // alert(key);
                    const el = document.getElementById(key);
                    if (!el) continue;

                    let value = row[key] ?? "N/A";

                    // ✅ Format the datetime nicely if key is 'procedure_datetime'
                    if ((key === "discharge_datetime" || key === "procedure_datetime") && value) {
                        const dt = new Date(value);
                        if (!isNaN(dt)) {
                            const month = String(dt.getMonth() + 1).padStart(2, '0');
                            const day = String(dt.getDate()).padStart(2, '0');
                            const year = dt.getFullYear();

                            let hours = dt.getHours();
                            const minutes = String(dt.getMinutes()).padStart(2, '0');
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12; // Convert 0 -> 12 for 12-hour clock

                            value = `${month}-${day}-${year}`;
                        }
                    }
                    if (key === "physician") {
                        document.getElementById("physician").textContent = value;
                    }

                    if (key === "discharge_condition") {
                        const elCondition = document.getElementById("discharge_condition");
                        if (elCondition) {
                            const normalizedValue = String(value ?? '').replace(/\s+/g, ' ').trim();
                            elCondition.textContent = normalizedValue || 'N/A';
                        }
                        continue;
                    }

                    if (row.discharge_parameter) {
                        const checkedNums = row.discharge_parameter
                            .replace(/[{}]/g, '') // remove braces { }
                            .split(',')
                            .map(num => parseInt(num))
                            .filter(num => !isNaN(num));

                        for (let i = 1; i <= 5; i++) {
                            const box = document.getElementById(`param${i}`);
                            if (box) {
                                if (checkedNums.includes(i)) {
                                    box.classList.add('checked');
                                } else {
                                    box.classList.remove('checked');
                                }
                            }
                        }
                    }







                    el.textContent = value;
                }
            } catch (e) {
                console.error("Error reading data:", e);
            }
        });

        // 🖨️ Auto-print after load
        window.addEventListener('load', () => {
            window.print();
        });

        // ✅ Close window after print or cancel
        window.onafterprint = () => {
            window.close();
        };

        // ✅ Extra safety for some browsers
        const mediaQueryList = window.matchMedia('print');
        mediaQueryList.addEventListener('change', (mql) => {
            if (!mql.matches) {
                window.close();
            }
        });
    </script>


</body>

</html>