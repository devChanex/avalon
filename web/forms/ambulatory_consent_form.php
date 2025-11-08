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
    <h2 class="form-title-long">INFORMED CONSENT FOR MINOR SURGERY AND OTHER PROCEDURE</h2>
    <div class="section">
        I hereby authorize <strong><span id="physician"></span> </span> </strong>
        or whomever he/she may designate as his/her assistants to perform on
        <strong> <span id="fullname"></span> </span> </strong> the following procedure:
        <strong> <span id="procedures"></span> </span> </strong> on
        <strong> <span id="procedure_datetime"></span> </span> </strong>.
    </div>
    <br>
    <div class="section">
        It has been explained to me that during the operation / treatment / procedure, unforeseen conditions may be
        encountered which may necessitate surgical or other procedures in addition to or different from those
        contemplated. I therefore further authorize the above named doctor and his designate to perform such additional
        surgical or other procedures as are deemed necessary by them.
    </div>
    <br>
    <div class="section">
        I hereby authorize <strong> <span id="physician2"></span> </span> </strong> and/or his/her
        designees as his/her assistant(s) to give such anesthetic(s) as he/she may deem necessary and suited for my
        medical/surgical conditions with the exception of <strong> <span id="exception"></span> </span>
        </strong>.
    </div>
    <br>
    <div class="section">
        The following has been fully explained to me and I have understood the same:
        <div style="padding-left: 30px; margin-top: 5px;">
            &bull; The nature and procedure of the operation and/or procedure.<br>
            &bull; Expected outcome of this procedure/operation.<br>
            &bull; The possible alternative to this method of treatment.<br>
            &bull; The risks involved in the treatment.<br>
            &bull; The kinds and possibilities of complications.
        </div>
    </div>


    <br>
    <div class="section">
        Furthermore, it is clearly agreed that Avalon Wound Care Center, its personnel and medical staff are hereby
        released from all responsibilities or liabilities for the consequences, if any, resulting from the
        above-mentioned procedure(s).
    </div>
    <br>
    <div class="section">
        Having read and fully understood the contents of this form and after having discussed the same with my
        physician, I hereby sign below to acknowledge that I voluntarily give my authorization and consent to the
        performance of the procedure(s) described above by my physician and his delegated associates.<br><br>
        I consent to this procedure of my own free will, understanding the implications.
    </div>

    <footer>
        <div class="signature-container">
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Signature over Printed Name / Date</div>
                <div class="signature-label">PATIENT</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Signature over Printed Name / Date</div>
                <div class="signature-label">ATTENDING PHYSICIAN</div>
            </div>
        </div>

        <div class="signature-container">

            <div class="signature-block">
                <p style="text-align:left;"><i>In case the patient is minor</i></p>
                <div class="signature-line"></div>
                <div class="signature-label">Signature over Printed Name / Date</div>
                <div class="signature-label">GUARDIAN/NEAREST KIN</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Signature over Printed Name / Date</div>
                <div class="signature-label">NURSE IN-CHARGE</div>
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