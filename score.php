<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-3">
    <div class="row justify-content-end">
        <div class="col-auto">
            <a class="btn btn-danger" href="index.php">Log out</a>
        </div>
    </div>

    <div class="container">
        <h1 class="mt-5 mb-4">Score Table</h1>
        <form action="" method="post">
            <div class="form-row align-items-center mb-3">
                <div class="col-auto">
                    <label for="filterTeam" class="sr-only">Filter Team:</label>
                    <select class="form-control" id="filterTeam" name="filterTeam">
                        <option value="">Select Team</option>
                        <?php
                        include("config.php");

                        $sql_teams = "SELECT DISTINCT teamName FROM score";
                        $result_teams = mysqli_query($conn, $sql_teams);

                        while ($row_team = mysqli_fetch_assoc($result_teams)) {
                            echo "<option value='" . $row_team['teamName'] . "'>" . $row_team['teamName'] . "</option>";
                        }

                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="col-auto">
                    <label for="filterSport" class="sr-only">Filter Sport:</label>
                    <select class="form-control" id="filterSport" name="filterSport">
                        <option value="">Select Competition</option>
                        <?php
                        include("config.php");

                        $sql_competitions = "SELECT DISTINCT competitionName FROM score";
                        $result_competitions = mysqli_query($conn, $sql_competitions);

                        while ($row_competition = mysqli_fetch_assoc($result_competitions)) {
                            echo "<option value='" . $row_competition['competitionName'] . "'>" . $row_competition['competitionName'] . "</option>";
                        }

                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
           
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Competition Name</th>
                    <th>Team Name</th>
                    <th>Score</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("config.php");

                $filterTeam = isset($_POST['filterTeam']) ? $_POST['filterTeam'] : '';
                $filterSport = isset($_POST['filterSport']) ? $_POST['filterSport'] : '';

                $sql = "SELECT * FROM score WHERE 1=1";
                if (!empty($filterTeam)) {
                    $sql .= " AND teamName = '$filterTeam'";
                }
                if (!empty($filterSport)) {
                    $sql .= " AND competitionName = '$filterSport'";
                }

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['competitionName'] . "</td>";
                    echo "<td>" . $row['teamName'] . "</td>";
                    echo "<td>" . $row['score'] . "</td>";
                    echo "<td>" . $row['type'] . "</td>";
                    echo "</tr>";
                }

                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>
    <a class='btn btn-primary' href='Competitions.php'>Back</a>
</body>
</html>
