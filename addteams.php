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

// Determine if the user is not a team type
$is_not_team = $user_type !== 'team';

// Check the number of competitions the user has participated in
$checkParticipationCount = mysqli_query($conn, "SELECT COUNT(*) AS participation_count FROM participants WHERE type = '$user_type'");
$participationCount = mysqli_fetch_assoc($checkParticipationCount)['participation_count'];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $competitionName = $_POST['competitionName'];
    $teamName = $_POST['teamName'];

    // Check if team name already exists in the selected competition
    $checkTeam = mysqli_query($conn, "SELECT * FROM participants WHERE teamName = '$teamName' AND competitionName = '$competitionName'");
    if(mysqli_num_rows($checkTeam) > 0) {
        echo "Error: Team name '$teamName' already exists in this competition!";
        exit;
    }
    
    $memberNames = "";

    if($user_type === "team") {
        for($i = 1; $i <= 5; $i++) {
  
            if(isset($_POST["memberName{$i}"]) && $_POST["memberName{$i}"] !== "") {
                $memberNames .= $_POST["memberName{$i}"] . ",";
            }
        }
     
        $memberNames = rtrim($memberNames, ",");
    
     
        if(isset($_POST['memberName']) && $_POST['memberName'] !== "") {
            $memberNames .= "," . $_POST['memberName'];
        }
    } else {
      
        $memberNames = $_POST['memberName'];
    }
    
    // Check if users are sharing the same team in the same competition
    $checkParticipants = mysqli_query($conn, "SELECT * FROM participants WHERE competitionName = '$competitionName' AND memberName LIKE '%$memberNames%'");
    if(mysqli_num_rows($checkParticipants) > 0) {
        echo "Error: Users are already participating with the same team in this competition!";
        exit;
    }
    
    // Check if the user has already participated in five competitions
    if($participationCount >= 5) {
        echo "Error: You have already participated in the maximum number of competitions!";
        exit;
    }
    
    // Check if competitionName exists in the competitions table
    $checkCompetition = mysqli_query($conn, "SELECT * FROM competitions WHERE competitionName = '$competitionName'");
    if(mysqli_num_rows($checkCompetition) === 0) {
        echo "Error: Competition '$competitionName' does not exist!";
        exit;
    }
    
    // Insert data into participants table
    $sql = "INSERT INTO participants (competitionName, teamName, memberName, type) VALUES ('$competitionName', '$teamName', '$memberNames', '$user_type ')";
  
    
    if($conn->query($sql) === TRUE) {
        header('Location: Competitions.php');
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
    <title>Add Participant</title>
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
    <div class="container mt-5">
        <h2>Add Participant</h2>
        <form action="addteams.php" method="post">
            <div class="form-group">
                <label for="competitionName">Competition Name</label>
                <select id="competitionName" name="competitionName" class="form-control" required>
                    <?php foreach ($competitions as $competition) { ?>
                        <option value="<?php echo $competition['competitionName']; ?>"><?php echo $competition['competitionName']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="teamName">Team Name</label>
                <input type="text" id="teamName" name="teamName" class="form-control" required>
            </div>
          
            <?php if ($is_not_team) { ?>
            <div class="form-group">
                <label for="memberName">Member Name</label>
                <input type="text" id="memberName" name="memberName" class="form-control">
            </div>
            <?php } else { ?>
            <div id="teamMembers" style="display: none;">
                <?php for($i = 1; $i <= 5 ; $i++) { ?>
                    <div class="form-group">
                        <label for="memberName<?php echo $i; ?>">Member <?php echo $i; ?> Name</label>
                        <input type="text" id="memberName<?php echo $i; ?>" name="memberName<?php echo $i; ?>" class="form-control">
                    </div>
                <?php } ?>
            </div>
            <?php } ?>

            <button type="submit" style='width:100px' class="btn btn-primary">Submit</button>
        </form>
     
        <div style='margin-top:10px'>
            <a class='btn btn-info' style='width:100px' href='Competitions.php'>Back</a>
        </div>
    </div>
</div>

<script>
    function showMembersInput(value) {
        var teamMembersDiv = document.getElementById('teamMembers');
        var memberInputs = document.getElementsByName('memberName');

        if(value === 'team') {
            teamMembersDiv.style.display = 'block';
            for (var i = 0; i < memberInputs.length; i++) {
                memberInputs[i].style.display = 'block';
            }
        } else {
            teamMembersDiv.style.display = 'none';
            for (var i = 0; i < memberInputs.length; i++) {
                memberInputs[i].style.display = 'none';
            }
        }
    }
    showMembersInput('<?php echo $user_type; ?>');

    // Function to show alert and hide it after 5 seconds
    function showAlert(message) {
        var alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger';
        alertDiv.textContent = message;
        document.body.insertBefore(alertDiv, document.body.firstChild);

        setTimeout(function(){
            alertDiv.style.display = 'none';
        }, 5000);
    }

    // Check if there's an error message and display it
    <?php if(isset($error_message)) { ?>
        showAlert('<?php echo $error_message; ?>');
    <?php } ?>
</script>

</body>
</html>
