<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Consultation Record</title>
    <link rel="stylesheet" href="../ccss/forms.css">

</head>

<body style="font-size: 12px;">

    <header>
        <img src="../img/logo/logo.png" alt="Clinic Logo">
        <div class="clinic-info">
            <h1>Avalon Wound Care Center</h1>
            <p>4th Flr. Tri-Ax Three Center, 35 Manila S. Rd., Brgy. San Antonio, Binan, Laguna </p>
            <p>avalonwouldcare2024@gmail.com | +63 921 496 7592</p>
        </div>
    </header>
    <h2 class="form-title-long-nomargin">INFORMATION AND DATA CONSENT FORM</h2>
    <div class="section">


        <p>Our healthcare facility collects and processes your personal and medical information to provide safe,
            accurate
            and quality
            healthcare services. This includes diagnosis, treatment, medical records management, billing and reporting
            in
            accordance with Data
            Privacy Act of 2012 and other health authorities.</p>

        <p><strong>Type of Data Collected</strong></p>

        <p style="margin-bottom: 0px;padding-bottom:0px;">We May collect and store the following types of personal and
            sensitive information:</p>
        <ul style="margin-top: 0px;padding-top:0px;">
            <li>Full name, Date of birth, address and contact details</li>
            <li>Medical History, diagnosis and treatment records</li>
            <li>Laboratory and diagnostic results</li>
            <li>Physician's notes and prescriptions</li>
            <li>Billing and insurance information</li>
            <li>Emergency contact or next-of-kin information</li>
        </ul>


        <p><strong>Use and Sharing of Data</strong></p>

        <p style="margin-bottom: 0px;padding-bottom:0px;">Your data will be used only for legitimate healthcare and
            administrative purposes.<br> It may be shared with:
        </p>

        <ul style="margin-top: 0px;padding-top:0px;">
            <li>Attending physicians, nurses and other authorized healthcare providers</li>
            <li>Health insurance companies (for claims and reimbursement)</li>
            <li>Government health agencies (as required by law e.g DOH and Philhealth)</li>
        </ul>
        <p>We will not share your personal data with any third party without your explicit consent, unless required by
            law.</p>
        <p><strong>Data Protection and Retention</strong></p>

        <p style="margin-bottom: 0px;padding-bottom:0px;">All patient records are kept confidential and secure.</p>
        <ul style="margin-top: 0px;padding-top:0px;">
            <li>Physical records are stored in locked and restricted areas</li>
            <li>Electronic records are password-protected and encrypted</li>

            <lip>Records will be retained in accordance with legal and medical requirements and then securely dispose
                thru
                shredding.</li>
        </ul>
        <p><strong>Your Rights</strong></p>

        <p style="margin-bottom: 0px;padding-bottom:0px;">Under the Data Privacy Act of 2012 (Republic Act 10173), you
            have the right to:</p>
        <ul style="margin-top: 0px;padding-top:0px;">
            <li>Access and request a copy of your personal data</li>
            <li>Correct or update inaccurate information</li>
            <li>Withdraw consent for processing (subject to limitations under medical and legal obligations)</li>
            <li>Lodge a complaint with the National Privacy Commission (NPC) if you believe your data privacy rights
                have been
                violated</li>
        </ul>

        <p style="margin-bottom: 0px;padding-bottom:0px;"><strong></strong>Consent Statement</strong></p>
        <p style="margin-bottom: 0px;padding-bottom:0px;">I have read and understood the information above. I
            voluntarily give my consent to the collection, use and
            processing of my
            personal and medical data for legitimate healthcare purposes. I understand that my information will be
            handled
            with strict
            confidentiality.</p>

    </div>


    <div class="signature-container" style="margin-top:5px;padding-top:0px;margin-bottom:5px;padding-bottom:0px;">
        <div class="signature-block">
            <div class="signature-line">
                <span id="fullname" style="font-size:12px;"></span>
            </div>
            <div class="signature-label" style="font-size:12px;">PATIENT'S SIGNATURE OVER PRINTED NAME/DATE</div>
        </div>
        <div class="signature-block">
            <div class="signature-line">
                <span id=""></span>
            </div>
            <div class="signature-label" style="font-size:12px;">GUARDIAN'S (If Minor) SIGNATURE OVER PRINTED NAME/DATE
            </div>
        </div>


    </div>

    <div class="signature-container" style="margin-top:0px;padding-top:0px;">

        <div class="signature-block">
            <div class="signature-line">
                <span id="representative"></span>
            </div>
            <div class=" signature-label" style="font-size:12px;">NAME OF HEALTHCARE FACILITIES REPRESENTATIVE
            </div>
        </div>

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

                    const el = document.getElementById(key);
                    if (!el) continue;

                    let value = row[key] ?? "N/A";

                    // ✅ Format the datetime nicely if key is 'procedure_datetime'

                    if (key === "fullname" && value) {

                        const dt = new Date(row["datetime"] ?? '');

                        if (!isNaN(dt)) {
                            const month = String(dt.getMonth() + 1).padStart(2, '0');
                            const day = String(dt.getDate()).padStart(2, '0');
                            const year = dt.getFullYear();

                            let hours = dt.getHours();
                            const minutes = String(dt.getMinutes()).padStart(2, '0');
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12; // Convert 0 -> 12 for 12-hour clock

                            value = value + " / " + `${month}-${day}-${year}`;
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