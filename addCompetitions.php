<?php
include("config.php");

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $competitionName = $_POST['competitionName'];
    $score = $_POST['score'];
    $type = $_POST['type'];
    $description = $_POST['description'];

    $sql = "INSERT INTO competitions (competitionName, score, type, description) VALUES ('$competitionName', $score, '$type', '$description')";
    if($conn->query($sql) === TRUE){
        header('Location: admin.php');
        exit;
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Competition</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class=" mt-3">
        <div class="row justify-content-end">
            <div class="col-auto">
                <a class="btn btn-danger" href="index.php">Log out</a>
            </div>
        </div>

    <div class="container">
        <h2>Add Competition</h2>
        <form action="addCompetitions.php" method="post">
            <div class="form-group">
                <label for="competitionName">Competition Name:</label>
                <input type="text" id="competitionName" name="competitionName" required>
            </div>
            <div class="form-group">
                <label for="score">Score:</label>
                <input type="number" id="score" name="score" required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" id="type" name="type" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
            </div>
        </form>
    </div>
</body>
</html>
