<?php
include 'db.php';

// Ambil data calon dari database
$data_calon = $conn->query("SELECT nama_calon, jumlah_suara FROM calon");

$nama_calon = [];
$jumlah_suara = [];

while ($row = $data_calon->fetch_assoc()) {
    $nama_calon[] = $row['nama_calon'];
    $jumlah_suara[] = $row['jumlah_suara'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Pemilu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #ffffff, #d32f2f);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            background: #fff;
            margin: 60px auto;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        h2 {
            color: #b71c1c;
            margin-bottom: 30px;
        }
        canvas {
            max-width: 100%;
        }
        a {
            display: inline-block;
            margin-top: 30px;
            background: #b71c1c;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            background: #7f0000;
        }
        .suara-list {
            margin-top: 40px;
            text-align: left;
        }
        .suara-list h3 {
            color: #b71c1c;
        }
        .suara-list ul {
            list-style: none;
            padding: 0;
        }
        .suara-list li {
            font-size: 18px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hasil Pemilu 2025</h2>
        <canvas id="grafikSuara"></canvas>

        <!-- List Jumlah Suara -->
        <div class="suara-list">
            <h3>Jumlah Suara per Calon:</h3>
            <ul>
                <?php
                for ($i = 0; $i < count($nama_calon); $i++) {
                    echo "<li><strong>{$nama_calon[$i]}</strong>: {$jumlah_suara[$i]} suara</li>";
                }
                ?>
            </ul>
        </div>

        <a href="index.php">Kembali ke Halaman Pemilu</a>
    </div>

    <script>
        const ctx = document.getElementById('grafikSuara').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($nama_calon); ?>,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: <?php echo json_encode($jumlah_suara); ?>,
                    backgroundColor: 'rgba(211, 47, 47, 0.7)',
                    borderColor: '#b71c1c',
                    borderWidth: 2,
                    borderRadius: 10
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        color: '#000',
                        anchor: 'end',
                        align: 'start',
                        font: {
                            weight: 'bold',
                            size: 14
                        },
                        formatter: (value) => value + ' suara'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0,
                        title: {
                            display: true,
                            text: 'Jumlah Suara'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
</body>
</html>
