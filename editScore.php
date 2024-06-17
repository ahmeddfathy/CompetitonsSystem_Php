<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Score</title>
   
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
        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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

<div class="container mt-3">
        <div class="row justify-content-end">
            <div class="col-auto">
                <a class="btn btn-danger" href="index.php">Log out</a>
            </div>
        </div>

<div class="container">
    <h1>Edit Score</h1>
    <form method="post" action="editScore.php">
    <?php 
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $competitionName = $_POST['competitionName'];
    $teamName = $_POST['teamName'];
    $score = $_POST['score'];

    // حذف النتيجة القديمة للفريق في المسابقة
    $delete_sql = "DELETE FROM score WHERE competitionName='$competitionName' AND teamName='$teamName'";
    if($conn->query($delete_sql) === TRUE){
        // إضافة النتيجة الجديدة
        $insert_sql = "INSERT INTO score (competitionName, teamName, score) VALUES ('$competitionName', '$teamName', $score)";
        if($conn->query($insert_sql) === TRUE){
            header('Location: admin.php');
            exit;
        } else {
            echo 'Error: ' . $insert_sql . '<br>' . $conn->error;
        }
    } else {
        echo 'Error: ' . $delete_sql . '<br>' . $conn->error;
    }
} elseif(isset($_GET['competitionName'])){
    $competitionName = $_GET['competitionName'];
    $sql = "SELECT * FROM score WHERE competitionName='$competitionName'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

        
        <div class="form-group">
            <label for="teamName">Team Name:</label>
            <input type="text" class="form-control" id="teamName" name="teamName" value="<?php echo $row['teamName']; ?>" placeholder="Enter team name">
        </div>
        
        <div class="form-group">
            <label for="score">Score:</label>
            <input type="number" class="form-control" id="score" name="score" value="<?php echo $row['score']; ?>" placeholder="Enter score">
        </div>
        
        <input type="hidden" name="competitionName" value="<?php echo $row['competitionName']; ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <a href="admin_score.php" class="btn btn-secondary">Back to competition list</a>
</div>

</body>
</html>
