<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start session only if not already started
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-primary bg-opacity-10">
    <div class="container mt-2">
        <a class="navbar-brand fw-bold text-primary" href="index.php">FindUrHome</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Search Bar (visible on large screens) -->
        <form class="d-none d-lg-flex mx-auto ms-5" style="flex: 1; max-width: 500px;" method="POST" action="search.php">
            <input class="form-control me-2" type="search" name="searchName" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>

                <?php if (!isset($_SESSION['user_id'])): // Show "Sign In" if user is not logged in ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sign In</a>
                    </li>
                <?php else: // Show "Profile" if user is logged in ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
