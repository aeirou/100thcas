<?php
require_once'includes/basehead.html';
require_once'includes/connect.inc';
session_start();

// if user is not an admin, user is redirected to page invalid.
if (isset($_SESSION['login']) || !isset($_SESSION['login'])) {
    if ($_SESSION['admin'] == 0) {
        header("Location:errordocs/invalid.html");
        exit();
    }
}

// default values are invalid
$n = $d = $c = $qt = $p = $img = FALSE;

// variable that holds a list - list of errors/success messages
$errors = [];
$success = [];

if (isset($_POST['add'])) {
    // trims whitespace of all incoming data (sanitisation)
    $trimmed = array_map('trim',$_POST);

    // product name validation
    if (!empty($trimmed['stock_name'])) {
        if (strlen($trimmed['stock_name']) <= 18) {
            $n = mysqli_real_escape_string($conn, $trimmed['stock_name']);                  
        } else {
            array_push($errors, "Item name exceeds 18 characters!");
        }   
    } else {
        array_push($errors, "Please enter an item name.");
    }

    // desc validation
    if (!empty($trimmed['stock_desc'])) {
        if (strlen($trimmed['stock_desc']) <= 100) {            
            $d = mysqli_real_escape_string($conn, $trimmed['stock_desc']);              
        } else {
            array_push($errors, "Item description exceeds 100 characters!");
        }   
    } else {
        array_push($errors, "Please enter a description.");
    }

    // category validation
    if (!empty($trimmed['category'])) {
        $c = mysqli_real_escape_string($conn, $trimmed['category']);
    } else {
        array_push($errors, "Please enter a category.");
    }

    // quantity validation
    if (!empty($trimmed['stock_quantity'])) {
        if($trimmed['stock_quantity'] >= 1 && $trimmed['stock_quantity'] <= 500) {     
            $qt = mysqli_real_escape_string($conn, $trimmed['stock_quantity']);
        } else {
            array_push($errors, "You cannot less than 1 or more than 500 of an item.");
        }        
    } else {
        array_push($errors, "Please enter the number of the items.");
    }

    // price validation
    if (!empty($trimmed['stock_price'])) {
        if($trimmed['stock_price'] >= 1 && $trimmed['stock_price'] <= 1000) {            
            $p = mysqli_real_escape_string($conn, $trimmed['stock_price']); 
        } else {
            array_push($errors, "You cannot have less than $1 or more than $1000 for an item.");
        }        
    } else {
        array_push($errors, "Please enter the price of the item.");
    }

    // img validation
    if (!empty($trimmed['stock_img'])) {
        $img = $trimmed['stock_img'];
    } else {
        $img = 'imagenotfound.svg';
    }

    // if everthing is ok
    if ($n&&$d&&$c&&$qt&&$p) {        

        // check for unique product name
        $check_name = "SELECT * FROM product WHERE name='$n' ";       

        $r = mysqli_query($conn, $check_name) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));        
        
        // if item is unique
        if (mysqli_num_rows($r) == 0) {

            // adds item to the db                    
            $q = "INSERT INTO `product` (`img`,`name`, `desc`, `SKU`, `category`, `price`, `created_at`)
            VALUES ('$img','$n', '$d', '$qt', '$c', '$p', NOW())";
            $r = mysqli_query($conn, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($conn));            
            
            if ($r) {
                array_push($success, "Item has been added!");
            } else {
                array_push($errors, "There was an error. Please try again later.");
        }

        } else {
            array_push($errors, "This item already exists!");
        }
    }
}    

?>

<head>
    <title>Add stocks</title>
</head>

<?php
if ($errors) {
	echo "<div class='alert alert-warning alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

	echo array_values($errors)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
};

if ($success) {
    echo "<div class='alert alert-success alert-dismissable d-flex align-items-center fade show fixed-top' role='alert'>";

    echo array_values($success)[0];

	echo "<button type='button' class='btn-close position-absolute top-25 end-0 me-3' data-bs-dismiss='alert' aria-label='Close'></button>     
		</div>";
}
?>

<body class="reg_bg">

    <div class="col-xl py-2 pt-3 text-center">                            
        <img src="static/backgroundlogo.svg" class="img-fluid"
            style="width:100px;"/>
    </div>

    <form action="addstock.php" method="POST" class="form">
        <div class="container h-60">
            <div class="card card-registration my-4">          
                <div class="card-body p-md-5 text-black">
                    <h3 class="mb-5 text-uppercase text-info"><strong>Add stocks</strong></h3>     
                    
                    <div class="row">

                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_name">Name of item </label>
                                <input type="text" name="stock_name" id="stock_name" class="form-control form-control-md" placeholder="CAS Mug" value="<?php if (isset($_POST['stock_name'])) echo $_POST['stock_name'];?>">                                                                                                                         
                            </div>

                        </div>
                        
                        <div class="col-6 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="stock_img">Image of the item </label>
                                <input type="text" name="stock_img" id="stock_img" class="form-control form-control-md" placeholder="image.jpg">   
                            </div>

                        </div> 

                    </div>

                    <div class="row">

                        <div class="col mb-4">
                            <div data-mdb-input-init class="form-outline">
                                <label class="form-label" for="stock_desc">Description of the item </label>
                                <textarea type="desc" style="height:100px" name="stock_desc" id="stock_desc" class="form-control form-control-md" placeholder="This is a mug." value="<?php if (isset($_POST['stock_desc'])) echo $_POST['stock_desc'];?>"></textarea>                                                
                                <small class="form-text text-muted">Description can be up to 100 characters.</small>                                                                                             
                            </div>
                        </div>

                    </div>
                    
                    <div class="row">

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" for="stock_quantity">Stocks available </label>
                                <input name="stock_quantity" id="stock_quantity" type="number" class="form-control form-control-md" value="1" step="1">
                            </div>                                        

                        </div>

                        <div class="col-4 mb-4">

                            <div data-mdb-input-init class="form-outline">
                                <label class="required-field form-label" class="form-label" for="stock_price">Stock price </label>
                                <input type="number" name="stock_price" id="stock_price" class="form-control form-control-md" value="1" step="1">                                                
                            </div>

                        </div>   

                        <div class="col-4 mb-4">
                            
                            <label class="required-field form-label" class="form-label" for="category">Stock Category </label>
                            <select class="form-select" aria-label="Default select example" name="category" id="category" placeholder="hello">
                                <option selected></option>
                                <option value="Clothing">Clothing</option>
                                <option value="Accessories">Accessories</option>
                                <option value="Stationary">Stationary</option>
                                <option value="Crockery">Crockery</option>                                
                            </select>                  

                        </div>   

                    </div>

                    <div class="row">

                        <div class="col-sm-3">

                            <div class="d-flex justify-content-sm-start pt-3"> 
                                <a href="dashboard.php">
                                    <button class="btn btn-info btn-lg ms-2" type="button">View Stocks</button>
                                </a>                                                 
                            </div>

                        </div>

                        <div class="col-sm-9">

                            <div class="d-flex justify-content-sm-end pt-3">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2" name="add" type="submit" value="add">Add Item</button>
                            </div>                            

                        </div>                    

                    </div>
                    
                </div>
            
            <div class="d-flex justify-content-center">
            <small class="text-muted fs-10 pb-3">© Copyright 2024 - Christchurch Adventist School</small>
        </div>   
    </form>
</body>
<?php
include'footer.php';