<?php 
require_once 'config.php'; 

// Verificăm dacă utilizatorul este logat
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Art Zone - SVG & Canvas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style_canvas.css">
</head>
<body>
    <nav class="navbar navbar-dark px-3">
        <a class="navbar-brand" href="dashboard.php">🌍 Explorer Art Zone</a>
        <div>
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">Înapoi la Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 art-card text-center">
                <h2 class="section-title">Arta Digitală a Călătorului</h2>
                <p class="mb-5">O demonstrație vizuală a tehnologiilor SVG și Canvas pentru proiectul tău.</p>
                
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4">
                        <h4 class="section-title">Insigna (SVG)</h4>
                        <div class="svg-container">
                            <svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="100" cy="100" r="90" fill="#1e3c72" />
                                <circle cx="100" cy="100" r="82" fill="none" stroke="#f1c40f" stroke-width="3" stroke-dasharray="8,4" />
                                
                                <path d="M40 140 L85 55 L130 140 Z" fill="#ecf0f1" />
                                <path d="M90 140 L135 75 L180 140 Z" fill="#bdc3c7" />
                                
                                <circle cx="155" cy="45" r="18" fill="#f1c40f" />
                                
                                <text x="50%" y="175" text-anchor="middle" fill="white" font-size="12" font-family="Montserrat" font-weight="bold">MEMBRU EXPLORER</text>
                            </svg>
                        </div>
                        <p class="text-muted mt-3 small">SVG: Ideal pentru logo-uri și elemente scalabile.</p>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h4 class="section-title">Peisaj (Canvas)</h4>
                        <canvas id="staticCanvas" width="300" height="200"></canvas>
                        <p class="text-muted mt-3 small">Canvas: Ideal pentru desene complexe și prelucrare pixel-cu-pixel.</p>
                    </div>
                </div>

                
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('staticCanvas');
        const ctx = canvas.getContext('2d');

        // 1. Fundal: Cer cu gradient
        const skyGradient = ctx.createLinearGradient(0, 0, 0, 200);
        skyGradient.addColorStop(0, "#2980b9");
        skyGradient.addColorStop(1, "#6dd5fa");
        ctx.fillStyle = skyGradient;
        ctx.fillRect(0, 0, 300, 200);

        // 2. Soarele
        ctx.beginPath();
        ctx.arc(240, 45, 20, 0, Math.PI * 2);
        ctx.fillStyle = "#f1c40f";
        ctx.shadowBlur = 15;
        ctx.shadowColor = "#f1c40f";
        ctx.fill();
        ctx.shadowBlur = 0; // Resetăm umbra pentru restul elementelor

        // 3. Munții Canvas
        function drawMountain(x, height, color) {
            ctx.beginPath();
            ctx.moveTo(x - 80, 200);
            ctx.lineTo(x, 200 - height);
            ctx.lineTo(x + 80, 200);
            ctx.fillStyle = color;
            ctx.fill();
        }

        drawMountain(70, 100, "#2c3e50");
        drawMountain(160, 130, "#34495e");
        drawMountain(250, 90, "#2c3e50");

        // 4. Un mic nor stilizat
        ctx.fillStyle = "rgba(255, 255, 255, 0.85)";
        ctx.beginPath();
        ctx.arc(60, 50, 15, 0, Math.PI * 2);
        ctx.arc(80, 50, 20, 0, Math.PI * 2);
        ctx.arc(100, 50, 15, 0, Math.PI * 2);
        ctx.fill();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>