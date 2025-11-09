loaddata();
function loaddata() {

    document.getElementById("loaderOverlay").style.display = "flex";

    var fd = new FormData();
    fd.append('service', 'dashboard-dataService');

    $.ajax({
        url: "api.php",
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (result) {
            // promptSuccess('Process Successful', result.data.fullname);
            console.log(result);
            if (result.success) {
                document.getElementById("patientCount").innerText = result.patientcount;
                document.getElementById("patientCount-banner").innerText = result.patientcount;

                document.getElementById("opd-patientCount").innerText = result.outpatientcount;
                document.getElementById("opd-patientCount-percent").innerText = ((result.outpatientcount / result.patientcount) * 100).toFixed(2) + "%";
                document.getElementById("opd-patientCount-banner").innerText = result.outpatientcount;

                document.getElementById("amb-patientCount").innerText = result.ambulatorypatientcount;
                document.getElementById("amb-patientCount-percent").innerText = ((result.ambulatorypatientcount / result.patientcount) * 100).toFixed(2) + "%";
                document.getElementById("amb-patientCount-banner").innerText = result.ambulatorypatientcount;

                if (result.success && result.monthlydata) {

                    // Create chart dynamically by passing container ID and data
                    createMonthlyBarChart("deal-analytic-chart", result.monthlydata, 2025);
                }
                setTimeout(function () {
                    document.getElementById("loaderOverlay").style.display = "none";
                }, 500); // <-- simulate 2 sec delay
            }


        },
        error: function (xhr) {
            promptError('Process Failed', "Error: " + xhr.responseText);
        }

    });




}
function createMonthlyBarChart(chartId, data, year) {
    // Generate all 12 months for the given year
    const allMonths = Array.from({ length: 12 }, (_, i) => {
        const monthCode = `${year}-${String(i + 1).padStart(2, "0")}`; // "YYYY-MM"
        const monthLabel = new Date(year, i).toLocaleString("en-US", {
            month: "short",
            year: "numeric"
        });
        return { monthCode, monthLabel, ambulatory: 0, opd: 0 };
    });

    // Merge backend data into full-year array
    data.forEach(row => {
        const found = allMonths.find(m => m.monthCode === row.month);
        if (found) {
            found.ambulatory = parseInt(row.ambulatory_count) || 0;
            found.opd = parseInt(row.opd_count) || 0;
        }
    });

    console.log("Chart Data:", allMonths); // ✅ confirm before render

    // Create the bar chart
    AmCharts.makeChart(chartId, {
        type: "serial",
        theme: "light",
        dataProvider: allMonths,
        categoryField: "monthLabel",
        startDuration: 1,
        precision: 0,

        categoryAxis: {
            gridPosition: "start",
            labelRotation: 45,
            title: "Month (Year)",
            parseDates: false
        },

        valueAxes: [{
            title: "Number of Cases"
        }],

        graphs: [{
            balloonText: "Ambulatory: [[value]]",
            fillAlphas: 0.8,
            lineAlpha: 0.2,
            type: "column",
            title: "Ambulatory",
            valueField: "ambulatory",
            fillColors: "#2ed8b6"
        }, {
            balloonText: "OPD: [[value]]",
            fillAlphas: 0.8,
            lineAlpha: 0.2,
            type: "column",
            title: "OPD",
            valueField: "opd",
            fillColors: "#e95753"
        }],

        legend: {
            useGraphSettings: true,
            position: "top"
        },

        chartCursor: {
            cursorAlpha: 0,
            zoomable: false
        },

        balloon: {
            borderThickness: 1,
            shadowAlpha: 0
        }
    });
}


