<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DFS - Sign up</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="https://kit.fontawesome.com/c3573e9c36.js" crossorigin="anonymous"></script>  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg m-0" style="background-color: #1C2331;">
        <div class="d-flex align-items-center ms-1">
            <a class="navbar-brand ms-2" href="">
                <img src="img/logo.png" alt="logo" width="50" height="40" class="ms-3">
                <span style="vertical-align: middle; color: #fff;"><strong>DFS</strong></span>
            </a>
        </div>
    </nav>

    <div class="container-fluid p-5 pt-3" style="background: #CBC3E3;">
        <?php
        if($_POST){
            include 'dbcon.php';
            
            if(isset($_POST['register'])){

                // echo '<pre>';
                // var_dump(openssl_get_cert_locations());
                // exit;

                $username = $_POST['username'];
                $email = $_POST['email'];
                $phone_number = $_POST['phone_number'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                //The default role for a user is Recipient
                $role = "Recipient";

                include 'menu/validate_function.php';
                $errorMessage = validateUserForm($username, $email, $phone_number, $password, $confirm_password);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $postData = [
                        'uname'=>$username,
                        'email'=>$email,
                        'phone_number'=>$phone_number,
                        'password'=>$password,
                        'role'=>$role,
                    ];
                    $ref_table = "users";
                    $postRef_result = $database->getReference($ref_table)->push($postData);
    
                    if($postRef_result){
                        echo "<div class='alert alert-success m-3'>Register successfully</div>";
                        $_POST = array();
                    }else{
                        echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                    }

                }
            }
        }
        ?>

        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-md-5 col-lg-7 col-xl-6">
                <div class="border rounded-pill bg-white d-flex justify-content-center align-items-center" style="block-size:300px">
                    <div class="text-center">
                        <h1 class="lh-lg text-uppercase"><strong>Welcome To DFS</strong></h1>
                        <h5 class="lh-lg fs-5">Store Your Documents with us!</h5>
                    </div>
        
                </div>
            </div>
            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 mt-5">
                <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" id="registerForm">
                    <h2>REGISTER AN ACCOUNT NOW!</h2>
                    <div class="divider d-flex align-items-center my-4"></div>
                    <div class="form-outline mb-4">
                        <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>"/>
                    </div>
                    <div class="form-outline mb-4">
                        <div class="d-flex">
                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>"/>
                            <!-- <button type="submit" class="btn btn-white btn-outline-dark btn-lg">Verify</button> -->
                        </div>
                    </div>
                    <div class="form-outline mb-4 d-flex">
                        <input type="text" name="phone_number" id="phone_number" class="form-control form-control-lg" placeholder="Phone Number" value="<?php echo isset($_POST['phone_number']) ? $_POST['phone_number'] : ''; ?>"/>
                        <!-- <button type="submit" class="btn btn-white btn-outline-dark btn-lg btn-block d-flex">Verify</button> -->
                    </div>
            
                    <div class="form-outline mb-4">
                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password"/>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Re-enter Password"/>
                    </div>

                    <div class="d-flex align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="termsAndConditions" name="termsAndConditions"/>
                            <label class="form-check-label" for="termsAndConditions">I agree with the term and conditions stated.</label>
                            
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-end">
                        <a href="login.php" class="w-40 btn btn-white btn-outline-dark btn-lg me-2" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Already have an account</a>
                        <button type="submit" name="register" class="btn btn-white btn-outline-dark btn-lg" style="background-color: #6F61C0; color: white; border-color: #6F61C0;">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>