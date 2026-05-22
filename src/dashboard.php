<?php require_once 'config.php'; 
if(!isset($_SESSION['user_id'])) header("Location: login.php");

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Acum extragem TOATE postările pentru TOȚI utilizatorii
// Filtrarea se face doar în funcție de textul căutat în bara de search
$query = "SELECT trips.*, users.username FROM trips 
          JOIN users ON trips.user_id = users.id 
          WHERE trips.location_name LIKE ? 
          ORDER BY trips.uploaded_at DESC";
$params = ["%$search%"];

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$trips = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Travel Dashboard</title>
    <link rel="stylesheet" href="css/style_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary px-3">
        <span class="navbar-brand">🌍 TravelBlog: <?=$_SESSION['username']?></span>
        <div>
            <a href="canvas_svg.php" class="btn btn-sm btn-light">Canvas/SVG</a>
            <a href="map.php" class="btn btn-sm btn-light">Harta</a>
            <a href="multimedia.php" class="btn btn-sm btn-light">Vlog</a>
            <a href="logout.php" class="btn btn-sm btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <form action="dashboard.php" method="GET" class="search-bar d-flex shadow-sm rounded">
                    <input type="text" name="search" class="form-control" placeholder="Caută o destinație..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Caută</button>
                    <?php if($search): ?>
                        <a href="dashboard.php" class="btn btn-link text-white bg-secondary ms-2 rounded-pill">Reset</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card p-4 mb-5 shadow-sm border-0 glass-effect">
            <h4 class="mb-3">Unde ai mai fost?</h4>
            <form action="upload.php" method="POST" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-5">
                    <input type="text" name="loc" class="form-control" placeholder="Numele locației" required>
                </div>
                <div class="col-md-5">
                    <input type="file" name="img" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Postează</button>
                </div>
            </form>
        </div>

        <div class="row">
            <?php if(count($trips) > 0): ?>
                <?php foreach($trips as $t): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 trip-card">
                        <img src="<?= $t['image_path'] ?>" class="card-img-top" onerror="this.src='https://via.placeholder.com/400x250?text=Fara+Imagine'">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($t['location_name']) ?></h5>
                            <p class="text-muted small">By: <?= htmlspecialchars($t['username']) ?></p>
                            
                            <div class="d-flex gap-2">
                                <?php 
                                // Verificăm dacă userul logat este autorul pozei SAU dacă este admin
                                if ($t['user_id'] == $_SESSION['user_id'] || $_SESSION['role'] == 'admin'): 
                                ?>
                                    <button class="btn btn-warning btn-sm flex-fill text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $t['id'] ?>">Edit</button>
                                    <form action="delete_file.php" method="POST" class="flex-fill">
                                        <input type="hidden" name="trip_id" value="<?= $t['id'] ?>">
                                        <button class="btn btn-danger btn-sm w-100" onclick="return confirm('Sigur ștergi?')">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary btn-sm w-100" disabled>View Only</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editModal<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="edit_file.php" method="POST" enctype="multipart/form-data" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editare: <?= htmlspecialchars($t['location_name']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="trip_id" value="<?= $t['id'] ?>">
                                <div class="mb-3">
                                    <label>Locație nouă:</label>
                                    <input type="text" name="new_loc" class="form-control" value="<?= htmlspecialchars($t['location_name']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label>Schimbă poza (opțional):</label>
                                    <input type="file" name="new_img" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Salvează</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-5"><h3 class="text-white">Niciun rezultat găsit.</h3></div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>