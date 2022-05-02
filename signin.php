<?php 
    require "partials/_lgconnection.php";
    $username = "";
    $loginErr = false;
    $passErr = false;
    if(isset($_POST["signin"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $existSql = "SELECT * FROM users WHERE username = '$username';";
        $result = mysqli_query($connlg, $existSql);
        $num = mysqli_num_rows($result);
        if($num){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"])){
                session_start();
                $_SESSION["signedin"] = true;
                $_SESSION["name"] = $username;
                header("location: index.php");
            }else {
                $passErr = true;
            }
        }else {
            $loginErr = true;
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

    <title>Sign in</title>
  </head>
  <body>
      <?php require "partials/_navbar.php" ?>
      <?php if($passErr): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Wrong Password
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
      <?php if($loginErr): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> User does not exists
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
  <div class="container my-3">
        <h1 class="text-center my-3">Sign in</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input name="username" value="<?php echo $username;?>" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input name="password" type="password" class="form-control" id="password">
  </div>
  <button type="submit" class="btn btn-info" name="signin" value="signin">Sign in</button>
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