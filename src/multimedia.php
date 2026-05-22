<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Travel Vlogs</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container bg-white p-4 shadow rounded">
        <h2>🎥 Video-uri din expediții</h2>
        <div class="row">
            <div class="col-md-6">
                <h5>Vlog YouTube </h5>
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/UtZ6nsmp41U" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="col-md-6">
                <h5>Clip local </h5>
                <video width="100%" controls class="rounded">
                    <source src="media/forest.mp4" type="video/mp4">
                </video>
            </div>
            <div class="col-md-4">
            <h4>Audio Local (MP3)</h4>
            <audio controls class="w-100 mt-5"><source src="media/forest.mp3" type="audio/mpeg"></audio>
        </div>
        </div>
        <a href="dashboard.php" class="btn btn-primary mt-4">Înapoi la Blog</a>
    </div>
</body>
</html>