<?php
include 'db.php';

// Get property id from URL
$property_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Fetch property details from the database
$query = "SELECT * FROM listings WHERE id = $property_id";
$property_result = mysqli_query($conn, $query);

if (!$property_result || mysqli_num_rows($property_result) == 0) {
    echo "Property not found!";
    exit;
}

$property = mysqli_fetch_assoc($property_result);

// Fetch landlord email from the users table based on user_id from listings
$user_id = $property['user_id'];
$user_query = "SELECT email FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);

if (!$user_result || mysqli_num_rows($user_result) == 0) {
    echo "Landlord not found!";
    exit;
}

$user = mysqli_fetch_assoc($user_result);
$landlord_email = $user['email'];

// Fetch property images
$image_query = "SELECT image FROM listing_images WHERE listing_id = $property_id";
$image_result = mysqli_query($conn, $image_query);
$images = [];
while ($row = mysqli_fetch_assoc($image_result)) {
    $images[] = base64_encode($row['image']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $property['name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons/css/boxicons.min.css">

    <style>
        body {
            font-family: Arial, sans-serif; /* Use a clean font for better readability */
            background-color: #f8f9fa; /* Light background for contrast */
        }
        .carousel-inner img {
            height: 500px;
            object-fit: cover;
            width: 100%;
        }
        .icon-text {
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px; /* Add space between icons */
        }
        .icon-text i {
            margin-right: 5px;
            color: black; /* Icon color for better visibility */
        }
        .email-box {
            display: none;
            margin-top: 20px;
            font-weight: bold;
            background-color: aliceblue; 
            padding: 10px 30px;
            border-radius: 5px;
            border: 1px solid blue;
            width: fit-content;
        }
        h1 {
            font-size: 2.5rem; /* Larger font size for property name */
            color: #343a40; /* Dark text color */
        }
        h3 {
            font-size: 1.75rem; /* Size for price */
            color: #28a745; /* Green color for price */
            margin-bottom: 15px; /* Space below price */
        }
        p {
            margin-bottom: 15px; /* Space below paragraphs */
            line-height: 1.5; /* Increased line height for readability */
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            border: none; /* Remove border */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Darker color on hover */
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?> <!-- Include navbar -->

    <div class="container mt-4">
        <!-- Image Carousel -->
        <div id="propertyCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($images as $index => $image): ?>
                    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="data:image/jpeg;base64,<?php echo $image; ?>" class="d-block w-100" alt="Property Image">
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row mt-4">
            <div class="col-lg-8 mb-5">
                <!-- Property Details -->
                <h1><?php echo $property['name']; ?></h1>
                <h3 class="text-success" >Rs. <?php echo $property['regular_price']; ?></h3>

                <!-- Display if rent or sale -->
                <div>
                <p class="icon-text" style="padding: 10px;background-color: aliceblue ;border: 1px solid blue; border-radius: 5px;">
                    <i class='bx bx-dollar'></i>
                    <?php echo $property['type'] == 'Rent' ? 'For Rent' : 'For Sale'; ?>
                </p>
                </div>

                <div>
                <!-- Address with location icon -->
                <p class="icon-text">
                    <i class='bx bxs-map'></i>
                    <?php echo $property['address']; ?>
                </p>
                </div>
                
                <!-- Display offer/discount if available -->
                <?php if ($property['offer']): ?>
                    <p class="text-danger">
                        <strong>Discounted Price: Rs. <?php echo $property['discounted_price']; ?></strong>
                    </p>
                <?php endif; ?>

                <!-- Description -->
                <p><?php echo $property['description']; ?></p>

                <!-- Property Features with Icons -->
                <p class="icon-text" style="margin-right: 20px;">
                    <i class='bx bxs-bed'></i><?php echo $property['beds']; ?> Beds
                </p>
                <p class="icon-text"style="margin-right: 20px;">
                    <i class='bx bxs-bath' ></i> <?php echo $property['baths']; ?> Baths
                </p>
                <p class="icon-text" style="margin-right: 20px;">
                    <i class='bx bxs-car' ></i> <?php echo $property['parking_spot'] ? 'Parking Available' : 'No Parking'; ?>
                </p>
                <p class="icon-text" style="margin-right: 20px;">
                    <i class='bx bxs-building-house'></i><?php echo $property['furnished'] ? 'Furnished' : 'Not Furnished'; ?>
                </p>

                <!-- Contact Landlord Button -->
                <div>
                <button id="contactLandlordBtn" class="btn btn-primary">Contact Landlord</button>
                </div>
                <!-- Display Landlord's Email -->
                <div class="email-box">
                    <p>Landlord's Email: <span id="landlordEmail"><?php echo $landlord_email; ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Toggle the email box when the Contact Landlord button is clicked
        document.getElementById('contactLandlordBtn').addEventListener('click', function() {
            var emailBox = document.querySelector('.email-box');
            emailBox.style.display = emailBox.style.display === 'block' ? 'none' : 'block';
        });
    </script>
</body>
</html>
