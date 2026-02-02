//NURSE PROGRESS NOTES TABLE
const defaultTable = `
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th style="width:20%;">Date/Time</th>
            <th>Focus</th>
            <th>Data/Action/Response</th>
        </tr>
    </thead>
    <tbody>
        ${'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'.repeat(10)}
    </tbody>
</table>
`;

//POS TABLE
const defaultPOSTable = `
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
             <th>Progress Note</th>
              <th>Doctor's Order</th>
        </tr>
    </thead>
    <tbody>
        ${'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'.repeat(10)}
    </tbody>
</table>
`;

//MEDICATION  SHEET TABLE

const defaultMedicationSheetTable = `
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Medication</th>
            <th>Stock Dose</th>
             <th>Dosage</th>
              <th>Route</th>
              <th>Frequency</th>
              <th>Date</th>
              <th>Time</th>
        </tr>
    </thead>
    <tbody>
        ${'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'.repeat(10)}
    </tbody>
</table>

<br>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Nurse</th>
            <th>Date</th>
             <th>Time</th>
              <th>PRN/STAT/Single Dose Meds</th>
           
        </tr>
    </thead>
    <tbody>
        ${'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'.repeat(10)}
    </tbody>
</table>
`;

//VITAL SIGNS TABLE
const defaultVitalSignTable = `
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
             <th>Temperature</th>
              <th>Pulse Rate</th>
               <th>Respiratory Rate</th>
                <th>O₂ Sat</th>
                 <th>Remarks</th>
                  
        </tr>
    </thead>
    <tbody>
        ${'<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>'.repeat(10)}
    </tbody>
</table>
`;

//INSTRUMENT COUNTING TABLE
const instruments = [
    "ADSON FORCEP W/ TEETH",
    "ADSON FORCEP W/O TEETH",
    "ALLIS",
    "ARMY NAVY", "BANDAGE SCISSORS", "BLADE HANDLE #3", "BLADE HANDLE #4", "BOBCOCK", "DEAVER", "DEBAKEY FORCEP", "KELLY CLAMPS - Straight", "KELLY CLAMPS - Curved", "MALLEABLE", "MIXTERS", "MOSQUITO - Straight", "MOSQUITO - Curved", "NEEDLE HOLDER", "OVUM FORCEPS", "OCSHNER - Straight", "OCSHNER - Curved", "RICHARDSON", "SCISSORS - Metz", "SCISOORS - Mayo Curve", "SCISSORS - Mayo Straight", "TISSUE FORCEPS", "THUMB FORCEPS", "TOWEL CLIPS", "<strong>NEEDLES</strong>", "", "", "<strong>-SPONGES</strong>", "4X4 OS", "CHERRY BALLS", "COTTONOIDS", "PEANUTS", "<strong>-OTHERS</strong>", "", "", ""
];

const instrumentRows = instruments.map(name => `
    <tr>
        <td>${name}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
`).join('');


const defaultInstrumentCount = `
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th style="width:25%;">Instrument Tray</th>
            <th>Baseline</th>
            <th>Initial Counting</th>
            <th>Added</th>
            <th>Removed</th>
            <th>Final Count</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        ${instrumentRows}
    </tbody>
</table>
`;
