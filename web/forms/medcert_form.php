<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Medical Certificate</title>
    <link rel="stylesheet" href="../ccss/forms.css">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 16px;
            line-height: 1.8;
            margin: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }

        .content {
            text-align: justify;
        }

        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 250px;
            padding: 0 5px;
        }

        .short-line {
            min-width: 80px;
        }

        .medium-line {
            min-width: 150px;
        }

        .diagnosis-box {
            border: 1px none #000;
            min-height: 100px;
            padding: 10px;
            margin: 20px 0;
        }

        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 250px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
        }

        @media print {
            body {
                margin: 20mm;
            }
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

    <div class="title">Medical Certificate</div>

    <div class="content">
        This is to certify that
        <span class="line" id="fullname"></span>,
        <span class="short-line line" id="ages"></span> years old, residing at
        <span class="line" id="present_address"></span>,
        has been seen and examined on
        <span class="medium-line line" id="examined_date"></span>
        with the following diagnosis:
    </div>

    <table class="info-table-2">
        <tr>
            <td><span id="diagnosis" class="preserve-newline"></td>

        </tr>

    </table>

    <div class="content">
        The above injuries / illnesses would require attendance for a duration of <u> <span class="short-line"
                id="days_count"></span></u>

        days if without complications.
    </div>



    <footer class="footer2">
        <div class="signature-container">
            <div class="signature-block">

            </div>
            <div class="signature-block">

                <div class="signature-label"><u><span id="physician"></span></u>, MD</div>
                <div class="signature-label">Lic No.:_______________________________</div>
                <div class="signature-label">PTR No.:_______________________________</div>
                <div class="signature-label">S2 No.: _______________________________</div>

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

                    if (key === "examined_date" && row[key]) {
                        const dt = new Date(row[key]);

                        el.textContent = dt.toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: '2-digit',
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        }).replace(',', ' at');
                    } else {
                        el.textContent = row[key] ?? "N/A";
                    }
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