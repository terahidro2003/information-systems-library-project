/*
    Async type function for fetching API data
*/
async function fetchAsync (url, type, token) {
    let response = await fetch(url, {
        method: 'post',
        headers:new Headers({
            'Content-type': 'application/x-www-form-urlencoded; charset=UTF-8'
        }),
        body: `token=${token}&data=${type}`
    });
    let data = await response.json();
    return data;
}

//feedbacks
var feedback1 = fetchAsync("/system/statistics_api.php", "statuses", token);
var feedback2 = fetchAsync("/system/statistics_api.php", "leases", token);

//responses
var response1 = [];
var response2 = [];

//savings
feedback1.then(data =>{
    response1 = data;
});

feedback2.then(data =>{
    console.log(data);
    response2 = data;
});

//Google charts API configuration
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart1);
google.charts.setOnLoadCallback(drawChart2);

function drawChart1() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Status');
    data.addColumn('number', 'Amount');
    data.addRows(response1.length);
    
    for(var i = 0; i<response1.length; i++)
    {
        data.setCell(i, 0, response1[i][0]);
        data.setCell(i, 1, response1[i][1]);
    }

    var options = {
        title: 'Statuses of issued books',
        is3D: false,
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart1'));
    chart.draw(data, options);
}

function drawChart2() {

    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Issued Books');
    data.addColumn('number', 'Day');

    data.addRows(response2.length);
    
    for(var i = 0; i<response2.length; i++)
    {
        data.setCell(i, 1, response2[i][0]);
        data.setCell(i, 0, response2[i][1]);
    }

    var options = {
      title: 'Amount of leases on month days',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart2'));

    chart.draw(data, options);
  }

