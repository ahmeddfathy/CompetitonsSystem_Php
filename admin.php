<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Competitions</title>
</head>
<body>

<div class="mt-3">
    <div class="row justify-content-end">
        <div class="col-auto">
            <a class="btn btn-danger" href="index.php">Log out</a>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5">Competitions</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Competition Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Score</th>
                    <th colspan='2' class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include("config.php");
             
                $sql = "SELECT * FROM competitions";
                $result = $conn->query($sql);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>{$row['competitionName']}</td>";
                        echo "<td>{$row['type']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td>{$row['score']}</td>";
                        echo "<td class='text-center'><a class='btn btn-primary' href='editCompetitions.php?competitionName={$row['competitionName']}'>EDIT</a></td>";
                        echo "<td class='text-center'><a class='btn btn-danger' href='deleteCompetitions.php?competitionName={$row['competitionName']}'>Delete</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="addCompetitions.php" class="btn btn-primary">Add Competition</a>
    </div>
    <a class='btn btn-danger' href='admin_score.php' >view scores</a>
</body>
</html>
