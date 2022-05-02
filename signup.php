<?php 
    require "partials/_lgconnection.php";
    require "connection.php";

    $passwordmatchErr = false;
    $existErr = false;
    $success = false;
    $username = "";
    if(isset($_POST["signup"])){
        $username = $_POST["username"];
        $name = $username;
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $exists = false;
        $existSql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connlg, $existSql);
        $num = mysqli_num_rows($result);
        if($num){
            $exists = true;
        }
        if($password === $cpassword){
            if(!$exists){
                $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$hash');";
                $result = mysqli_query($connlg, $sql);
                if($result){
                    $success = true;
                    $tblexistsSql = "SHOW TABLES LIKE '$name';";
                    $tblexistsResult = mysqli_query($conntd, $tblexistsSql);
                    $tblNum = mysqli_num_rows($tblexistsResult);
                    if(!$tblNum){
                        $tblSql = "CREATE TABLE `todoos`.`$name` ( `id` INT NOT NULL AUTO_INCREMENT , `subject` VARCHAR(255) NOT NULL , `description` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
                        $tblResult = mysqli_query($conntd, $tblSql);
                        $username = "";
                    }
                }
            }else {
                $existErr = true;
                $username = "";
            }
        }else {
            $passwordmatchErr = true;
        }
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Sign up</title>
  </head>
  <body>
    <?php require "partials/_navbar.php" ?>
    <?php if($existErr): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> user already exists try another username
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
    <?php if($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account has been registered you can now login <a href="signin.php" class="text-success">Click Here</a>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
    <?php if($passwordmatchErr): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Passwords do not match
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

    <div class="container my-3">
        <h1 class="text-center my-3">Sign up</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input name="username" value="<?php echo $username;?>" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="password">
  </div>
  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input name="cpassword" type="password" class="form-control" id="cpassword">
  </div>
  <button type="submit" class="btn btn-info" name="signup" value="signup">Sign up</button>
</form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>