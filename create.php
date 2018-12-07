<?php
    include("includes/config.php");

    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = $_SESSION['userLoggedIn'];
    }
    else {
        header("Location: register.php");
    }

    $name = $physical = $mental = $occupation = $goal = "";
    $name_err = $physical_err = $mental_err = $occupation_err = $goal_err = "";

    // Checks and sanitizes the user input in preparation for inserting into the database
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $input_name = trim($_POST["name"]);
        if (empty($input_name)) {
            $name_err = "Please enter a name for the character";
        } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $name_err = "Please enter a valid name. (a-z, A-Z)";
        } else {
            $name = $input_name;
        }

        $input_physical = trim($_POST["physical"]);
        if (empty($input_physical)) {
            $physical_err = "Please enter a physical attribute for the character";
        } elseif (!filter_var($input_physical, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $physical_err = "Please enter a valid physical trait. (a-z, A-Z)";
        } else {
            $physical = $input_physical;
        }

        $input_mental = trim($_POST["mental"]);
        if (empty($input_mental)) {
            $mental_err = "Please enter a mental attribute for the character";
        } elseif (!filter_var($input_mental, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $mental_err = "Please enter a valid mental trait. (a-z, A-Z)";
        } else {
            $mental = $input_mental;
        }

        $input_occupation = trim($_POST["occupation"]);
        if (empty($input_occupation)) {
            $occupation_err = "Please enter a occupation for the character";
        } elseif (!filter_var($input_occupation, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $occupation_err = "Please enter a valid occupationn. (a-z, A-Z)";
        } else {
            $occupation = $input_occupation;
        }

        $input_goal = trim($_POST["goal"]);
        if (empty($input_goal)) {
            $goal_err = "Please enter a goal for the character";
        } elseif (!filter_var($input_goal, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
            $goal_err = "Please enter a valid goal. (a-z, A-Z)";
        } else {
            $goal = $input_goal;
        }

        // if there are no errors, insert the details given by the user into the database
        if (empty($name_err) && empty($physical_err) && empty($mental_err) && 
        empty($occupation_err) && empty($goal_err)) {
            $sql = "INSERT INTO premade_characters (name, physical, mental, occupation, goal) VALUES (?, ?, ?, ?, ?)";
            
            if ($stmt = $con->prepare($sql)) {
                $stmt->bind_param("sssss", $param_name, $param_physical, $param_mental, $param_occupation, $param_goal);

                $param_name = $name;
                $param_physical = $physical;
                $param_mental = $mental;
                $param_occupation = $occupation;
                $param_goal = $goal;

                if ($stmt->execute()) {
                    header("location: index.php");
                    exit();
                } else {
                    echo "WRONGGGGGGG!";
                }
            }

            $stmt->close();
        }

        $con->close();
    }

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Create New Character</title>
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
                    <div class="page-header">
                        <h2>Create a Character</h2>
                    </div>
                    <p class="bodytext">Please fill this form and submit to add a new character to the list</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name:</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($physical_err)) ? 'has-error' : ''; ?>">
                            <label>Physical:</label>
                            <input type="text" name="physical" class="form-control" value="<?php echo $physical; ?>">
                            <span class="help-block"><?php echo $physical_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($mental_err)) ? 'has-error' : ''; ?>">
                            <label>Mental:</label>
                            <input type="text" name="mental" class="form-control" value="<?php echo $mental; ?>">
                            <span class="help-block"><?php echo $mental_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($occupation_err)) ? 'has-error' : ''; ?>">
                            <label>Occupation:</label>
                            <input type="text" name="occupation" class="form-control" value="<?php echo $occupation; ?>">
                            <span class="help-block"><?php echo $occupation_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($goal_err)) ? 'has-error' : ''; ?>">
                            <label>Goal:</label>
                            <input type="text" name="goal" class="form-control" value="<?php echo $goal; ?>">
                            <span class="help-block"><?php echo $goal_err;?></span>
                        </div>
                        <div id="bottomButtons">
                            <input type="submit" class="btn btn-success" value="Submit">
                            <a href="index.php" class="btn btn-success">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>