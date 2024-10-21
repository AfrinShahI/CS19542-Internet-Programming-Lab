<?php
session_start(); // Start the session

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php'; // Include the database connection

$message = ''; // Initialize message variable

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $parking_spot = isset($_POST['parking_spot']) ? 1 : 0;
    $furnished = isset($_POST['furnished']) ? 1 : 0;
    $offer = isset($_POST['offer']) ? 1 : 0;
    $regular_price = $_POST['regular_price'];
   
    $discounted_price = isset($_POST['discounted_price']) && $_POST['discounted_price'] !== '' 
        ? mysqli_real_escape_string($conn, $_POST['discounted_price']) 
        : 'NULL'; // Use NULL if not set
    
    $beds = $_POST['beds'];
    $baths = $_POST['baths'];

    // Prepare and execute the SQL statement for the listing
    $sql = "INSERT INTO listings (user_id, name, description, address, type, parking_spot, furnished, offer, regular_price, discounted_price, beds, baths)
            VALUES ('" . $_SESSION['user_id'] . "', '$name', '$description', '$address', '$type', $parking_spot, $furnished, $offer, $regular_price, $discounted_price, $beds, $baths)";

    if (mysqli_query($conn, $sql)) {
        $listing_id = mysqli_insert_id($conn); // Get the last inserted ID for images

        // Handle image uploads
        if (!empty($_FILES['images']['name'][0])) {
            $totalFiles = count($_FILES['images']['name']);
            for ($i = 0; $i < $totalFiles; $i++) {
                $tempPath = $_FILES['images']['tmp_name'][$i];
                $image = file_get_contents($tempPath);
                $image = mysqli_real_escape_string($conn, $image); // Escape the binary data

                // Prepare and execute the SQL statement for image upload
                $imageSql = "INSERT INTO listing_images (listing_id, image) VALUES ($listing_id, '$image')";
                if (!mysqli_query($conn, $imageSql)) {
                    $message = "<p class='text-danger text-center'>Failed to upload image.</p>";
                }
            }
        }

        $message = "<p class='text-success text-center'>Listing created successfully!</p>";
    } else {
        $message = "<p class='text-danger text-center'>Failed to create listing. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Listing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function toggleOfferFields() {
            const offerCheckbox = document.getElementById('offer');
            const regularPriceField = document.getElementById('regular_price');
            const discountedPriceField = document.getElementById('discounted_price');
            const regularPriceDiv = document.getElementById('regular_price_div');
            const discountedPriceDiv = document.getElementById('discounted_price_div');

            if (offerCheckbox.checked) {
                regularPriceDiv.style.display = 'block';
                discountedPriceDiv.style.display = 'block';
                regularPriceField.setAttribute('required', 'required');
                discountedPriceField.setAttribute('required', 'required');
            } else {
                regularPriceField.value = '';
                discountedPriceField.value = '';
                regularPriceDiv.style.display = 'none';
                discountedPriceDiv.style.display = 'none';
                regularPriceField.removeAttribute('required');
                discountedPriceField.removeAttribute('required');
            }
        }
    </script>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Create Listing</h2>
        <?php echo $message; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Sell or Rent:</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="Sell">Sell</option>
                    <option value="Rent">Rent</option>
                </select>
            </div>

            <div class="form-check">
                <input type="checkbox" id="parking_spot" name="parking_spot" class="form-check-input">
                <label class="form-check-label" for="parking_spot">Parking Spot</label>
            </div>

            <div class="form-check">
                <input type="checkbox" id="furnished" name="furnished" class="form-check-input">
                <label class="form-check-label" for="furnished">Furnished</label>
            </div>

            <div class="form-check">
                <input type="checkbox" id="offer" name="offer" class="form-check-input" onclick="toggleOfferFields()">
                <label class="form-check-label" for="offer">Offer</label>
            </div>

            <div class="mb-3" id="regular_price_div">
                <label for="regular_price" class="form-label">Regular Price (Rs. / Month):</label>
                <input type="number" min="5000" id="regular_price" name="regular_price" class="form-control" required>
            </div>
            <div class="mb-3" id="discounted_price_div" style="display: none;">
                <label for="discounted_price" class="form-label">Discounted Price (Rs. / Month):</label>
                <input type="number" id="discounted_price" name="discounted_price" class="form-control">
            </div>

            <div class="mb-3">
                <label for="beds" class="form-label">Beds:</label>
                <input type="number" id="beds" name="beds" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="baths" class="form-label">Baths:</label>
                <input type="number" id="baths" name="baths" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="images" class="form-label">Upload Images:</label>
                <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple required>
            </div>

            <button type="submit" class="btn btn-primary">Create Listing</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
