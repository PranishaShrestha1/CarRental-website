<?php
//error_reporting(0);
if(isset($_POST['signup']))
{
    // Validate inputs server-side
    $errors = [];
    
    // Full name validation (must have at least 2 alphabets, allow spaces in between)
    $fname = trim($_POST['fullname']);
    if(!preg_match("/^[a-zA-Z]+( [a-zA-Z]+)+$/", $fname) || strlen($fname) < 2) {
        $errors[] = "Full name must contain at least two alphabet words separated by space";
    }
    
    // Mobile number validation (Nepal format: 98[0-9]{8})
    $mobile = $_POST['mobileno'];
    if(!preg_match("/^98[0-9]{8}$/", $mobile)) {
        $errors[] = "Mobile number should be 98XXXXXXXX format (10 digits starting with 98)";
    }
    
    // Email validation - must have letters before @ and specific domains
    $email = $_POST['emailid'];
    if(!preg_match("/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*@(gmail|yahoo)\.com$/", $email)) {
        $errors[] = "Email must be alphanumeric (e.g. ramkc7@gmail.com, sitagiri567@yahoo.com)";
    }
    
    
    // If no errors, proceed with registration
    if(empty($errors)) {
        $password = md5($_POST['password']); 
        $sql = "INSERT INTO tblusers(FullName,EmailId,ContactNo,Password) 
                VALUES(:fname,:email,:mobile,:password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':mobile',$mobile,PDO::PARAM_STR);
        $query->bindParam(':password',$password,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        
        if($lastInsertId) {
            echo "<script>alert('Registration successful. Now you can login');</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
        }
    } else {
        // Show all validation errors
        echo "<script>alert('".implode("\\n", $errors)."');</script>";
    }
}
?>

<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data:'emailid='+$("#emailid").val(),
        type: "POST",
        success:function(data){
            $("#user-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error:function (){}
    });
}

// Improved validation functions
function validateName(input) {
    // Remove special characters but keep spaces between words
    input.value = input.value.replace(/[^a-zA-Z ]/g, '');
    // Remove multiple spaces
    input.value = input.value.replace(/\s+/g, ' ').trim();
}

function validateEmail(input) {
    var email = input.value;
    var regex = /^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*@(gmail|yahoo)\.com$/;
    if(!regex.test(email)) {
        $("#email-status").html("<font color='red'>Must be like: ramkc7@gmail.com or sitagiri567@yahoo.com</font>");
        return false;
    } else {
        $("#email-status").html("<font color='green'>Valid email</font>");
        return true;
    }
}

// Force Nepal mobile number format
function validateMobile(input) {
    // Remove all non-digit characters
    input.value = input.value.replace(/\D/g, '');
    
    // Ensure it starts with 98 and has exactly 10 digits
    if(input.value.length > 2 && input.value.substring(0, 2) !== '98') {
        input.value = '98' + input.value.substring(2);
    }
    if(input.value.length > 10) {
        input.value = input.value.substring(0, 10);
    }
}

// Final form validation before submission
function validateForm() {
    // Full name validation
    var fname = $("#fullname").val().trim();
    if(fname.length < 2 || !/[a-zA-Z]/.test(fname)) {
        alert("Full name must contain at least two alphabet words");
        return false;
    }
    
    // Check mobile format
    var mobile = $("#mobileno").val();
    if(!/^98\d{8}$/.test(mobile)) {
        alert("Mobile number must be 10 digits starting with 98");
        return false;
    }
    
    // Check email format
    if(!validateEmail(document.getElementById('emailid'))) {
        return false;
    }
    
    return true;
}
</script>

<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Sign Up</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form method="post" name="signup" onsubmit="return validateForm()">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" id="fullname" 
                         placeholder="Full Name (e.g. Ram Bahadur)" required="required" 
                         oninput="validateName(this)" 
                         pattern="[a-zA-Z ]+"
                         title="Must contain at least two alphabet words">
                </div>
                <div class="form-group">
                  <input type="tel" class="form-control" name="mobileno" id="mobileno" 
                         placeholder="Mobile Number (98XXXXXXXX)" required="required" 
                         oninput="validateMobile(this)" pattern="98\d{8}" maxlength="10"
                         onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" 
                         placeholder="Email (e.g. ramkc7@gmail.com)" required="required" 
                         onblur="checkAvailability(); validateEmail(this)"
                         pattern="[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*@(gmail|yahoo)\.com"
                         title="Must be alphanumeric like: ram123@gmail.com">
                  <span id="user-availability-status" style="font-size:12px;"></span>
                  <span id="email-status" style="font-size:12px;"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" 
                         placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Already got an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
      </div>
    </div>
  </div>
</div>