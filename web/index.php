<!DOCTYPE html>
<html>

<head>
    <title>Data Grafik</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        h1 {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 38px;
        }

        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        th,
        td {
            border: 1px solid #2A2F4F;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #FFD6A5;
        }

        .table-highlight {
            background-color: #FFFEC4;
        }

        .table-highlight:hover {
            background-color: #CBFFA9;
        }

        .table-highlight td {
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <?php include('data.php'); ?>

    <h1>Monitoring Temperature & Humidity</h1>

    <div class="chart-container">
        <div class="chart" id="chartTemperature"></div>
        <div class="chart" id="chartHumidity"></div>
    </div>
    <div class="chart-container">
        <div class="chart" id="chartStatusTemperature"></div>
        <div class="chart" id="chartStatusHumidity"></div>
    </div>

    <table>
        <tr>
            <th>Time</th>
            <th>Temperature</th>
            <th>Humidity</th>
            <th>Status Temperature</th>
            <th>Status Humidity</th>
        </tr>
        <?php for ($i = 0; $i < count($timeData); $i++) { ?>
            <tr class="table-highlight">
                <td><?php echo $timeData[$i]; ?></td>
                <td><?php echo $temperatureData[$i]; ?></td>
                <td><?php echo $humidityData[$i]; ?></td>
                <td><?php echo $statusTemperatureData[$i]; ?></td>
                <td><?php echo $statusHumidityData[$i]; ?></td>
            </tr>
        <?php } ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var temperatureData = <?php echo json_encode($temperatureData); ?>;
        var humidityData = <?php echo json_encode($humidityData); ?>;
        var statusTemperatureData = <?php echo json_encode($statusTemperatureData); ?>;
        var statusHumidityData = <?php echo json_encode($statusHumidityData); ?>;
        var timeData = <?php echo json_encode($timeData); ?>;

        var options = {
            colors: ["#5C8984"],
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: true },
            },
            dataLabels: {
                enabled: true
            },
            fill: {
                type: "gradient",
                gradient: {
                    type: 'vertical',
                    shadeIntensity: 1,
                    opacityFrom: 1,
                    opacityTo: 1,
                    colorStops: [{
                            offset: 20,
                            color: "#FF9B9B",
                            opacity: 1
                        },
                        {
                            offset: 35,
                            color: "#FFD6A5",
                            opacity: 1
                        },
                        {
                            offset: 50,
                            color: "#FFFEC4",
                            opacity: 1
                        },
                        {
                            offset: 65,
                            color: "#CBFFA9",
                            opacity: 5
                        }
                    ]
                }
            },
            stroke: {
                curve: "smooth",
                width: 2
            },
            xaxis: {
                categories: timeData,
                title: {
                    text: 'Time'
                }
            },
            yaxis: {
                title: {
                    text: 'Performance'
                }
            }
        };

        var chartTemperature = new ApexCharts(document.querySelector("#chartTemperature"), {
            ...options,
            series: [{
                name: 'Temperature',
                data: temperatureData,
            }],
            title: {
                text: 'Temperature Chart',
                align: 'center',
                style: {
                    fontSize: '18px'
                },
                offsetY: 20
            }
        });

        var chartHumidity = new ApexCharts(document.querySelector("#chartHumidity"), {
            ...options,
            series: [{
                name: 'Humidity',
                data: humidityData,
            }],
            title: {
                text: 'Humidity Chart',
                align: 'center',
                style: {
                    fontSize: '18px'
                },
                offsetY: 20
            }
        });

        var chartStatusTemperature = new ApexCharts(document.querySelector("#chartStatusTemperature"), {
            ...options,
            series: [{
                name: 'Status Temperature',
                data: statusTemperatureData,
            }],
            title: {
                text: 'Status Temperature Chart',
                align: 'center',
                style: {
                    fontSize: '18px'
                },
                offsetY: 20
            }
        });

        var chartStatusHumidity = new ApexCharts(document.querySelector("#chartStatusHumidity"), {
            ...options,
            series: [{
                name: 'Status Humidity',
                data: statusHumidityData,
            }],
            title: {
                text: 'Status Humidity Chart',
                align: 'center',
                style: {
                    fontSize: '18px'
                },
                offsetY: 20
            }
        });

        chartTemperature.render();
        chartHumidity.render();
        chartStatusTemperature.render();
        chartStatusHumidity.render();
    </script>
</body>
</html>
