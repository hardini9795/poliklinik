<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #e0e0e0;
        }

        .welcome-section {
            background-color: #000;
            color: #fff;
            padding: 180px; 
            margin-bottom: 50px; 
            text-align: center;
            border-radius: 10px;
        }

        .variation-text {
            font-size: 3rem;
            font-family: 'Arial', cursive; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
            margin-top: 20px; 

        .additional-text {
            font-size: 1.5rem;
            margin-top: 20px; 
        }


        .container {
            padding: 100px;
            margin-top: 50px;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-family: 'Arial', cursive, Arial;
            color: #000;
        }

        .card-text {
            color: #000;
        }

        .btn {
            border-radius: 8px;
            font-family: 'Arial', cursive, Arial;
        }

        .btn-primary {
            background-color: #000;
            border-color: #fff;
        }

        .btn-success {
            background-color: #000;
            border-color: #fff;
        }

        .btn-info {
            background-color: #000;
            border-color: #fff;
        }
    </style>
</head>
<body>
<div class="welcome-section">
    <h1 class="variation-text">Poliklinik</h1>
    <p class="additional-text">Selamat Datang di Website Poliklinik!</p>
</div>


    <div class="container text-center">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Admin</h5>
                        <p class="card-text">Login sebagai admin.</p>
                        <a href="admin/" class="btn btn-primary">Login Admin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dokter</h5>
                        <p class="card-text">Login sebagai dokter.</p>
                        <a href="dokter/" class="btn btn-success">Login Dokter</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pasien</h5>
                        <p class="card-text">Login sebagai pasien.</p>
                        <a href="pasien/" class="btn btn-info">Login Pasien</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
