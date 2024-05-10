<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .chart-container {
            display: auto;
            justify-content: center;
            .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-transform: uppercase;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    /* Responsive table */
    @media screen and (max-width: 600px) {
        table {
            overflow-x: auto;
        }

        th, td {
            white-space: nowrap;
        }
    }
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Chart.js -->
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">
    <title>Work Order Dashboard</title>
    <div class="title">Work Order Dashboard </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Active Work Orders</h5>
                    <p class="card-text">Total: <span id="activeWorkOrders">0</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Finished Work Orders (This Month)</h5>
                    <p class="card-text">Total: <span id="finishedWorkOrders">0</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Work Orders in Queue</h5>
                    <p class="card-text">Total: <span id="workOrdersInQueue">0</span></p>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="card">
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <canvas id="workOrderChart"></canvas>
                </div>
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Priority</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Fix bug in login page</td>
                <td>In Progress</td>
                <td>John Doe</td>
                <td>High</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Update homepage design</td>
                <td>Completed</td>
                <td>Jane Smith</td>
                <td>Medium</td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
            </div>
        </div>
    </div>    
</div>

<script>
    // Dummy data for demonstration
    document.getElementById('activeWorkOrders').innerText = 50;
    document.getElementById('finishedWorkOrders').innerText = 30;
    document.getElementById('workOrdersInQueue').innerText = 20;

    // Chart.js example
    var ctx = document.getElementById('workOrderChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Active', 'Finished', 'In Queue'],
            datasets: [{
                label: 'Work Orders',
                data: [50, 30, 20],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</body>
</html>