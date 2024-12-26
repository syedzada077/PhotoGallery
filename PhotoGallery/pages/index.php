<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include your database connection file
include 'db_connection.php';

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT full_name, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Determine selected category
$category = isset($_GET['category']) ? $_GET['category'] : 'All';

// Fetch posts based on category
if ($category === 'All') {
    $sql_posts = "SELECT title, picture, category FROM posts";
} else {
    $sql_posts = "SELECT title, picture, category FROM posts WHERE category = ?";
}

$stmt_posts = $conn->prepare($sql_posts);
if ($category !== 'All') {
    $stmt_posts->bind_param("s", $category);
}
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();
$uploaded_pictures = $result_posts->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home - Pintereso Bootstrap Template</title>
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
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
            z-index: 1000;
        }
        .popup-content {
            position: relative;
            margin: 10% auto;
            padding: 20px;
            width: 80%;
            max-width: 700px;
            background-color: #fff;
            border-radius: 10px;
        }
        .popup-content img {
            width: 100%;
            height: auto;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: red;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <a class="navbar-brand font-weight-bolder mr-3" href="index.php"><img src="assets/img/logo.png"></a>
    <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsDefault">
        <ul class="navbar-nav ml-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="post.php">Post</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    <img class="rounded-circle mr-2 cover" src="<?php echo htmlspecialchars($user['profile_picture']); ?>" width="30" height="30">
                    <span class="align-middle"><?php echo htmlspecialchars($user['full_name']); ?></span>
                </a>
            </li>
        </ul>
    </div>
</nav>
<main role="main">
    <section class="mt-4 mb-5">
	<div class="container mb-4">
    <h1 class="font-weight-bold title">Explore</h1>
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-white pl-2 pr-2">
            <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExplore" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExplore">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=All">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=Lifestyle">Lifestyle</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=Food">Food</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=Home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?category=Travel">Travel</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">More</a>
                        <div class="dropdown-menu shadow-lg" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="index.php?category=Astronomy">Astronomy</a>
                            <a class="dropdown-item" href="index.php?category=Nature">Nature</a>
                            <a class="dropdown-item" href="index.php?category=Cooking">Cooking</a>
                            <a class="dropdown-item" href="index.php?category=Fashion">Fashion</a>
                            <a class="dropdown-item" href="index.php?category=Wellness">Wellness</a>
                            <a class="dropdown-item" href="index.php?category=Dieting">Dieting</a>
                            <a class="dropdown-item" href="index.php?category=Technology">Technology</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

        <div class="container-fluid">
            <div class="row">
                <div class="card-columns">
                    <?php foreach ($uploaded_pictures as $post): ?>
                    <div class="card card-pin">
                        <img class="card-img" src="<?php echo htmlspecialchars($post['picture']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                        <div class="overlay">
                            <h2 class="card-title title"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <div class="more">
                                <a href="#">
                                    <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> More
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>
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

<!-- Popup Modal -->
<div id="imagePopup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <img id="popupImage" src="" alt="Image">
        <a id="downloadButton" href="" download="image.jpg" class="btn btn-primary">Download Image</a>
    </div>
</div>

<script src="assets/js/app.js"></script>
<script src="assets/js/theme.js"></script>
<script>
    // Function to open the popup with the selected image
    function openPopup(imageSrc) {
        document.getElementById('popupImage').src = imageSrc;
        document.getElementById('downloadButton').href = imageSrc;
        document.getElementById('imagePopup').style.display = 'block';
    }

    // Function to close the popup
    document.querySelector('.close').onclick = function() {
        document.getElementById('imagePopup').style.display = 'none';
    }

    // Add event listeners to all "More" buttons
    document.querySelectorAll('.more a').forEach(function(el) {
        el.onclick = function(event) {
            event.preventDefault();
            var imageSrc = this.closest('.card').querySelector('.card-img').src;
            openPopup(imageSrc);
        };
    });
</script>

</body>
</html>
