<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Scores</title>
</head>
<body>

<div class="mt-3">
    <div class="row justify-content-end">
        <div class="col-auto">
            <a class="btn btn-danger" href="index.php">Log out</a>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5">Scores</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Total Score</th>
                    <th colspan='4' class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
include("config.php");

// Fetch team names and total score from the score table
$sql = "SELECT teamName, competitionName, SUM(score) AS totalScore FROM score GROUP BY teamName";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>{$row['teamName']}</td>";
        echo "<td>{$row['totalScore']}</td>";
        echo "<td>{$row['competitionName']}</td>"; // Display competition name
        echo "<td class='text-center'><a class='btn btn-primary' href='editScore.php?teamName={$row['teamName']}&competitionName={$row['competitionName']}'>EDIT</a></td>";
        echo "<td class='text-center'><a class='btn btn-danger' href='deleteScore.php?teamName={$row['teamName']}&competitionName={$row['competitionName']}'>Delete</a></td>"; // Include competition name in the URL
        echo "</tr>";
    }
}
?>

            </tbody>
        </table>
        <a href="addScore.php" class="btn btn-primary">Add Score</a>
    </div>
</body>
</html>
