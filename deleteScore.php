
<?php 
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['competitionName']) && isset($_POST['teamName'])) {
    $competitionName = $_POST['competitionName'];
    $teamName = $_POST['teamName'];
    $sql = "DELETE FROM score WHERE competitionName='$competitionName' AND teamName='$teamName'";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: admin_score.php');
        exit;
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
} else {
    echo 'Error: Invalid request.';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Score</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 500px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        button[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #c82333;
        }
        a {
            display: block;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            margin-top: 20px;
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
</div>

<div class="container">
    <h1>Delete Score</h1>
    <?php 
        include("config.php");

        if (isset($_GET['competitionName']) && isset($_GET['teamName'])) {
            $competitionName = $_GET['competitionName'];
            $teamName = $_GET['teamName'];
            $sql = "SELECT * FROM score WHERE competitionName='$competitionName' AND teamName = '$teamName'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
    ?>
    <form action="deleteScore.php" method="post">
        <p>Are you sure you want to delete the competition "<?php echo $row['competitionName']; ?>"?</p>
        <input type="hidden" name="competitionName" value="<?php echo $row['competitionName']; ?>">
        <input type="hidden" name="teamName" value="<?php echo $row['teamName']; ?>">
        <br>
        <button type="submit" class="btn btn-danger">Delete Score</button>
    </form>
    <a href="admin.php" class="btn btn-primary">Back to competition list</a>
    <?php
        } else {
            echo 'Error: No data found for the specified competition and team.';
        }
    }
    ?>
</div>

</body>
</html>
