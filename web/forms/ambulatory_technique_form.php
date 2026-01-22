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
    <h2 class="form-title-long-nomargin">Operative Technique Form</h2>
    <div class="section">
        <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">

            <tr>
                <!-- First column -->
                <td style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Patient
                        No:</label><strong><span class="auto-span" id="patientno" style="margin-left:20px"> </span>
                    </strong></td>
                <td style="border: 1px solid black; padding: 2px; "><label
                        style="font-size:10px">CaseNo:</label><strong><span class="auto-span" id="caseno"
                            style="margin-left:20px"> </span> </strong></td>
                <td colspan="2" style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Date Time
                        Started
                    </label><strong><span class="auto-span" id="optech_started" style="margin-left:20px"> </span>
                    </strong></td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;"><label style="font-size:10px">Date Time
                        Ended:</label><strong><span class="auto-span" id="optech_ended" style="margin-left:20px">
                        </span> </strong></td>

            </tr>

            </tr>
            <tr>
                <!-- First column -->
                <td colspan="2" style="border: 1px solid black; padding: 2px; width: 50%;"><label
                        style="font-size:10px">Patient Name:</label><strong><span class="auto-span" id="fullname"
                            style="margin-left:20px"></span> </strong></td>
                <td colspan="2"
                    style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PHIC No.: </label><span class="auto-span" id="phic_no"
                        style="margin-left:20px">
                    </span> </strong>
                </td>
                <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Member Type:</label><span class="auto-span" id="member_type"
                        style="margin-left:20px"></span> </strong>
                </td>

            </tr>

            </tr>

            <!-- Second row with 3 columns -->
            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Birthdate:</label><span class="auto-span" id="birth_date"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Birthplace:</label><span class="auto-span" id="birth_place"
                        style="margin-left:20px">
                    </span>
                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Age:</label><span class="auto-span" id="age" style="margin-left:20px">
                    </span>
                </td>

                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Gender:</label><span class="auto-span" id="gender"
                        style="margin-left:20px">
                    </span>
                </td>

            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Preoperative Diagnosis:</label><span id="optech_preop_diagnosis"
                        style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Operative Procedures:</label><span id="optech_op_procedure"
                        style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PostOperative Diagnisis:</label><span id="optech_posop_diagnosis"
                        style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px; height: 400px; vertical-align: top;">
                    <label style="font-size:10px">Narrative of Technique with operative findings:</label><br>
                    <span id="optech_narative" style="margin-left:20px"></span>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px; height: 100px; vertical-align: top;">
                    <label style="font-size:10px">Attachment:</label><br>
                    <span id="images" style="margin-left:20px"></span>
                </td>
            </tr>

            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 2px;">

                    <label style="font-size:10px">Name of Surgical Team Members</label>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Surgeon:</label><span class="auto-span" id="optech_surgeon"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Assistant(s):</label><span class="auto-span" id="optech_assistant"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Anesthesiologist:</label><span class="auto-span"
                        id="optech_anesthesiologist" style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Scrub Nurse:</label><span class="auto-span" id="optech_scrub_nurse"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="3" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Circulating Nurse:</label><span class="auto-span"
                        id="optech_circulating_nurse" style="margin-left:20px">
                    </span>

                </td>

            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Instument Count:</label><span class="auto-span"
                        id="optech_instrument_count" style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Needle Count:</label><span class="auto-span" id="optech_needle_count"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Sponge Count:</label><span class="auto-span" id="optech_sponge_count"
                        style="margin-left:20px">
                    </span>

                </td>
            </tr>
            <tr>
                <td colspan="6"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: justify; margin-bottom: 8px;">
                        <strong>Prepared By:</strong><br>


                        <div style="text-align: center; margin-top: 50px;">
                            <span id="physician"></span>
                            <div style="border-top: 1px solid black; width: 70%; margin: 0 auto 2px auto;"></div>
                            <div style="font-size: 10px;">Signature over Printed Name / Date & Time</div>
                            <div style="font-size: 10px;">SURGEON</div>
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
                    if ((key === "optech_started" || key === "optech_ended") && value) {
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

                    if (key === "images") {
                        const container = el; // the DOM element where you want to show the images
                        container.innerHTML = ""; // clear existing content

                        if (value.trim()) {
                            try {
                                const imagesArray = JSON.parse(value); // parse JSON
                                imagesArray.forEach(imgObj => {
                                    const imgContainer = document.createElement('div');
                                    imgContainer.style.display = 'inline-block';
                                    imgContainer.style.margin = '5px';
                                    imgContainer.style.textAlign = 'center';

                                    const img = document.createElement('img');
                                    img.src = imgObj.src;       // Base64 or URL
                                    img.style.width = '96px';   // 1 inch
                                    img.style.height = '96px';  // 1 inch
                                    img.style.display = 'block';
                                    img.style.marginBottom = '3px';

                                    const caption = document.createElement('small');
                                    caption.textContent = imgObj.caption || '';

                                    imgContainer.appendChild(img);
                                    imgContainer.appendChild(caption);
                                    container.appendChild(imgContainer);
                                });
                            } catch (err) {
                                container.textContent = "Error parsing images";
                                console.error(err);
                            }
                        } else {
                            container.textContent = "N/A";
                        }

                        continue;
                    }








                    el.textContent = value;
                }

                // ✅ Handle vital signs table if it exists
                if (row.vitalSigns && Array.isArray(row.vitalSigns)) {
                    const vitalTableBody = document.querySelector("#vitalTable tbody");
                    if (vitalTableBody) {
                        let count = 0;

                        // Add actual records
                        row.vitalSigns.forEach(vital => {
                            count++;
                            const dt = new Date(vital.vital_datetime);
                            const dateOnly = !isNaN(dt)
                                ? `${(dt.getMonth() + 1).toString().padStart(2, '0')}/${dt.getDate().toString().padStart(2, '0')}/${dt.getFullYear()}`
                                : "";
                            let hours = dt.getHours();
                            const minutes = String(dt.getMinutes()).padStart(2, '0');
                            const ampm = hours >= 12 ? 'PM' : 'AM';
                            hours = hours % 12 || 12;
                            const timeOnly = !isNaN(dt) ? `${hours}:${minutes} ${ampm}` : "";

                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                        <td style="border:1px solid black; padding:5px;">${dateOnly}</td>
                        <td style="border:1px solid black; padding:5px;">${timeOnly}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.temp || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.pr || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.rr || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.bp || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.osat || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${vital.remarks || ''}</td>
                    `;
                            vitalTableBody.appendChild(tr);
                        });

                        // Add empty rows until there are at least 10 total
                        for (let i = count; i < 25; i++) {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                        <td style="border:1px solid black; padding:5px; height:18px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                    `;
                            vitalTableBody.appendChild(tr);
                        }
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