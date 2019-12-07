require('./bootstrap');

$('#current-month').on('change', function(e){
    e.preventDefault();
    let month = $(this).val(),
        id = $(this).data('id');
    window.location = '/ip/' + id + '/' + month;
});

$('#stat-month').on('change', function(e){
    e.preventDefault();
    let month = $(this).val();
    window.location = '/reports/' + month;
});

google.charts.load('current', {packages: ['corechart']});
google.charts.setOnLoadCallback(drawDownTimeChart);
google.charts.setOnLoadCallback(drawLossesChart);

function drawDownTimeChart() {
    let stats = JSON.parse($('#chart').attr('data-stats'));

    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        let data = google.visualization.arrayToDataTable(stats);

        let view = new google.visualization.DataView(data);

        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);

        let options = {
            title: "Connection downtime (Hours)",
            height: 400,
            bar: {groupWidth: "95%"},
            legend: {position: "none"},
        };
        let chart = new google.visualization.ColumnChart(document.getElementById("chart"));
        chart.draw(view, options);
    }
}

function drawLossesChart() {
    let stats = JSON.parse($('#losses').attr('data-losses')),
        total_loss = $('#losses').attr('data-total-loss');

    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        let data = google.visualization.arrayToDataTable(stats);

        let view = new google.visualization.DataView(data);

        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);

        let options = {
            title: `Money ISP owe me for each month's downtime (Total: ${total_loss})`,
            height: 350,
            bar: {groupWidth: "95%"},
            legend: {position: "none"},
        };
        let chart = new google.visualization.ColumnChart(document.getElementById("losses"));
        chart.draw(view, options);
    }
}

