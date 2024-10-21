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
            <h1 class="display-5 fw-bold ">Enjoy a hassle-free journey to your next dream residence!</h1>
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

</body>
</html>
