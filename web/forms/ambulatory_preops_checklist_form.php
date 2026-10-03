<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consultation Record</title>
    <link rel="stylesheet" href="../ccss/forms.css">
    <style>
        .preop-checkbox {
            width: 14px;
            height: 14px;
            margin: 0 4px 0 0;
            vertical-align: middle;
            accent-color: #000;
            cursor: pointer;
        }

        .checklist-item {
            display: block;
        }
    </style>
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
    <h2 class="form-title-long">PRE-OPERATIVE CHECKLIST</h2>
    <div class="section">
        <strong>PATIENT IDENTIFICATION:</strong><br>

        <div class="two-column">
            <div class="col">
                <div><label class="label"><input type="checkbox" class="preop-checkbox">Patient Name:</label> <span
                        class="value" id="fullname"></span></div>
                <div><label class="label"><input type="checkbox" class="preop-checkbox">Date of Birth:</label> <span
                        class="value" id="birthDate"></span></div>
                <div><label class="label"><input type="checkbox" class="preop-checkbox">Diagnosis:</label> <span
                        class="value" id="diagnosis"></span></div>
            </div>

            <div class="col">
                <div><label class="label"><input type="checkbox" class="preop-checkbox">Gender:</label> <span
                        class="value" id="gender"></span></div>
                <div><label class="label"><input type="checkbox" class="preop-checkbox">Age:</label> <span
                        class="value" id="age"></span></div>
            </div>
        </div>
    </div>

    <div class="section">
        <strong>CONSENT AND DOCUMENTATION:</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Surgical consent form signed /
            Anesthesia consent form signed</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Procedure verified with
            patient</label>
        <div class="checklist-item">____Surgical site marked by surgeon (if applicable)</div>
        <div class="checklist-item">____Pre-op checklist completed and signed</div>
    </div>
    <div class="section">
        <strong>CLINICAL ASSESSMENTS:</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Initial vital signs checked and
            recorded</label>

        <div class="vitals-grid">
            <div>BP: <span class="underline" id="BP"></span></div>
            <div>RR: <span class="underline" id="RR"></span></div>
            <div>O₂ SAT: <span class="underline" id="OSat"></span></div>
            <div>HT: <span class="underline" id="HT"></span></div>

            <div>HR: <span class="underline" id="HR"></span></div>
            <div>TEMP: <span class="underline" id="TEMP"></span></div>
            <div>LMP: <span class="underline" id="LMP"></span></div>
            <div>WT: <span class="underline" id="WT"></span></div>
        </div>

        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Allergies reviewed and documented:
            <span class="underline" id="allergies"></span></label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Last Meal and Fluid: <span
                class="underline-2" id="last_meal"></span></label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Laboratory and Diagnostic results
            in: <span class="underline-2" id="lab_result"></span></label>
    </div>

    <div class="section">
        <strong>MEDICATIONS:</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Medications reviewed and
            documented</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Anticoagulant / anti-platelet
            managed appropriately; Last dose given (date and time): <span class="underline-2"
                id="last_dose"></span></label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Pre-op medications given (e.g.,
            antibiotics, sedatives)</label>
    </div>

    <div class="section">
        <strong>SKIN AND HYGIENE:</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Nail polish, makeup, jewelry
            removed</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Dentures, contact lenses, hearing
            aids removed or documented</label>
    </div>

    <div class="section">
        <strong>PERSONAL PREPARATION AND PATIENT UNDERSTANDING:</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Valuables secured</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Informed of estimated
            procedure</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Patient explained the procedure,
            risks, and benefits discussed</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Patient questions addressed</label>
    </div>

    <div class="section">
        <strong>FINAL CONFIRMATIONS (BEFORE TRANSFER):</strong><br>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Correct procedure, site, and
            patient confirmed</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Surgical team notified and
            ready</label>
        <label class="checklist-item"><input type="checkbox" class="preop-checkbox">Imaging and required equipment
            available</label>
    </div>


    <footer style="margin-top:40px;">
        <div class="signature-container" style="display:flex; justify-content:flex-end; width:100%;">
            <div class="signature-block" style="width:45%; text-align:center;">
                <div class="signature-line"
                    style="position:relative; height:40px; border-bottom:1px solid #000; margin-bottom:5px;">
                    <span id="nurse"
                        style="position:absolute; bottom:2px; left:50%; transform:translateX(-50%); font-weight:500;">
                    </span>
                </div>
                <div class="signature-label" style="font-size:13px; font-weight:500;">
                    Signature over Printed Name / Date
                </div>
                <div class="signature-label" style="font-size:13px; font-weight:500;">
                    Accomplished By
                </div>
            </div>
        </div>
    </footer>




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

                for (const key in row) {
                    const el = document.getElementById(key);
                    if (!el) continue;

                    let value = row[key] ?? "N/A";

                    // ✅ Format the datetime nicely if key is 'procedure_datetime'
                    if (key === "procedure_datetime" && value) {
                        const dt = new Date(value);
                        if (!isNaN(dt)) {
                            value = dt.toLocaleString("en-US", {
                                month: "long",
                                day: "numeric",
                                year: "numeric",
                                hour: "numeric",
                                minute: "2-digit",
                                hour12: true
                            });
                        }
                    }
                    if (key === "physician") {
                        document.getElementById("physician2").textContent = value;
                    }

                    el.textContent = value;
                }
            } catch (e) {
                console.error("Error reading data:", e);
            }
        });

        // 🖨️ Auto - print after load
        window.addEventListener('load', () => {
            window.print();
        });

        // // ✅ Close window after print or cancel
        // window.onafterprint = () => {
        //     window.close();
        // };

        // // ✅ Extra safety for some browsers
        // const mediaQueryList = window.matchMedia('print');
        // mediaQueryList.addEventListener('change', (mql) => {
        //     if (!mql.matches) {
        //         window.close();
        //     }
        // });
    </script>


</body>

</html>