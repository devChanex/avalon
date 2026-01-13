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
    <h2 class="form-title-long-nomargin">Electronic Statement of Account</h2>
    <div class="section">
        <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">

            <tr>
                <!-- First column -->
                <td style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Patient
                        No:</label><strong><span class="auto-span" id="patientno" style="margin-left:20px"></span>
                    </strong></td>
                <td style="border: 1px solid black; padding: 2px; "><label
                        style="font-size:10px">CaseNo:</label><strong><span class="auto-span" id="referenceno"
                            style="margin-left:20px"></span> </strong></td>
                <td colspan="1" style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Bill
                        No.:</label><strong><span class="auto-span" id="billid" style="margin-left:20px"></span>
                    </strong></td>
                <td colspan="1" style="border: 1px solid black; padding: 2px; "><label style="font-size:10px">Bill
                        Date</label><strong><span class="auto-span" id="billdate" style="margin-left:20px"></span>
                    </strong></td>
                <td colspan="2" style="border: 1px solid black; padding: 2px;"><label style="font-size:10px">Attending
                        Physician:</label><strong><span class="auto-span" id="physician"
                            style="margin-left:20px"></span> </strong></td>

            </tr>

            </tr>
            <tr>
                <!-- First column -->
                <td colspan="2" style="border: 1px solid black; padding: 2px; width: 50%;"><label
                        style="font-size:10px">Patient Name:</label><strong><span class="auto-span" id="patientname"
                            style="margin-left:20px"></span> </strong></td>
                <td colspan="2"
                    style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px;">
                    <label style="font-size:10px">PHIC No.: </label><span class="auto-span" id="philhealth_number"
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
        Operating Room Charges
        <table id="or_charges_table"
            style="border: 1px solid black; width: 100%; border-collapse: collapse; text-align: center; font-family: 'Times New Roman', serif; font-size: 11px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 6px;">Classification</th>
                    <th style="border: 1px solid black; padding: 6px;">ChargeItem</th>
                    <th style="border: 1px solid black; padding: 6px;">Quantity</th>
                    <th style="border: 1px solid black; padding: 6px;">Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        Other Charges
        <table id="other_charges_table"
            style="border: 1px solid black; width: 100%; border-collapse: collapse; text-align: center; font-family: 'Times New Roman', serif; font-size: 11px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 6px;">ChargeItem</th>
                    <th style="border: 1px solid black; padding: 6px;">Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        Payments
        <table id="payment_table"
            style="border: 1px solid black; width: 100%; border-collapse: collapse; text-align: center; font-family: 'Times New Roman', serif; font-size: 11px;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 6px;">PaymentDate</th>

                    <th style="border: 1px solid black; padding: 6px;">Mode of Payment</th>
                    <th style="border: 1px solid black; padding: 6px;">Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>



        <hr>
        <div id="billing-summary" class="print-summary"
            style="border: 1px solid black; width: 100%; border-collapse: collapse; text-align: center; font-family: 'Times New Roman', serif; font-size: 11px;">

            <h4 style="margin:0 0 6px 0;">Billing Summary</h4>

            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span>Total Amount Due</span>
                <strong id="summary-amount-due">0.00</strong>
            </div>

            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span>Total Payments</span>
                <strong id="summary-total-payments">0.00</strong>
            </div>

            <hr style="margin:6px 0;">

            <div style="display:flex; justify-content:space-between; font-size:12px;">
                <span><strong>Remaining Balance</strong></span>
                <strong id="summary-balance">0.00</strong>
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
                let totalORAmount = 0;
                let totalOtherAmount = 0;
                let totalPayment = 0;
                // ✅ OR CHARGES
                if (row.or_charges && Array.isArray(row.or_charges)) {
                    console.log(row.or_charges);
                    const or_charges_tablebody = document.querySelector("#or_charges_table tbody");
                    if (or_charges_tablebody) {


                        // Add actual records
                        row.or_charges.forEach(data => {

                            const raw = data.item || '';

                            // Extract parts
                            const bracketMatch = raw.match(/\[(.*?)\]/);
                            const qtyMatch = raw.match(/\(x(\d+)\)/);

                            const category = bracketMatch ? bracketMatch[1] : '';
                            const quantity = qtyMatch ? qtyMatch[1] : '';
                            const itemName = raw
                                .replace(/\[.*?\]\s*-\s*/, '')
                                .replace(/\s*\(x\d+\)/, '')
                                .trim();
                            const amount = Number(data.amount || 0);
                            totalORAmount += amount;
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                     
                         <td style="border:1px solid black;padding:5px;">${category}</td>
                        <td style="border:1px solid black;padding:5px;">${itemName}</td>
                        <td style="border:1px solid black;padding:5px; text-align:center;">${Number(quantity).toFixed(2)}</td>
                        <td style="border:1px solid black; padding:5px;  text-align:right;">${Number(data.amount || '0').toFixed(2)}</td>
                      
                    
                    `;
                            or_charges_tablebody.appendChild(tr);
                        });
                        const totalTr = document.createElement("tr");
                        totalTr.innerHTML = `
            <td colspan="3"
                style="border:1px solid black; padding:5px; text-align:center; font-weight:bold;">
                Sub Total
            </td>
            <td style="border:1px solid black; padding:5px; text-align:right; font-weight:bold;">
                ${totalORAmount.toFixed(2)}
            </td>
        `;

                        or_charges_tablebody.appendChild(totalTr);

                    }
                }

                // ✅ OTHER CHARGES
                if (row.other_charges && Array.isArray(row.other_charges)) {

                    const other_charges_tablebody = document.querySelector("#other_charges_table tbody");

                    if (other_charges_tablebody) {


                        // Add actual records
                        row.other_charges.forEach(data => {
                            const amount = Number(data.amount || 0);
                            totalOtherAmount += amount;


                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                     
                        <td style="border:1px solid black; padding:5px;">${data.item || ''}</td>
                        <td style="border:1px solid black; padding:5px; text-align:right;">${Number(data.amount || '0').toFixed(2)}</td>
                      
                    
                    `;
                            other_charges_tablebody.appendChild(tr);
                        });
                        const totalTr = document.createElement("tr");
                        totalTr.innerHTML = `
            <td 
                style="border:1px solid black; padding:5px; text-align:center; font-weight:bold;">
                Sub Total
            </td>
            <td style="border:1px solid black; padding:5px; text-align:right; font-weight:bold;">
                ${totalOtherAmount.toFixed(2)}
            </td>
        `;

                        other_charges_tablebody.appendChild(totalTr);

                    }
                }

                // PAYMENTS
                if (row.payments && Array.isArray(row.payments)) {
                    console.log(row.payments);
                    const payment_tablebody = document.querySelector("#payment_table tbody");
                    if (payment_tablebody) {


                        // Add actual records
                        row.payments.forEach(data => {


                            const amount = Number(data.amount || 0);
                            totalPayment += amount;
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                     
                         <td style="border:1px solid black;padding:5px; text-align:center;">${data.payment_date}</td>
                        
                        <td style="border:1px solid black;padding:5px; text-align:center;">${data.mode}</td>
                          <td style="border:1px solid black; padding:5px;  text-align:right;">${Number(data.amount || '0').toFixed(2)}</td>
                    
                      
                    
                    `;
                            payment_tablebody.appendChild(tr);
                        });
                        const totalTr = document.createElement("tr");
                        totalTr.innerHTML = `
            <td colspan="2"
                style="border:1px solid black; padding:5px; text-align:center; font-weight:bold;">
                Sub Total
            </td>
            <td style="border:1px solid black; padding:5px; text-align:right; font-weight:bold;">
                ${totalPayment.toFixed(2)}
            </td>
        `;

                        payment_tablebody.appendChild(totalTr);

                    }
                }


                // SUMMARY
                const totalAmountDue = totalORAmount + totalOtherAmount;
                document.getElementById("summary-amount-due").textContent = totalAmountDue.toFixed(2);
                document.getElementById("summary-total-payments").textContent = totalPayment.toFixed(2);
                const remainingBalance = totalAmountDue - totalPayment;
                document.getElementById("summary-balance").textContent = remainingBalance.toFixed(2);

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