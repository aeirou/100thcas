<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// variable that holds a list - list of errors
$errors = [];

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

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};
?>

<body class="reg_bg">

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form  action="login.php" method="POST" class="form" id="form">
        <div class="container h-50">           
            <div class="card my-4">
                <div class="row g-0">

                    <div class="col-xl-6">
                        <a href="index.php">
                            <img src="static/100logomottogold.svg" class="img-fluid"
                                style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;"/>
                        </a>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="p-md-5 text-black">
                            <h3 class="mb-5 text-uppercase">Log In</h3>                        

                            <div class="row">

                                <div class="col mb-4">
                                    
                                    <label class="py-2" for="usern_email">Username or Email</label>    
                                    <input type="text" name="usern_email" id="usern_email" class="form-control" placeholder="Username or Email" value="<?php if (isset($_POST['usern_email'])) echo $_POST['usern_email']; ?>"/>                                                                                    
                                
                                </div>

                            </div>

                            <div class="row">

                                <div class="col mb-4">

                                    <label class="py-2" for="password">Password</label>
                                    <input type="password" name="pass" id="password" class="form-control" placeholder="Password"/>      
                                    <br>
                                    <small class="text-dark">Don't have an account? <a href="register.php" class="text-primary text-decoration-none"> Sign Up</a></small>                                          
                                
                                </div>                                    

                            </div>                                   

                            <div class="d-flex justify-content-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="login" type="submit" value="login">Log In</button>
                            </div>
                            
                        </div>
                    </div>     

                    <div class="d-flex justify-content-center">
                        <small class="text-muted fs-10 pb-3">© Copyright 2024 - Christchurch Adventist School</small>
                    </div>   

                </div>
            </div>
        </div>
    </form>
</body>

</html>

<?php
include'footer.php';