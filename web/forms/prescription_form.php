<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription Form</title>
    <link rel="stylesheet" href="../ccss/forms.css">
</head>

<body>
    <header><img src="../img/logo/logo.png" alt="Clinic Logo">
        <div class="clinic-info">
            <h1>Avalon Wound Care Center</h1>
            <p>4th Flr. Tri-Ax Three Center,
                35 Manila S. Rd.,
                Brgy. San Antonio,
                Binan,
                Laguna </p>
            <p>avalonwouldcare2024@gmail.com |+63 921 496 7592</p>
        </div>
    </header>
    <h2>Patient Information</h2>
    <table class="info-table">
        <tr>
            <td><strong>Patient Name:</strong><span id="fullname"></span></td>
            <td><strong>Contact No:</strong><span id="contact_number"></span></td>
        </tr>
        <tr>
            <td><strong>Gender:</strong><span id="gender"></span></td>
            <td><strong>Age:</strong><span id="ages"></span></td>
        </tr>
        <tr>
            <td><strong>Date:</strong><span id="formatted_prescription_date"></span></td>
    </table>
    <h2>Prescription</h2>
    <table class="info-table">
        <tr>
            <td><span id="prescription" class="preserve-newline"></span></td>
        </tr>
    </table>
    <h2></h2>
    <table class="info-table">
        <tr>
            <td><strong>Your Next Appointment is on:</strong><u><span id="formatted_next_appointment"></span></u>
            </td>
        </tr>
    </table>
    <footer class="footer2">
        <div class="signature-container">
            <div class="signature-block"></div>
            <div class="signature-block">
                <div class="signature-label"><u><span id="physician"></span></u>,
                    MD</div>
                <div class="signature-label">Lic No.:_______________________________</div>
                <div class="signature-label">PTR No.:_______________________________</div>
                <div class="signature-label">S2 No.: _______________________________</div>
            </div>
        </div>
    </footer>
    <div class="text-center no-print" style="text-align:center; margin-top:40px;"><button onclick="window.print()"
            style="padding:8px 18px; font-size:14pt;">🖨️ Print</button><button onclick="window.close()"
            style="padding:8px 18px; font-size:14pt;">Close</button></div>
    <script>function normalizePrescriptionText(value) {
            return String(value ?? '').replace(/&nbsp; /g, ' ').replace(/\u00a0/g, ' ').replace(/\s+/g, ' ').trim();
        }

        function renderPrescriptionOutput(rawHtml, target) {
            const html = String(rawHtml ?? '').trim();

            if (!html) {
                target.textContent = 'N/A';
                return;
            }

            const doc = new DOMParser().parseFromString(html, 'text/html');
            const table = doc.querySelector('table');

            if (table) {
                const rows = Array.from(table.querySelectorAll('tbody tr'));

                const output = rows.map((row) => {
                    const cells = Array.from(row.querySelectorAll('td')).map((cell) => normalizePrescriptionText(cell.textContent));
                    const generic = cells[0] || '';
                    const brand = cells[1] || '';
                    const dosage = cells[2] || '';
                    const preparation = cells[3] || '';
                    const units = cells[4] || '';
                    const instruction = cells[5] || '';

                    if (!generic && !brand && !dosage && !preparation && !units && !instruction) {
                        return '';
                    }

                    const main = [
                        generic,
                        brand ? `(${brand})` : '',
                        dosage,
                        preparation ? `/ ${preparation}` : ''
                    ].filter(Boolean).join(' ').replace(/\s+/g, ' ').trim();

                    const sig = instruction ? `Sig. ${instruction}` : '';
                    const unitsHtml = units ? `<span class="rx-units">${units}</span>` : '';
                    const sigHtml = sig ? `<div class="rx-sig">${sig}</div>` : '';

                    return `<div class="rx-row"><span class="rx-main">${main}</span>${unitsHtml}</div>${sigHtml}`;
                }

                ).filter(Boolean).join('');

                target.innerHTML = output ? `<div class="prescription-output">${output}</div>` : 'N/A';
                return;
            }

            const plainHtml = doc.body.innerHTML.replace(/<p[^>]*>/gi, '').replace(/<\/p>/gi, '<br>').replace(/<div[^>]*>/gi, '').replace(/<\/div>/gi, '<br>').replace(/<br\s*\/?>/gi, '<br>').replace(/<\/?(span|strong|b|em|i|u)[^>]*>/gi, '').trim();

            target.innerHTML = plainHtml || html;
        }

        document.addEventListener("DOMContentLoaded", () => {
            try {
                // PHP echoes the POSTed data into JS
                const data = <?php echo json_encode($_POST['data'] ?? '{}'); ?>;
                const row = JSON.parse(data);

                for (const key in row) {
                    const el = document.getElementById(key);
                    if (!el) continue;

                    if (key === 'prescription') {
                        renderPrescriptionOutput(row[key], el);
                    }

                    else {
                        el.textContent = row[key] ?? "N/A";
                    }
                }
            }

            catch (e) {
                console.error("Error reading data:", e);
            }
        }

        );

        // 🖨️ Auto-print after load
        window.addEventListener('load', () => {
            window.print();
        }

        );

        // ✅ Close window after print or cancel
        window.onafterprint = () => {
            window.close();
        }

            ;

        // ✅ Extra safety for some browsers
        const mediaQueryList = window.matchMedia('print');

        mediaQueryList.addEventListener('change', (mql) => {
            if (!mql.matches) {
                window.close();
            }
        }

        );
    </script>
</body>

</html>