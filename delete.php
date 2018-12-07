<?php

include("includes/config.php");

// Deletes the database entries of the chosen id
if(isset($_POST["id"]) && !empty($_POST["id"])){
    
    $sql = "DELETE FROM premade_characters WHERE id = ?";
    
    if($stmt = $con->prepare($sql)){
        $stmt->bind_param("i", $param_id);

        $param_id = trim($_POST["id"]);
        
        if($stmt->execute()){
            header("location: index.php");
            exit();
        } else{
            echo "Oopsie! Can't comply, please try again later.";
        }
    }
     
    $stmt->close();
    
    $con->close();
    
} else{
    
    if(empty(trim($_GET["id"]))){
    
        header("location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    <style type="text/css">
        .wrapper{
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
                        <h2 id="delete">Delete Record</h2>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p class="bodytext">Are you sure you want to delete this record?</p>
                            <br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-success">
                                <a href="index.php" class="btn btn-success">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>