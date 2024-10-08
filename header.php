<?php
require_once'includes/connect.inc';
?>

<nav class="nav navbar-expand-lg p-1 navbar-dark z-1 fixed-top" id="nav">
    <div class="container-fluid">

        <div class="row">

            <div class="col-4">
                <a class="navbar-brand-two d-sm-flex" href="index.php">                
                    <img class="px-3" src="static/navbar/100thhead.svg" alt="">
                    <div class="vr mb-1 bg-white"></div>
                    <img class="px-3" src="static/navbar/motto.svg" alt="">
                </a>
            </div>

            <div class="col p-3">
            
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar navbar-nav ms-auto mb-lg-0 pe-3">

                        <li class="nav-item px-3">
                            <a class="nav-link text-light" href="index.php">Home</a>
                        </li>

                        <?php
                        if (isset($_SESSION['login'])) {
                            echo '
                            <li class="nav-item px-3">
                                <a class="nav-link text-light" href="rsvp.php">RSVP</a>
                            </li>';
                        } else {
                            echo '
                            <li class="nav-item px-3">
                                <a class="nav-link text-light" href="login.php">RSVP</a>
                            </li>';
                        }
                        ?>                        

                        <li class="nav-item px-3">
                            <a class="nav-link text-light" href="store.php">Store</a>
                        </li>

                        <a class="nav-link px-3" href="cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart text-light" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                            </svg>
                        </a>

                        <?php

                        // when user is logged in
                        if (isset($_SESSION['login'])) {

                            echo '
                            <div class="btn-group px-3">                                
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                    </svg>';

                            echo ' ' . $_SESSION["fname"] . ' ';                          
                              
                            echo'    
                            </button>
                                <div class="dropdown-menu dropdown-menu-end">                                                                                  
                                    <a class="dropdown-item text-light bg-danger" href="logout.php">Log out</a>                     
                                </div>
                            </div>';   

                        } else { // when user is logged out
                            echo ' 
                            <div class="btn-group px-3">                                
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                                    </svg>';

                            echo 'Log In/Register';                                        
                                
                            echo'    </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item text-dark" href="register.php">Register</a>                                              
                                    <a class="dropdown-item text-dark" href="login.php">Log In</a>                     
                                </div>
                            </div>';                                            
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

