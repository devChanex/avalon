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
    <h2 class="form-title-long-nomargin">Nurse's Progress Notes</h2>
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






        </table>
        <hr>
        <table id="data-table"
            style="border: 1px solid black; width: 100%; border-collapse: collapse; text-align: center; font-family: 'Times New Roman', serif; font-size: 11px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 6px;max-width:100px;">DateTime</th>

                    <th style="border: 1px solid black; padding: 6px;">Focus</th>
                    <th style="border: 1px solid black; padding: 6px;">Data/Action/Response</th>

                </tr>
            </thead>
            <tbody></tbody>
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








                    el.textContent = value;
                }

                // ✅ Handle vital signs table if it exists
                if (row.ampn && Array.isArray(row.ampn)) {

                    const tbody = document.querySelector("#data-table tbody");
                    if (tbody) {
                        let count = 0;

                        // Add actual records
                        row.ampn.forEach(ampn => {
                            count++;
                            const dt = new Date(ampn.ampn_datetime);
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
                        <td style="border:1px solid black; padding:5px;max-width:100px;">${dateOnly} ${timeOnly}</td>
                  
                        <td style="border:1px solid black; padding:5px;">${ampn.ampn_focus || ''}</td>
                        <td style="border:1px solid black; padding:5px;">${ampn.ampn_data || ''}</td>
                    `;
                            tbody.appendChild(tr);
                        });

                        // Add empty rows until there are at least 10 total
                        for (let i = count; i < 25; i++) {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                        <td style="border:1px solid black; padding:5px; height:18px;max-width:100px;">&nbsp;</td>
                     
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                        <td style="border:1px solid black; padding:5px;">&nbsp;</td>
                    `;
                            tbody.appendChild(tr);
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