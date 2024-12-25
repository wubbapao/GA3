<?php
session_start();
include('db.php');

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Redirect logged-in users to the dashboard or main page
    header("Location: index.php");
    exit();
}

// Fetch all products from the database for visitor viewing
$productResults = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to FOODZIE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        body {
            background: url('images/bgimageforhome.png') no-repeat center center/cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .welcome-banner {
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding: 50px 20px;
        }
        .welcome-banner h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .btn-container {
            margin-top: 20px;
        }
        #products {
            padding: 50px 20px;
            background-color: #f8f9fa;
        }
        .product img {
            height: 200px;
            object-fit: cover;
        }
        .product {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        .footer {
            background-color: #111;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Welcome Section -->
    <section class="welcome-banner">
        <h1>Welcome to FOODZIE</h1>
        <p>Your gateway to authentic Filipino dishes.</p>
        <div class="btn-container">
            <a href="login.php" class="btn btn-primary btn-lg">Login</a>
            <a href="signup.php" class="btn btn-secondary btn-lg">Sign Up</a>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products">
        <div class="container">
            <h2 class="text-center mb-4">Our Products</h2>
            <div class="row g-3">
                <?php if ($productResults && $productResults->num_rows > 0): ?>
                    <?php while ($row = $productResults->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="product card h-100">
                                <?php if (!empty($row['image']) && file_exists("images/" . $row['image'])): ?>
                                    <img src="images/<?= htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']); ?>">
                                <?php else: ?>
                                    <img src="images/default.jpg" class="card-img-top" alt="Default Image">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($row['description']); ?></p>
                                    <p class="price">₱<?= number_format($row['price'], 2); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No products available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 FOODZIE. All rights reserved.</p>
    </footer>
</body>
</html>
