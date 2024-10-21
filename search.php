<?php
// Connection to the database
include 'db.php';

// Fetch search results based on user inputs
$type_filter = isset($_POST['type']) ? $_POST['type'] : [];
$parking_filter = isset($_POST['parking']) ? 1 : 0;
$furnished_filter = isset($_POST['furnished']) ? 1 : 0;
$offer_filter = isset($_POST['offer']) ? 1 : 0; // New filter for offers
$sort_option = isset($_POST['sort']) ? $_POST['sort'] : 'latest';
$search_name = isset($_POST['searchName']) ? mysqli_real_escape_string($conn, trim($_POST['searchName'])) : '';

// Build the query dynamically
$query = "SELECT listings.* FROM listings WHERE 1=1";

if (!empty($search_name)) {
    $query .= " AND (name LIKE '%$search_name%' OR description LIKE '%$search_name%' OR address LIKE '%$search_name%')";
}

if (!empty($type_filter)) {
    $types = implode("', '", $type_filter);
    $query .= " AND type IN ('$types')";
}

if ($parking_filter) {
    $query .= " AND parking_spot = 1";
}

if ($furnished_filter) {
    $query .= " AND furnished = 1";
}

if ($offer_filter) { // Add condition for offers
    $query .= " AND offer = 1"; // Assuming you have a column 'offer' in your 'listings' table
}

// Sorting option
switch ($sort_option) {
    case 'oldest':
        $query .= " ORDER BY listings.id ASC";
        break;
    case 'price_high_low':
        $query .= " ORDER BY regular_price DESC";
        break;
    case 'price_low_high':
        $query .= " ORDER BY regular_price ASC";
        break;
    default:
        $query .= " ORDER BY listings.id DESC";
        break;
}

$result = mysqli_query($conn, $query);
$listings = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $listings[$row['id']] = $row; // Store listings by ID
        $listings[$row['id']]['images'] = []; // Initialize images array
    }
}

// Fetch images for the listings
if (!empty($listings)) {
    $listing_ids = implode(',', array_keys($listings));
    $image_query = "SELECT listing_id, image FROM listing_images WHERE listing_id IN ($listing_ids)";
    $image_result = mysqli_query($conn, $image_query);

    while ($image_row = mysqli_fetch_assoc($image_result)) {
        $listing_id = $image_row['listing_id'];
        if (isset($listings[$listing_id])) {
            $listings[$listing_id]['images'][] = base64_encode($image_row['image']); // Add image to the listing
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">

    <style>
        .card {
            height: 500px; /* Set a fixed height for the card */
            overflow: hidden; /* Hide overflow content */
        }

        .carousel-inner img {
            height: 250px; /* Set a fixed height for carousel images */
            object-fit: cover; /* Scale images to cover the area while maintaining aspect ratio */
            width: 100%; /* Ensure the image takes the full width */
        }

        .card-body {
            padding: 15px; /* Add padding to the card body */
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?> 

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-4 mb-5">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="searchName" class="form-label">Search Property</label>
                        <input type="text" class="form-control" id="searchName" name="searchName" value="<?php echo htmlspecialchars($search_name); ?>">
                    </div>

                    <div class="mb-3">
                        <label>Type</label><br>
                        <div style="display: flex; gap:120px;">
                            <div style="display: inline-block;">
                                <input type="checkbox" name="type[]" value="Sell" style="margin-right: 5px;"> Sale  
                            </div>
                            <div style="display: inline-block;">
                                <input type="checkbox" name="type[]" value="Rent" style="margin-right: 5px;"> Rent
                            </div>
                            <div style="display: inline-block;">
                                <input type="checkbox" name="offer" value="1" style="margin-right: 5px;"> Offer
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Amenities</label><br>
                        <div style="display: flex; gap:100px;">
                            <div style="display: inline-block;">
                                <input type="checkbox" name="parking" value="1" style="margin-right: 5px;"> Parking
                            </div>
                            <div style="display: inline-block;">
                                <input type="checkbox" name="furnished" value="1" style="margin-right: 5px;"> Furnished
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="sort" class="form-label">Sort By</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="latest">Latest</option>
                            <option value="oldest">Oldest</option>
                            <option value="price_high_low">Price High to Low</option>
                            <option value="price_low_high">Price Low to High</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>

            <div class="col-lg-8">
                <div class="row">
                    <?php
                    if (!empty($listings)) {
                        foreach ($listings as $listing) {
                            ?>
                            <div class="col-md-6 mb-5">
                                <a href="property.php?id=<?php echo $listing['id']; ?>" style="text-decoration: none; color: inherit;">
                                    <div class="card">
                                        <div id="carousel<?php echo $listing['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                if (!empty($listing['images'])) {
                                                    foreach ($listing['images'] as $index => $image) {
                                                        $active_class = $index === 0 ? 'active' : '';
                                                        ?>
                                                        <div class="carousel-item <?php echo $active_class; ?>">
                                                            <img src="data:image/jpeg;base64,<?php echo $image; ?>" class="d-block w-100" alt="Property Image">
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $listing['id']; ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $listing['id']; ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <h3 class="card-title"><?php echo $listing['name']; ?></h3>
                                            <p class="card-text"><?php echo $listing['description']; ?></p>
                                            <i class='bx bxs-map' style="margin-right:10px; "></i><p class="card-text" style="display: inline-block;"><?php echo $listing['address']; ?></p>
                                            <p class="card-text text-success" style="font-size: 1.5rem;">Rs.<?php echo $listing['regular_price']; ?> / month</p>
                                            <p class="card-text text-secondary" style="display: inline-block; margin-right: 10px"><strong> <?php echo $listing['beds']; ?> Beds </strong></p>  
                                            <p class="card-text text-secondary" style="display: inline-block; margin-right: 10px"><strong> <?php echo $listing['baths']; ?> Baths</strong></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No listings found</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
