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
    <h2 class="form-title">OPD Consultation Form</h2>
    <h2>Consultation Details:</h2>
    <table class="info-table">
        <tr>

            <td><strong>Consultation Date: </strong><span id="consultation_datetime"></span></td>
        </tr>
        <tr>
            <td><strong>Case No:</strong><span id="conref"></span></td>
            <td><strong>Service:</strong><span id="service"></span></td>

        </tr>
    </table>


    <h2>Patient Information</h2>
    <table class="info-table">
        <tr>
            <td><strong>Patient Name:</strong> <span id="fullname"></span></td>
            <td><strong>Contact No:</strong> <span id="contact_number"></span></td>
        </tr>
        <tr>
            <td><strong>Birthdate:</strong> <span id="birth_date"></span></td>
            <td><strong>Age:</strong> <span id="ages"></span></td>
        </tr>
        <tr>
            <td><strong>Address:</strong> <span id="present_address"></span></td>
            <td><strong>Gender:</strong> <span id="gender"></span></td>
        </tr>
    </table>




    <h2>Vital Signs</h2>

    <table class="info-table">
        <tr>
            <td><strong>Height:</strong> <span id="height"></span></td>
            <td><strong>Weight:</strong> <span id="weight"></span></td>
        </tr>
        <tr>
            <td><strong>Blood Pressure (BP):</strong> <span id="bp"></span></td>
            <td><strong>Respiratory Rate (RR):</strong> <span id="rr"></span></td>
        </tr>
        <tr>
            <td><strong>Heart Rate (HR):</strong> <span id="hr"></span></td>
            <td><strong>Oxygen Saturation (O2Sat):</strong> <span id="saturation"></span></td>
        </tr>
        <tr>
            <td><strong>Temperature:</strong> <span id="temp"></span></td>
            <td><strong>LMP:</strong> <span id="lmp"></span></td>

        </tr>

    </table>


    <h2>Medical History</h2>
    <table class="info-table">
        <tr>
            <td><strong>Allergies:</strong> <span id="allergies"></span></td>

        </tr>
        <tr>
            <td><strong>Past Illnesses & Surgery:</strong> <span id="past"></span></td>

        </tr>
        <tr>
            <td><strong>Current Illnesses & Surgery:</strong> <span id="current_medication"></span></td>

        </tr>

    </table>

    <h2>Consultation Details</h2>
    <table class="info-table">

        <tr>
            <td class="label">Physician:</td>
            <td id="physician"></td>
        </tr>
        <tr>
            <td class="label">Chief Complaint:</td>
            <td id="chief_complaint"></td>
        </tr>
    </table>

    <h2>Physician’s Notes</h2>
    <div class="notes-box" id="note"></div>

    <footer>
        <div class="signature-container">
            <div class="signature-block">

            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Physician’s Signature</div>
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
                    if (el) el.textContent = row[key] ?? "N/A";
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