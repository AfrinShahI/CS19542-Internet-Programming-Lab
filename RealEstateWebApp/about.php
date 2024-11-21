<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FindUrHome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }
        .hero {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease-in;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            transform: translateX(-50%);
            z-index: 1;
        }
        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            z-index: 2;
            position: relative;
        }
        h2 {
            font-size: 2.5rem;
            margin-top: 20px;
            color: #343a40;
            z-index: 2;
            position: relative;
        }
        p {
            font-size: 1.2rem;
            margin: 15px 0;
            z-index: 2;
            position: relative;
        }
        .about-text{
            text-align: justify;
        }
        .card {
            border: none;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .team-section {
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin: 200px;
        }
        .team-member {
            border-radius: 50%;
            height: 250px;
            width: 250px;
            object-fit: cover;
            transition: transform 0.3s;
           }
        
        .team-member {
            transition: transform 0.3s;
            text-align: center;
        }
        .team-member:hover {
            transform: scale(1.05);
        }
        
        .team-section {
            transition: transform 0.3s;
            text-align: center;
        }
        .team-section:hover {
            transform: scale(1.05);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <section class="hero">
        <div class="container">
            <h1>About Us</h1>
            <p>At FindUrHome, we strive to make your home-finding journey seamless and enjoyable.</p>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="text-center">Our Mission</h2>
        <p class="text-center">We aim to connect individuals and families with their dream homes, offering a comprehensive platform for buying and renting properties. Our user-friendly interface and dedicated support team ensure that your experience is hassle-free and efficient.</p>

        <h2 class="text-center mt-4">What We Do</h2>
        <p class="text-center">FindUrHome offers a diverse range of listings to cater to different needs and budgets. Whether you're looking to rent an apartment or purchase a house, we've got you covered!</p>
    </div>

    <section class="team-section mt-5">
        <div class="container">
            <h2 class="text-center">Contact Me</h2>
            <div class="row mt-4 justify-content-center align-items-center">
                <div class="col-md-6 text-center">
                    <img src="pic2.png" class="img-fluid mx-auto team-member" alt="Afrin Fathima I">
                    <h5 class="mt-3">Afrin Fathima I</h5>
                    <p class="card-text">Developer</p>
                    <p><a href="mailto:afrin.shah2004@gmail.com">Contact Me</a></p>
                </div>
                <div class="col-md-6 about-text">
                    <p>I am passionate about developing innovative web applications using PHP, JavaScript, PHP, and Python. With skills in Web Development, RPA using UiPath, I thrive on solving complex problems.</p>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
