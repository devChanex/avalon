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
    <h2 class="form-title-long-nomargin">CONDITION PRIOR TO DISCHARGE</h2>
    <div class="section">
        <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">



            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Discharge Date and Time:</label><br>
                    <span id="discharge_datetime" style="margin-left: 10px; font-size: 10px;"></span>
                </td>
                <td colspan="2" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Case No:</label><br>
                    <span id="caseno" style="margin-left: 10px; font-size: 10px;"></span>
                </td>




            </tr>
            <tr>
                <td colspan="5" style="border: 1px solid black; padding: 4px; text-align: center;">
                    <strong>Vital Signs</strong>

                </td>

            </tr>

            <tr>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">BP:</label><span class="auto-span" id="discharge_bp"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PR:</label><span class="auto-span" id="discharge_pr"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">O₂ Sat:</label><span class="auto-span" id="discharge_osat"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Temp:</label><span class="auto-span" id="discharge_temp"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">RR:</label><span class="auto-span" id="discharge_rr"
                        style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="5"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: justify; margin-bottom: 8px;">
                        <strong>Accomplished By:</strong><br>


                        <div style="text-align: center; margin-top: 50px;">
                            <span id="discharge_nurse"></span>
                            <div style="border-top: 1px solid black; width: 70%; margin: 0 auto 2px auto;"></div>
                            <div style="font-size: 10px;">Signature over Printed Name / Date & Time</div>
                            <div style="font-size: 10px;">NURSE-IN-CHARGE</div>
                        </div>
                </td>
            </tr>
            <tr>
                <td colspan="5"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: justify; margin-bottom: 8px;">
                        <strong>Parameters for Discharge:</strong><br>
                        <div id="discharge_parameters">
                            <div><span class="discharge-checkbox" id="param1"></span> Patient is fully awake and
                                oriented.</div>
                            <div><span class="discharge-checkbox" id="param2"></span> Wound dressings are dry, intact,
                                and in
                                place.</div>
                            <div><span class="discharge-checkbox" id="param3"></span> Patient has stable vital signs.
                            </div>
                            <div><span class="discharge-checkbox" id="param4"></span> Patient can maintain mobility with
                                minimal
                                assistance.</div>
                            <div><span class="discharge-checkbox" id="param5"></span> Patient accompanied by a
                                responsible
                                person/adult.</div>
                        </div>


                </td>
            </tr>
            <tr>
                <td colspan="5"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: justify; margin-bottom: 8px;">
                        <strong>Assessed By:</strong><br>


                        <div style="text-align: center; margin-top: 50px;">
                            <span id="discharge_surgeon"></span>
                            <div style="border-top: 1px solid black; width: 70%; margin: 0 auto 2px auto;"></div>
                            <div style="font-size: 10px;">Signature over Printed Name / Date & Time</div>
                            <div style="font-size: 10px;">SURGEON</div>
                        </div>
                </td>
            </tr>

            <tr>
                <td colspan="5"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: center; margin-bottom: 8px;">
                        <br>
                        This is to certify that i was assessed prior to discharge and all assessments are acurate.


                        <div style="text-align: center; margin-top: 50px;">
                            <span id="discharge_surgeon"></span>
                            <div style="border-top: 1px solid black; width: 70%; margin: 0 auto 2px auto;"></div>
                            <div style="font-size: 10px;">Signature over Printed Name / Date & Time</div>
                            <div style="font-size: 10px;">PATIENT/GUARGIAN</div>
                        </div>
                </td>
            </tr>




        </table>




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
                    if (key === "discharge_datetime" && value) {
                        const dt = new Date(value);
                        if (!isNaN(dt)) {
                            const month = String(dt.getMonth() + 1).padStart(2, '0');
                            const day = String(dt.getDate()).padStart(2, '0');
                            const year = dt.getFullYear();

                            let hours = dt.getHours();
                            const minutes = String(dt.getMinutes()).padStart(2, '0');
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12; // Convert 0 -> 12 for 12-hour clock

                            value = `${month}-${day}-${year} ${hours}:${minutes} ${ampm}`;
                        }
                    }
                    if (key === "physician") {
                        document.getElementById("physician").textContent = value;
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