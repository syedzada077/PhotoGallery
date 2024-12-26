<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "photogallery";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['signupName'];
    $email = $_POST['signupEmail'];
    $password = password_hash($_POST['signupPassword'], PASSWORD_BCRYPT);
    $profilePicture = $_FILES['signupProfilePicture'];

    // Save profile picture
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($profilePicture["name"]);
    if (move_uploaded_file($profilePicture["tmp_name"], $targetFile)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, profile_picture) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullName, $email, $password, $targetFile);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $id;
            $_SESSION['full_name'] = $fullName;
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Signup - PhotoGallery</title>
    <script type="text/javascript">
        (function() {
            var css = document.createElement('link');
            css.href = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
            css.rel = 'stylesheet';
            css.type = 'text/css';
            document.getElementsByTagName('head')[0].appendChild(css);
        })();
    </script>
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/theme.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <a class="navbar-brand font-weight-bolder mr-3" href="#"><img src="assets/img/logo.png"></a>
        <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsDefault">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="signup.php">Signup</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container min-50vh mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Sign Up for Photo Gallery</h2>
                <form action="signup.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="signupName">Full Name</label>
                <input type="text" class="form-control" id="signupName" name="signupName" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="signupEmail">Email address</label>
                <input type="email" class="form-control" id="signupEmail" name="signupEmail" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="signupPassword">Password</label>
                <input type="password" class="form-control" id="signupPassword" name="signupPassword" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="signupConfirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="signupConfirmPassword" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <label for="signupProfilePicture">Profile Picture</label>
                <input type="file" class="form-control-file" id="signupProfilePicture" name="signupProfilePicture" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            <div class="text-center mt-3">
                <span>Already have an account? <a href="login.php">Login</a></span>
            </div>
        </form>
            </div>
        </div>
    </div>
    <footer class="footer pt-5 pb-5 text-center">
        <div class="container">
            <div class="socials-media">
                <ul class="list-unstyled">
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-facebook"></i></a></li>
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-twitter"></i></a></li>
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-instagram"></i></a></li>
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-google-plus"></i></a></li>
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-behance"></i></a></li>
                    <li class="d-inline-block ml-1 mr-1"><a href="#" class="text-dark"><i class="fa fa-dribbble"></i></a></li>
                </ul>
            </div>
            <p>©  <span class="credits font-weight-bold">        
                <a target="_blank" class="text-dark" href="#"><u>Made By Saif Ur Rehman And Talha Tanveer</u></a>
            </span>
            </p>
        </div>
    </footer>    

    <!-- Bootstrap and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
