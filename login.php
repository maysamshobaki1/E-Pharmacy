<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />


    <style>
 

 .input-field #fileInput {
   opacity: 0;
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   cursor: pointer;
 }
 
 .input-field label {
   padding: 6px 12px;
   border: none;
   border-radius: 3px;
   cursor: pointer;
 }
   
   </style>
 
   <script>
  window.onload = function() {
        function chooseFile() {
          document.getElementById('fileInput').click();
        }

        document.getElementById('fileInput').addEventListener('change', function() {
          var fileName = this.value.split('\\').pop();
          document.querySelector('.input-field label').textContent = fileName || '';
        });
      };
 
     </script>
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">

      <div class="forms-container">

      <?PHP  
      session_start();
      ?>

        <div class="signin-signup">
        <form method="post" action="login-check.php"  class="sign-in-form">
       
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password"  placeholder="Password" required />
            </div>
            <input type="submit" value="Login"  name="login" class="submit btn solid" />
            <?PHP  

      if (isset($_SESSION['login_error'])) {
                echo "<div style='color:#7E0101;  '>" . $_SESSION['login_error'] . "</div>";
                unset($_SESSION['login_error']);

            }
            if (isset($_SESSION['registration_error'])) {
              echo "<div style='color:#7E0101;  '>" . $_SESSION['registration_error'] . "</div>";
              unset($_SESSION['registration_error']);
          }

    
      
        
            ?>
        </form> 
        <form method="post" action="registration.php" enctype="multipart/form-data" class="sign-up-form" id="registrationForm">
     
            <h2 class="title">Sign up</h2>
            <div class="input-field">

              <i class="far fa-address-book"></i>
              <input type="text" name="name" placeholder="Name" required/>
            </div>
            <div class="input-field">
              <i class="fa fa-location-arrow"></i>
              <input type="text" name="address" placeholder="Address" required />
            </div>
            <div class="input-field">
              <i class="fas fa-mobile-alt"></i>
              <input type="test" name="phone" placeholder="Mobile Number" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email" required />
            </div>
           
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required/>
            </div>
            <div class="input-field" onclick="chooseFile()" >
            <i class="fas fa-images"></i>
            <input type="file" accept="image/*" name="imgName" id="fileInput" required />
            <label for="fileInput" style="margin-top:10px; color:#B9B9B9">Your Image</label>
          </div>

          <input type="submit" value="Sign Up"  name="register" class="submit btn solid" />
          
          </form>
        </div>
      </div>

    <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              You can Create account to access our Pharmacy  

            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="images/6030480.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Please Enter Your Email and Password to login into you account
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="images/Pharmac.svg" class="image" alt="" />
        </div>
      </div>
    </div> 

    <script src="app.js"></script> 
  </body>
</html>