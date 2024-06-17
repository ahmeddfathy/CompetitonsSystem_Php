<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Competition</title>
   
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
            margin-bottom: 40px !important; 
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        input {
            margin-bottom: 20px !important;
        }
        a {
            margin-top: 20px !important;
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
    <h1>Edit Competition</h1>
    <form method="post">
        <?php 
        include("config.php");
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $competitionName = $_POST['competitionName'];
            $score = $_POST['score'];
            $type = $_POST['type'];
            $description = $_POST['description'];

            $sql = "UPDATE competitions SET score = $score, type = '$type', description = '$description' WHERE competitionName = '$competitionName'";
            if($conn->query($sql) === TRUE){
                header('Location: admin.php');
                exit;
            } else {
                echo 'Error: ' . $sql . '<br>' . $conn->error;
            }
        } elseif(isset($_GET['competitionName'])){
            $competitionName = $_GET['competitionName'];
            $sql = "SELECT * FROM competitions WHERE competitionName='$competitionName'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
        }
        ?>
        
        <input type="hidden" name="competitionName" value="<?php echo $row['competitionName']; ?>">
        <label for="score">Score:</label>
        <input type="number" id="score" class="form-control" placeholder="Score" name="score" value="<?php echo $row['score']; ?>"> 
        <label for="type">Type:</label>
        <input type="text" id="type" class="form-control" placeholder="Type" name="type" value="<?php echo $row['type']; ?>">
        <label for="description">Description:</label>
        <input type="text" id="description" class="form-control" placeholder="Description" name="description" value="<?php echo $row['description']; ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <a href="admin.php" class="btn btn-secondary">Back to competition list</a>
</div>

</body>
</html>
