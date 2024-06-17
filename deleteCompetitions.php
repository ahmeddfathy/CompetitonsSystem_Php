<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Competition</title>
  
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
            color: #dc3545; 
        }
        p {
            text-align: center;
            margin-bottom: 20px;
            color: #6c757d; 
        }
        button[type="submit"] {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
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

<div class="container">
    <h1>Delete Competition</h1>
    <form action="deleteCompetitions.php" method="post">
    <?php 
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $competitionName = $_POST['competitionName'];

    
    $sql = "DELETE FROM competitions WHERE competitionName = '$competitionName'";
    
    $sql_delete_participants = "DELETE FROM participants WHERE competitionName = '$competitionName'";
    
   
    $sql_delete_score = "DELETE FROM score WHERE competitionName = '$competitionName'";
    
    
    if($conn->query($sql) === TRUE && $conn->query($sql_delete_participants) === TRUE && $conn->query($sql_delete_score) === TRUE){
        header('Location: admin.php');
        exit;
    } else {
        echo 'Error: ' . $sql . '<br>' . $conn->error;
    }
}

if(isset($_GET['competitionName'])){
    $competitionName = $_GET['competitionName'];
    $sql = "SELECT * FROM competitions WHERE competitionName='$competitionName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

        <p>Are you sure you want to delete the competition "<?php echo $row['competitionName']; ?>"?</p>
        <input type="hidden" name="competitionName" value="<?php echo $row['competitionName']; ?>">
        <button type="submit">Delete Competition</button>
    </form>
   
    <a href="admin.php">Back to competition list</a>
</div>
    
</body>
</html>
