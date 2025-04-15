<?php
include 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemilu Indonesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #d32f2f, #ffffff);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background: #fff;
            margin: 60px auto;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #c62828;
        }
        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
            color: #333;
        }
        input[type="text"],
        input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .calon-container {
            margin: 25px 0;
        }
        .calon-option {
            background: #fce4ec;
            border: 2px solid transparent;
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            transition: all 0.3s ease;
        }
        .calon-option:hover {
            background: #ffcdd2;
            border-color: #b71c1c;
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background: #b71c1c;
            color: white;
            padding: 14px;
            width: 100%;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 25px;
            transition: background 0.3s;
        }
        input[type="submit"]:hover {
            background: #7f0000;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>PEMILU 2025 - Dewan Perwakilan Rakyat</h2>
    <form method="POST" action="proses_vote.php">
        <label>Nama:</label>
        <input type="text" name="nama" required>

        <label>NIK:</label>
        <input type="text" name="nik" required>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required>

        <div class="calon-container">
            <label>Pilih Calon:</label>
            <?php
            $result = $conn->query("SELECT * FROM calon");
            while ($row = $result->fetch_assoc()) {
                echo "<label class='calon-option'>
                        <input type='radio' name='calon' value='{$row['id']}' required>
                        {$row['nama_calon']}
                      </label>";
            }
            ?>
        </div>
        <input type="submit" value="Kirim Suara">
    </form>
</div>
</body>
</html>
