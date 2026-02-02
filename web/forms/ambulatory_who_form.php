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
    <h2 class="form-title-long-nomargin">WHO SURGICAL SAFETY CHECKLIST</h2>
    <div class="section">
        <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">

            <tr>
                <!-- First column -->
                <td colspan="2" style="border: 1px solid black; padding: 2px; width: 50%;"><label
                        style="font-size:10px">Patient Name:</label><strong><span id="fullname"
                            style="margin-left:20px"></span> </strong></td>
                <td
                    style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Case No.: </label><span id="amid" style="margin-left:20px">
                    </span> </strong>
                </td>
                <td style="border-left: 1px solid black; border-right: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PHIC No.:</label><span class="auto-span" id="phic_no"
                        style="margin-left:20px"></span> </strong>
                </td>

            </tr>

            </tr>

            <!-- Second row with 3 columns -->
            <tr>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Birthdate:</label><span id="birthdate" style="margin-left:20px">
                    </span>

                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Age:</label><span id="age" style="margin-left:20px">
                    </span>
                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Gender:</label><span id="gender" style="margin-left:20px">
                    </span>
                </td>
                <td style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Date/Time:</label><span class="auto-span" id="datetime"
                        style="margin-left:20px">
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Name of Procedure:</label><span id="procedure"
                        style="margin-left:20px">
                    </span>
                </td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">Attending Physician:</label><span id="physician"
                        style="margin-left:20px">
                    </span>
                </td>

            </tr>
        </table>




    </div>
    <br>
    <div class="who-checklist-container-header"
        style="display: flex; justify-content: space-between; width: 100%; align-items: stretch; position: relative;">

        <!-- Column 1 -->
        <div class="who-column-header" style="flex: 1; border-radius: 10px 0 0 10px; background-color: #0070c0; color: white;
            text-align: center; font-weight: bold; padding: 10px;
            display: flex; align-items: center; justify-content: center;
            height: 100px; box-sizing: border-box; position: relative; margin-right: 6px;">
            Before Induction of Anesthesia
            <!-- Red arrow on top -->
            <div style="position: absolute; right: -10px; top: 50%; transform: translateY(-50%);
            width: 0; height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-left: 20px solid red;
            z-index: 10;"></div>
        </div>

        <!-- Column 2 -->
        <div class="who-column-header" style="flex: 1; background-color: #0070c0; color: white;
            text-align: center; font-weight: bold; padding: 10px;
            display: flex; align-items: center; justify-content: center;
            height: 100px; box-sizing: border-box; position: relative; margin-right: 6px;">
            Before Skin Incision
            <!-- Red arrow on top -->
            <div style="position: absolute; right: -10px; top: 50%; transform: translateY(-50%);
            width: 0; height: 0;
            border-top: 12px solid transparent;
            border-bottom: 12px solid transparent;
            border-left: 20px solid red;
            z-index: 10;"></div>
        </div>

        <!-- Column 3 -->
        <div class="who-column-header" style="flex: 1; border-radius: 0 10px 10px 0; background-color: #0070c0; color: white;
            text-align: center; font-weight: bold; padding: 10px;
            display: flex; align-items: center; justify-content: center;
            height: 100px; box-sizing: border-box; position: relative;">
            Before Patient Leaves Operating Room
        </div>
    </div>

    <br>



    <div class="who-checklist-container">

        <!-- Column 1 -->
        <div class="who-column">

            <div class="who-subsection-title">Sign In</div>
            <ul class="who-list">
                <li>○ Patient Confirmed</li>
                <li><input type="checkbox" class="who-checkbox"> Identity</li>
                <li><input type="checkbox" class="who-checkbox"> Procedure</li>
                <li><input type="checkbox" class="who-checkbox"> Consent</li>
                <li>○ Site marked<br>
                    <input type="checkbox" class="who-checkbox"> Yes
                    <input type="checkbox" class="who-checkbox"> N/A
                </li>
                <li>○ Anesthesia Safety Checklist completed</li>
                <li>○ Pulse Oximeter on Patient and functioning</li>
            </ul>

            <div class="who-subsection-title">Does Patient Have A:</div>
            <ul class="who-list">
                <li>Known Allergy:<br>
                    <input type="checkbox" class="who-checkbox"> Yes
                    <input type="checkbox" class="who-checkbox"> No
                </li>
                <li>Difficulty Airway / Aspiration Risk:<br>
                    <input type="checkbox" class="who-checkbox"> No<br>
                    <input type="checkbox" class="who-checkbox"> Yes and equipment assistance applicable
                </li>
                <li>Risk of &gt;500cc Blood loss (7cc in children):<br>
                    <input type="checkbox" class="who-checkbox"> No<br>
                    <input type="checkbox" class="who-checkbox"> Yes and adequate IV access and fluids planned
                </li>
            </ul>
            <br> <br> <br> <br>
            <div class="who-signature" style="margin-top: auto; text-align: center; padding-top: 10px; 
                   border-top: 1px solid #ccc; font-weight: bold; color: #333;">
                Anesthesiologist
            </div>
        </div>

        <!-- Column 2 -->
        <div class="who-column">

            <div class="who-subsection-title">Time Out</div>
            <ul class="who-list">
                <li>○ Confirm all team members have introduced themselves by name and role</li>
                <li>○ Confirm the patient’s name, procedure, and where the incision will be made</li>
            </ul>

            <div class="who-subsection-title">Anticipated Critical Events</div>
            <ul class="who-list">
                <li>○ To Surgeon: What are the critical steps, operative duration, anticipated blood loss</li>
                <li>○ To Anesthesiologist: Are there any patient-specific concerns?</li>
                <li>○ To Nursing Team: Has sterility been confirmed? Are there equipment issues or any concerns?</li>
                <li>Antibiotic/Prophylaxis given within the last 60 minutes?<br>
                    <input type="checkbox" class="who-checkbox"> Yes<br>
                    <input type="checkbox" class="who-checkbox"> No
                </li>
                <li>Essential Imaging Displayed?<br>
                    <input type="checkbox" class="who-checkbox"> Yes<br>
                    <input type="checkbox" class="who-checkbox"> N/A
                </li>
            </ul>
            <br><br><br><br><br>
            <div class="who-signature">
                <div id="physician2" class="sig-name">Dr. Juan</div>
                <div class="sig-line"></div>
                <div class="sig-role">Surgeon</div>
            </div>



        </div>

        <!-- Column 3 -->
        <div class="who-column">

            <div class="who-subsection-title">Sign Out</div>
            <ul class="who-list">
                <li>Nurse verbally confirms:</li>
                <li>○ The name of the procedure</li>
                <li>○ Completion of instruments, sponge and needle counts</li>
                <li>○ Specimen labelling (read specimen labels aloud, including patient name)</li>
                <li>○ Whether there are any equipment problems to be addressed</li>
            </ul>
            <br>
            <ul class="who-list">
                <li>To Surgeon, Anesthesiologist and Nurse:</li>
                <li>○ What are the key concerns for recovery and management of this patient</li>
            </ul>

            <br><br><br><br><br><br><br><br><br><br><br><br>
            <div class="who-signature">
                <div id="nurse" class="sig-name"></div>
                <div class="sig-line"></div>
                <div class="sig-role">Circulating Nurse</div>
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

                for (const key in row) {

                    const el = document.getElementById(key);
                    if (!el) continue;

                    let value = row[key] ?? "N/A";

                    // ✅ Format the datetime nicely if key is 'procedure_datetime'
                    if (key === "datetime" && value) {
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