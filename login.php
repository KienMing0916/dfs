<?php
session_start();
if (isset($_SESSION['User_ID'])) {
  header("Location: home.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DFS - Login</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg m-0" style="background-color: #1C2331;">
      <div class="navbar-brand ms-2">
          <img src="img/logo.png" alt="logo" width="50" height="40" class="ms-3">
          <span style="vertical-align: middle; color: #fff;"><strong>DFS</strong></span>
      </div>
  </nav>

  <div class="container-fluid p-5 pt-3 vh-100" style="background: #CBC3E3;">
    <?php
    function validateLogin() {
        if($_POST) {
            include 'config/database.php';

            $useraccountinput = $_POST['useraccount'];
            $userpasswordinput = $_POST['password'];
            $errorMessage = array();

            if(empty($useraccountinput)) {
                $errorMessage[] = "Please enter your username.";
            }

            if(empty($userpasswordinput)) {
                $errorMessage[] = "Please enter your password.";
            }

            if(!empty($errorMessage)) {
                echo "<div class='alert alert-danger m-3'>";
                    foreach ($errorMessage as $displayErrorMessage) {
                        echo $displayErrorMessage . "<br>";
                    }
                echo "</div>";
            }else {
                try {
                    $query = "SELECT User_ID, password, role FROM users WHERE username=:useraccount OR email=:useraccount OR linked_email_1=:useraccount OR linked_email_2=:useraccount";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':useraccount', $useraccountinput);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if(!$row) {
                        echo "<div class='alert alert-danger m-3'>Username or email not found.</div>";
                        return;
                    }

                    if(!password_verify($userpasswordinput, $row['password'])) {
                        echo "<div class='alert alert-danger m-3'>Password incorrect.</div>";
                        return;
                    }

                    $_SESSION['User_ID'] = $row['User_ID'];
                    $_SESSION['role'] = $row['role'];

                    if ($_SESSION['role'] === "Admin"){
                      header("Location: admin.php");
                      exit();
                    }else{
                      header("Location: home.php");
                      exit();
                    }

                }catch (PDOException $exception) {
                    echo "<div class='alert alert-danger m-3'>ERROR: " . $exception->getMessage() . "</div>";
                }
            }            
        }
    }
    validateLogin();
    ?>

    <div class="row d-flex justify-content-center align-items-center h-100 mt-3">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-white text-dark" style="border-radius: 100px / 100px;">
          <div class="card-body p-5 text-center">
            <h2 class="fw-bold mb-5 mt-5 text-uppercase">Log In</h2>
            <form method="POST" action="login.php">
              <div class="form-outline form-white mb-4">
                <input type="text" name="useraccount" id="useraccount" class="form-control form-control-lg border border-3" placeholder="Username/Email" value="<?php echo isset($_POST['useraccount']) ? $_POST['useraccount'] : ''; ?>" required/> 
              </div>
              <div class="form-outline form-white mb-4">
                <input type="password" name="password" id="password" class="form-control form-control-lg border border-3" placeholder="Password" required/>
              </div>
              <p class="small mb-3 pb-lg-2"><a class="text-black-50" href="#!">Forgot password?</a></p>
              <button type="submit" class="btn btn-white btn-outline-dark btn-lg px-5 mb-3" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Log In</button>
              <p class="mb-3">Don't have an account? <a href="register.php" class="text-black-50 fw-bold">Sign Up</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
