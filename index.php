<?php
    session_start();
    if(!isset($_SESSION["signedin"])){
      header("location: signin.php");
      exit;
    }
    require "connection.php";
    
    $name = $_SESSION["name"];
    $successMsg = 0;
    $successUpdateMsg = 0;
    $deleteMsg = 0;

    $subject = $description = $subjectMsg = $descriptionMsg = $subjectUpdate = $descriptionUpdate = '';

    if(isset($_POST['submit'])){
        if(empty($_POST['subject'])){
            $subjectMsg = "Enter a subject for your ToDoo";
        }else {
            $subject = test_input($_POST['subject']);
        }

        if(empty($_POST['description'])){
            $descriptionMsg = "Enter a description for your ToDoo";
        }else {
            $description = test_input($_POST['description']);
        }

        if($subject != '' && $description != ''){
              $sql = "INSERT INTO `$name` (`subject`, `description`) VALUES ('$subject', '$description');";
              $result = mysqli_query($conntd, $sql);
  
              if($result){
                  $successMsg = 1;
                  $subject = '';
                  $description = '';
              }
        }
    }

    if(isset($_POST['update'])){
      
      $subjectUpdate = test_input($_POST['updatedSubj']);
      $descriptionUpdate = test_input($_POST['updatedDescription']);
      $id = mysqli_real_escape_string($conntd, $_POST['updatedId']);

      $sql = "UPDATE `$name` SET `subject` = '$subjectUpdate', `description` = '$descriptionUpdate' WHERE `$name`.`id` = $id;";
      $result = mysqli_query($conntd, $sql);
      if($result){
          $successUpdateMsg = 1;
      }
  }

    if(isset($_POST['delete'])){
      $id = mysqli_real_escape_string($conntd, $_POST['to_delete']);
      $sql = "DELETE FROM `$name` WHERE `$name`.`id` = $id";
      $result = mysqli_query($conntd, $sql);

      if($result){
        $deleteMsg = 1;
      }
    }

    $sql = "SELECT * FROM `$name`";
    $result = mysqli_query($conntd, $sql);

    $dataArr = mysqli_fetch_all($result, MYSQLI_ASSOC);

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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
    <title>ToDoos!</title>
  </head>
  <body>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
      <input type="hidden" name="updatedId" id="idEdit">
        <div class="mb-3">
    <label for="subject" class="form-label">Subject</label>
    <input type="text" class="form-control" name="updatedSubj" id="subjectUpdate" aria-describedby="emailHelp">
</div>
  <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="updatedDescription" id="descriptionUpdate" cols="30" rows="10"></textarea>
  </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <input type="submit" name="update" value="Update ToDoo" class="btn btn-info">
</div>
</form>
    </div>
  </div>
</div>

  <?php require "partials/_navbar.php" ?>

<?php if($successMsg == 1): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Sucess!</strong> Your ToDoo has been successfully added.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;?>

<?php if($successUpdateMsg == 1): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Sucess!</strong> Your ToDoo has been successfully updated.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;?>

<?php if($deleteMsg == 1): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
  <strong>Sucess!</strong> Your ToDoo has been successfully deleted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif;?>

<div class="container">
    <h1 class="my-4">Add ToDoo</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <div class="mb-3">
    <label for="subject" class="form-label">Subject</label>
    <input type="text" name="subject" value="<?php echo htmlspecialchars($subject)?>" class="form-control" id="subject" aria-describedby="emailHelp">
    <div class="text-danger"><?php echo $subjectMsg ?></div>
</div>
  <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" cols="30" rows="10"><?php echo htmlspecialchars($description)?></textarea>
      <div class="text-danger"><?php echo $descriptionMsg ?></div>
  </div>
  <input type="submit" value="Add ToDoo" name="submit" class="btn btn-info">
</form>
</div>

<div class="container my-4">
    <h1 class="my-4">Your ToDoos</h1>
<table class="table table-striped table-info" id="#myTable">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Subject</th>
      <th scope="col">Description</th>
      <th scope="col">Manage</th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($dataArr as $todoo): ?>
        <tr>
          <th scope="row" class="id d-none"><?php echo htmlspecialchars($todoo['id']) ?></th>
          <th scope="row" class="visibleId"></th>
          <td class="subject"><?php echo htmlspecialchars($todoo['subject']) ?></td>
          <td class="description"><?php echo htmlspecialchars($todoo['description']) ?></td>
          <td>
              <button class="btn btn-dark editBtn" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" class="d-inline">
                  <input type="hidden" name="to_delete" value="<?php echo htmlspecialchars($todoo['id']) ?>">
                  <input type="submit" name="delete" value="Delete" class="btn btn-dark">
              </form>
          </td>
        </tr>
      <?php endforeach;?>
  </tbody>
</table>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
      const subjectUpdate = document.querySelector("#subjectUpdate");
      const descriptionUpdate = document.querySelector("#descriptionUpdate");
      const idEdit = document.querySelector("#idEdit");
      const visibleIds = document.querySelectorAll(".visibleId");
      const editBtns = document.querySelectorAll(".editBtn");

      for(let i = 0; i < visibleIds.length; i++){
        visibleIds[i].innerText = i + 1
      }
      
        console.log(editBtns);

      Array.from(editBtns).forEach(editBtn => {
        editBtn.addEventListener("click", (e) => {
          const tr = e.currentTarget.parentElement.parentElement;
        const subject = tr.querySelector(".subject");
        const description = tr.querySelector(".description");
        const id = tr.querySelector(".id");
        descriptionUpdate.value = description.innerText
        subjectUpdate.value = subject.innerText
        idEdit.value = id.innerText
        console.log(tr, subject.innerText, description.innerText, descriptionUpdate.value, subjectUpdate.value);
        })
      });
      
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>