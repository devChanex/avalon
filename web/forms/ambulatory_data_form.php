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
    <h2 class="form-title-long-nomargin">Ambulatory Surgery Patient Data Sheet</h2>
    <div class="section">
        <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">

            <tr>
                <!-- First column -->
                <td style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Patient
                        No:</label><strong><span class="auto-span" id="patientno" style="margin-left:20px"></span>
                    </strong></td>
                <td style="border: 1px solid black; padding: 2px; "><label
                        style="font-size:10px">CaseNo:</label><strong><span class="auto-span" id="caseno"
                            style="margin-left:20px"></span> </strong></td>
                <td colspan="2" style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Arrival
                        Date/Time:</label><strong><span class="auto-span" id="arrival" style="margin-left:20px"></span>
                    </strong></td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;"><label style="font-size:10px">Attending
                        Physician:</label><strong><span class="auto-span" id="physician"
                            style="margin-left:20px"></span> </strong></td>

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
                    <label style="font-size:10px">Member Type:</label><span class="auto-span" id="membertype"
                        style="margin-left:20px"></span> </strong>
                </td>

            </tr>

            </tr>

            <!-- Second row with 3 columns -->
            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Birthdate:</label><span class="auto-span" id="birthdate"
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
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Nationality:</label><span class="auto-span" id="nationality"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Religion:</label><span class="auto-span" id="religion"
                        style="margin-left:20px">
                    </span>
                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Marital Status:</label><span class="auto-span" id="marital_status"
                        style="margin-left:20px">
                    </span>
                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Contact No.:</label><span class="auto-span" id="contact_number"
                        style="margin-left:20px">
                    </span>
                </td>

            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Present Address:</label><span class="auto-span" id="present_address"
                        style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Office Address:</label><span class="auto-span" id="office_address"
                        style="margin-left:20px">
                    </span>
                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Occupation:</label><span class="auto-span" id="occupation"
                        style="margin-left:20px">
                    </span>
                </td>


            </tr>

            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">In case of Emergency, Please Notify:</label><span class="auto-span"
                        id="emergency_contact_person" style="margin-left:20px">
                    </span>

                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Relationship:</label><span class="auto-span"
                        id="emergency_relationship" style="margin-left:20px">
                    </span>
                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Contact No.:</label><span class="auto-span"
                        id="emergency_contact_number" style="margin-left:20px">
                    </span>
                </td>


            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Allergies:</label>
                    <span id="allergies" style="margin-left: 10px; font-size: 10px;"></span>
                </td>
                <td colspan="3" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Current Medication:</label>
                    <span id="currentmedication" style="margin-left: 10px; font-size: 10px;"></span>
                </td>
            </tr>
            <tr>
                <td colspan="6"
                    style="border: 1px solid black; padding: 6px; font-family: 'Times New Roman', serif; font-size: 11px; line-height: 1.4;">
                    <div style="text-align: justify; margin-bottom: 8px;">
                        <strong>Accomplished By:</strong><br>
                        I acknowledge that the above information is true and correct. I hereby authorize treatment and
                        understand the possible benefits and risks associated with it.
                    </div>

                    <div class="who-signature" style="margin-top:50px;">
                        <div id="fullname2" class="sig-name"></div>
                        <div class="long-sig-line"></div>
                        <div class="sig-role">Signature over Printed Name / Date & Time<br>Patient / Guardian</div>
                    </div>


                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px; text-align: center;">
                    <strong>TO BE FILLED-OUT BY STAFF NURSE</strong>

                </td>

            </tr>
            <tr>
                <td colspan="5" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Chief Complaint:</label><br>
                    <span id="chief_complaint" style="margin-left: 10px; font-size: 10px;"></span>
                </td>

                <td colspan="1" style="border: 1px solid black; padding: 4px;">




                    <input type="hidden" id="pain_rating" name="painScale" value="">
                    <label style="font-size:10px;">Pain Rating Scale:</label><br>
                    <div style="text-align:center;">
                        <span id="smiley" style="margin-left: 10px; font-size: 30px;"></span><br>
                        <label style="font-size:10px;" id="pain_label"><strong></strong>:</label>
                    </div>




                </td>

            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px; text-align: center;">
                    <strong>Initial Vital Signs</strong>

                </td>

            </tr>

            <tr>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">BP:</label><span class="auto-span" id="bp" style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PR:</label><span class="auto-span" id="pr" style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Temp:</label><span class="auto-span" id="temp"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">RR:</label><span class="auto-span" id="rr" style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Height:</label><span class="auto-span" id="height"
                        style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Weight:</label><span class="auto-span" id="weight"
                        style="margin-left:20px">
                    </span>

                </td>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">History of Illness:</label><br>
                    <span id="illness_history" style="margin-left: 10px; font-size: 10px;"></span>
                </td>



            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Past Medical History:</label><br>
                    <span id="past_medical_history" style="margin-left: 10px; font-size: 10px;"></span>
                </td>



            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Initial Impression:</label><br>
                    <span id="initial_impression" style="margin-left: 10px; font-size: 10px;"></span>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 6px;">
                    <label style="font-size:10px;">Type of Anesthesia:</label><br>
                    <div id="anesthesia" style="margin-left: 10px; font-size: 10px;  width: 100%;">
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border: 1px solid black; padding: 4px;">
                    <label style="font-size:10px;">Pre-op Orders/Preparations:</label><br>
                    <span id="preop_orders" style="margin-left: 10px; font-size: 10px;"></span>
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
                    if (key === "arrival" && value) {
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

                    if (key === "allergies") {

                        try {
                            // Parse only if value looks like JSON
                            const allergyData = typeof value === "string" ? JSON.parse(value) : value;
                            const parts = [];

                            if (allergyData.none) {
                                parts.push("None");
                            } else {
                                if (allergyData.drug?.checked)
                                    parts.push(`Drug (${allergyData.drug.specify || "unspecified"})`);
                                if (allergyData.food?.checked)
                                    parts.push(`Food (${allergyData.food.specify || "unspecified"})`);
                                if (allergyData.others?.checked)
                                    parts.push(`Other (${allergyData.others.specify || "unspecified"})`);
                            }

                            const allergiesText = parts.length ? parts.join(", ") : "N/A";
                            document.getElementById("allergies").textContent = allergiesText;
                            continue;
                        } catch (err) {
                            console.error("Invalid allergies JSON:", err, value);
                        }
                    }

                    if (key === "pain_rating") {
                        el.value = value;
                        const srate = document.getElementById("smiley");
                        const slabel = document.getElementById("pain_label")
                        if (value == 0) {
                            srate.textContent = "😊";
                            slabel.textContent = "0 - No hurt";
                        } else if (value == 1) {
                            srate.textContent = "🙂";
                            slabel.textContent = "2 - Hurts little bit";
                        } else if (value == 4) {
                            srate.textContent = "😐";
                            slabel.textContent = "4 - Hurts little more";
                        } else if (value == 6) {
                            srate.textContent = "😣";
                            slabel.textContent = "6 - Hurts even more";
                        } else if (value == 8) {
                            srate.textContent = "😭";
                            slabel.textContent = "8 - Hurts whole lot";
                        } else if (value == 10) {
                            srate.textContent = "😫";
                            slabel.textContent = "10 - Hurts worst";
                        }


                    }
                    if (key === "fullname") {
                        document.getElementById("fullname").textContent = value.toUpperCase();
                        document.getElementById("fullname2").textContent = value.toUpperCase();
                    }
                    if (key === "anesthesia" && value) {
                        try {
                            const list = JSON.parse(value);
                            const options = [
                                { id: "local", label: "Local" },
                                { id: "regional", label: "Regional" },
                                { id: "sedation", label: "Sedation" },
                                { id: "oral", label: "Oral" },
                                { id: "iv", label: "IV" }
                            ];

                            const html = options.map(opt => `
            <div style="
                display: flex; 
                align-items: center; 
                gap: 4px;
            ">
                <span style="
                    display:inline-block;
                    width: 10px;
                    height: 10px;
                    border: 1px solid black;
                    text-align: center;
                    line-height: 9px;
                    font-size: 8px;
                ">
                    ${list.includes(opt.id) ? "✔" : ""}
                </span>
                ${opt.label}
            </div>
        `).join("");

                            document.getElementById("anesthesia").innerHTML = html;
                            continue;
                        } catch (err) {
                            console.error("Invalid anesthesia JSON:", err);
                        }
                    }




                    el.textContent = value;
                }
            } catch (e) {
                console.error("Error reading data:", e);
            }
        });

        // // 🖨️ Auto-print after load
        // window.addEventListener('load', () => {
        //     window.print();
        // });

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