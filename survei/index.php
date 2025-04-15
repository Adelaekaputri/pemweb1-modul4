<!DOCTYPE html>
<html>
<head>
    <title>Survei Kepuasan Pelanggan - Ruang Rindu Coffee</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&family=Pacifico&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1500&q=80') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: #4e342e;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            max-width: 700px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        h1 {
            font-family: 'Pacifico', cursive;
            text-align: center;
            color: #6d4c41;
            font-size: 32px;
            margin-bottom: 10px;
        }

        h3 {
            text-align: center;
            margin-top: 40px;
            color: #6d4c41;
        }

        form {
            margin-top: 30px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="text"], select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #bcaaa4;
            border-radius: 8px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background: #8d6e63;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background: #6d4c41;
        }

        canvas {
            background: white;
            border-radius: 10px;
            padding: 20px;
            max-width: 100%;
            margin: 20px auto;
            display: block;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .total {
            text-align: center;
            margin: 20px 0 0;
            font-weight: bold;
            color: #5d4037;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Survei Kepuasan Pelanggan</h1>
        <p style="text-align:center; color:#795548;">Terima kasih telah berkunjung ke <strong>Ruang Rindu Coffee</strong>. Beri kami masukan untuk terus memperbaiki pelayanan kami.</p>

        <form method="POST" action="proses.php">
            <label>Nama Anda:</label>
            <input type="text" name="nama" required>

            <label>Seberapa puas Anda dengan pelayanan kami?</label>
            <select name="kepuasan" required>
                <option value="Sangat Puas">Sangat Puas</option>
                <option value="Puas">Puas</option>
                <option value="Cukup">Cukup</option>
                <option value="Kurang">Kurang</option>
            </select>

            <input type="submit" value="Kirim Survei">
        </form>

        <?php
        include 'db.php';
        $data = [];
        $total = 0;

        $query = $conn->query("SELECT kepuasan, COUNT(*) as jumlah FROM survei GROUP BY kepuasan");
        while ($row = $query->fetch_assoc()) {
            $data[$row['kepuasan']] = $row['jumlah'];
            $total += $row['jumlah'];
        }
        ?>

        <h3>Grafik Kepuasan</h3>
        <canvas id="chartSurvei" width="600" height="300"></canvas>
        <div class="total">Total Responden: <?= $total ?></div>
    </div>

    <script>
        const ctx = document.getElementById('chartSurvei').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_keys($data)) ?>,
                datasets: [{
                    label: 'Jumlah Responden',
                    data: <?= json_encode(array_values($data)) ?>,
                    backgroundColor: [
                        '#4caf50', // Sangat Puas
                        '#ff9800', // Puas
                        '#ffc107', // Cukup
                        '#f44336'  // Kurang
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
