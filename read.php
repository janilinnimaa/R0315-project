<?php
    include("includes/config.php");

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
    }
    else {
        header("Location: register.php");
    }
    
    // Queries the user's chosen entry for viewing
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        $sql = "SELECT * FROM premade_characters WHERE id = ?";

        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i", $param_id);

            $param_id = trim($_GET["id"]);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    $name = $row["name"];
                    $physical = $row["physical"];
                    $mental = $row["mental"];
                    $occupation = $row["occupation"];
                    $goal = $row["goal"];

                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oopsie, cannot comply. Try again later!";
            }
        }

        $stmt->close();
        $con->close();
    } else {
        header("location: error.php");
        exit();
    }
?>

<html>
<head>
    <meta charset="utf-8">
    <title>View Character</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Shows they query in a simple table form -->
                    <div class="page-header">
                        <h2>View Record</h2>
                    </div>
                    <div class="form-group">
                        <label>Name:</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Physical Trait:</label>
                        <p class="form-control-static"><?php echo $row["physical"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Mental Trait:</label>
                        <p class="form-control-static"><?php echo $row["mental"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Occupation:</label>
                        <p class="form-control-static"><?php echo $row["occupation"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Goal:</label>
                        <p class="form-control-static"><?php echo $row["goal"]; ?></p>
                    </div>
                    <div id="bottomButtons">
                        <p><a href="index.php" class="btn btn-success">Back</a></p>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>