<?php
session_start();
include("config.php");

// Retrieve user type from session
$user_type = $_SESSION['type'];

$query = "SELECT * FROM competitions WHERE type = '$user_type'";
$result = mysqli_query($conn, $query);

$competitions = array();

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $competitions[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .card-text {
            color: #666;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="mt-3">
        <div class="row justify-content-end">
            <div class="col-auto">
                <a class="btn btn-danger" href="index.php">Log out</a>
            </div>
        </div>
        <div class="container">
            <h1 class="text-center mt-5">Competitions</h1>
            <div class="row mt-4">
                <?php foreach ($competitions as $competition) { ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $competition['competitionName']; ?></h5>
                                <p class="card-text">Score: <?php echo $competition['score']; ?></p>
                                <p class="card-text">Type: <?php echo $competition['type']; ?></p>
                                <p class="card-text"><?php echo $competition['description']; ?></p>
                                <a href="addteams.php?competitionName=<?php echo $competition['competitionName']; ?>&type=<?php echo $competition['type']; ?>" class="btn btn-primary btn-block" 
                                   onclick="sessionStorage.setItem('competitionName', '<?php echo $competition['competitionName']; ?>')">Join</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a class='btn btn-success' href='score.php' >Show Score</a>
        </div>
    </div>
</body>
</html>
