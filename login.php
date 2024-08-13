<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$errors = array();

if (isset($_SESSION['login'])) {
    $_SESSION['danger'] = 'You are already logged in!';
    header('Location: index.php');
    exit();
}

if (isset($_POST['login'])) {

    // validation for email and username
    if (!empty($_POST['usern_email'])) {
        $e = mysqli_real_escape_string($conn,$_POST['usern_email']);
    } else {
        $e = FALSE;
        echo array_push($errors, 'Please provide a username or an email.');
    }

    // validation for password
    if (!empty($_POST['pass'])) {
        $p = mysqli_real_escape_string($conn,$_POST['pass']);
    } else {
        $p = FALSE;
        echo array_push($errors, 'Please provide a password.');
    }

    // if everything is okay
    if ($e && $p) {
        
        // database query
        $q = "SELECT * FROM user WHERE (email = '$e' OR username = '$e' AND password = SHA1('$p'))";
        $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));
        
        // match was made
        if (@mysqli_num_rows($r) == 1) {

            // register user - stores info using session in order to be accessed across different pages
            $_SESSION = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $_SESSION['login'] = true; 

            mysqli_free_result($r);
            mysqli_close($conn);

            // define url and redirect user
            ob_end_clean();
            $_SESSION['message'] = 'You have succesfully logged in!';
            // delete the buffer
            header("Location:index.php");

            exit(); // quit the script

        // no match was made
        } else { 
            array_push($errors, 'Username or email and password does not match or you do not have an account.');
        }
    } else {
        array_push($errors, 'Something is wrong with our system. Please try again later.');
    }
}
?>

<head>
   <title>Log In - 100thCAS</title>
</head>

<?php
if ($errors) {
	echo "<div class='alert alert-warning alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";
	echo "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
    <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
    </svg>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};
?>

<body class="reg_bg">
    <form  action="login.php" method="POST" class="form" id="form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card card-registration my-4">
                        <div class="row g-0">

                            <div class="col-xl-6 d-none d-xl-block">
                                <a href="index.php">
                                    <img src="static/100logomottogold.svg" class="img-fluid"
                                        style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                                </a>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="card-body p-md-5 text-black">
                                    <h3 class="mb-5 text-uppercase">Log In</h3>                        

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="usern_email">Username or Email</label>
                                                <input type="text" name="usern_email" class="form-control form-control-md" placeholder="Username or Email"/>                                                
                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col mb-4">

                                            <div data-mdb-input-init class="form-outline">
                                                <label class="form-label" for="password1">Password</label>
                                                <input type="password" name="pass" class="form-control form-control-md" placeholder="Password"/>      
                                                <br>
                                                <small class="form-text text-muted"><p class="text-dark">Don't have an account? <a href="register.php" class="text-primary text-decoration-none"> Sign Up</a></p></small>                                          
                                            </div>

                                        </div>                                    

                                    </div>                                   

                                    <div class="d-flex justify-content-end pt-3">
                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="login" type="login" value="login">Log In</button>
                                    </div>
                                    
                                </div>
                            </div>     

                            <div class="d-flex justify-content-center">
                                <p class="text-muted fs-10">© Copyright 2024 - Christchurch Adventist School</p>
                            </div>   

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

<?php
include'footer.php';