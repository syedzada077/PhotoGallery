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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];

    // File upload handling
    $target_dir = "photos/";
    $target_file = $target_dir . basename($_FILES["pictureFile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["pictureFile"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["pictureFile"]["size"] > 10000000) { // 500KB max file size
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["pictureFile"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["pictureFile"]["name"])). " has been uploaded.";

            // Insert data into database
            $sql = "INSERT INTO posts (user_id, title, category, picture, full_name, profile_picture) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isssss", $user_id, $title, $category, $target_file, $user['full_name'], $user['profile_picture']);
            
            if ($stmt->execute()) {
                echo "New record created successfully";
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload Picture - PhotoGallery</title>
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
        /* Styling for image preview */
        #previewContainer {
            margin-top: 20px;
        }
        #imagePreview {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 5px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <a class="navbar-brand font-weight-bolder mr-3" href="index.php"><img src="assets/img/logo.png"></a>
        <button class="navbar-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsDefault">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="post.php">Post</a>
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

    <!-- Main Content -->
    <div class="container min-50vh mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h2 class="text-center mb-4">Upload Your Picture</h2>
                <form id="uploadForm" action="post.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                        <label for="pictureFile">Upload Picture</label>
                        <input type="file" name="pictureFile" class="form-control-file" id="pictureFile" accept="image/*" required>
                        <div id="previewContainer" class="text-center">
                            <img id="imagePreview" src="assets/img/icons8-image-100.png" alt="No File Chosen">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pictureTitle">Title</label>
                        <input type="text" name="title" class="form-control" id="pictureTitle" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label for="pictureCategory">Category</label>
                        <select name="category" class="form-control" id="pictureCategory" required>
                            <option value="">Select Category</option>
                            <option value="Dieting">Dieting</option>
                            <option value="Technology">Technology</option>
                            <option value="Wellness">Wellness</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Cooking">Cooking</option>
                            <option value="Nature">Nature</option>
                            <option value="Astronomy">Astronomy</option>
                            <option value="Travel">Travel</option>
                            <option value="Home">Home</option>
                            <option value="Food">Food</option>
                            <option value="Lifestyle">Lifestyle</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
    <script>
        document.getElementById('pictureFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
