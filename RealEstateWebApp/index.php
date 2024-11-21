<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindUrHome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .carousel {
            margin: auto;
            object-fit: cover;
        }
        .carousel-item img {
            height: 600px;
        }
        .card {
            height: 500px; /* Set a fixed height for the card */
            overflow: hidden; /* Hide overflow content */
        }
        .card-body {
            padding: 15px; /* Add padding to the card body */
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-2 d-lg-none mb-2">
        <form class="d-flex" action="search.php" method="GET">
            <input class="form-control me-2" type="search" name="query" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>
    </div>

    <section class="hero bg-light text-start py-5">
        <div class="container col-lg-8 col-10 ms-lg-5 ms-3 mb-5 me-lg-5 me-3">
            <h1 class="display-5 fw-bold">Enjoy a hassle-free journey to your next dream residence!</h1>
            <p class="lead mt-5" style="line-height: 2.0rem">Welcome to FindUrHome, your premier destination for renting and buying homes. Explore a diverse range of properties tailored to fit your lifestyle and budget. Let us help you find your dream home and connect with the perfect leads in the real estate market!</p>
            <a href="search.php" class="text-primary ms-0 mt-4 text-decoration-none" style="font-size: 1.3rem">Find Your Home Now...</a>
        </div>
    </section>

    <div id="homeCarousel" class="carousel slide mt-5 ms-lg-5 ms-3 mb-5 me-lg-5 me-3" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="properties/prop1.jpeg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="properties/prop2.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="properties/prop3.jpg" class="d-block w-100" alt="Image 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4">Recent Properties</h2>
        <div class="row">
            <?php
            // Connection to the database
            include 'db.php';

            // Fetch recent listings (you can modify the query as needed)
            $recent_query = "SELECT listings.* FROM listings ORDER BY id DESC LIMIT 6"; // Get the latest 6 listings
            $recent_result = mysqli_query($conn, $recent_query);

            if ($recent_result) {
                while ($listing = mysqli_fetch_assoc($recent_result)) {
                    // Fetch images for the listing
                    $image_query = "SELECT image FROM listing_images WHERE listing_id = " . $listing['id'] . " LIMIT 1"; // Get the first image only
                    $image_result = mysqli_query($conn, $image_query);
                    $image = mysqli_fetch_assoc($image_result);
                    $image_src = $image ? 'data:image/jpeg;base64,' . base64_encode($image['image']) : 'default_image_path.jpg'; // Fallback image

                    ?>
                    <div class="col-md-4 mb-4">
                        <a href="property.php?id=<?php echo $listing['id']; ?>" style="text-decoration: none; color: inherit;">
                            <div class="card">
                                <img src="<?php echo $image_src; ?>" class="card-img-top" alt="Property Image">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $listing['name']; ?></h3>
                                    <p class="card-text"><?php echo $listing['description']; ?></p>
                                    <p class="card-text text-success" style="font-size: 1.5rem;">Rs.<?php echo $listing['regular_price']; ?> / month</p>
                                    <p class="card-text text-secondary" style="display: inline-block; margin-right: 10px"><strong><?php echo $listing['beds']; ?> Beds</strong></p>
                                    <p class="card-text text-secondary" style="display: inline-block; margin-right: 10px"><strong><?php echo $listing['baths']; ?> Baths</strong></p>
                                    <p class="card-text text-secondary"><strong>Location: </strong><?php echo $listing['address']; ?></p> 
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo '<p>No recent listings available.</p>';
            }
            ?>
        </div>
    </div>

</body>
</html>
