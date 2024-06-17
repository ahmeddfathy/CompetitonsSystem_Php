<?php
include("config.php");

// Fetch team names and competition names from participants table
$sql = "SELECT DISTINCT teamName, competitionName FROM participants";
$result = $conn->query($sql);

// Store team names and competition names in arrays
$teamNames = array();
$competitionNames = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $teamNames[] = $row['teamName'];
        $competitionNames[] = $row['competitionName'];
    }
    
    // Remove duplicates from competitionNames array
    $competitionNames = array_unique($competitionNames);
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $competitionName = $_POST['competitionName'];
    $teamName = $_POST['teamName'];
    $score = $_POST['score'];
    $type = $_POST['type']; 
    $completed = $_POST['completed']; // Added this line to retrieve the completed value from the form

    // Insert the data into the score table
    $sql = "INSERT INTO score (competitionName, teamName, score, type, completed) VALUES ('$competitionName', '$teamName', $score, '$type', '$completed')";
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Score</title>
   
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 50px;
        }
        form {
            max-width: 400px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        label {
            font-weight: bold;
        }
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 30px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        input {
            margin-bottom: 20px !important;
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
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
    <h2>Add Score</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="competitionName">Competition Name:</label>
            <select id="competitionName" name="competitionName" class="form-control" required>
                <?php foreach ($competitionNames as $name) { ?>
                    <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="teamName">Team Name:</label>
            <select id="teamName" name="teamName" class="form-control" required>
                <?php foreach ($teamNames as $name) { ?>
                    <option value="<?php echo $name; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="score">Score:</label>
            <input type="number" id="score" name="score" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="completed">Completed:</label>
            <input type="text" id="completed" name="completed" class="form-control" required>
        </div>

        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
</body>
<script>
    document.getElementById('competitionName').addEventListener('change', function() {
        var competitionName = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'addCScore.php?competitionName=' + competitionName, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var teams = JSON.parse(xhr.responseText);
                var teamSelect = document.getElementById('teamName');
                teamSelect.innerHTML = '';
                teams.forEach(function(team) {
                    var option = document.createElement('option');
                    option.text = team;
                    option.value = team;
                    teamSelect.appendChild(option);
                });
            }
        };
        xhr.send();
    });
</script>

</html>
