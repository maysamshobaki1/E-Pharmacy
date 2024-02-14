<!DOCTYPE html>
<html lang="en">

<head>
  <title>E-Pharmacy & Care</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">


  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>
<style>

.site-section {
      padding: 60px 0;
    }

    #prescriptionForm {
      max-width: 700px;
      margin: 0 auto;
      background-color: #044E71;
      padding: 50px;
      border-radius: 8px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    #convertedText {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      width: 100%;
    }

   
  </style>
<body>
<div class="site-wrap">
    <?php include 'includes/header.php'; ?>

    <div class="site-section">
      <div class="container">
        <div class="row">
          
        <div class="col-md-12 text-center">

            <form action="shop.php" method="get" id="prescriptionForm">
            <h2 class="h3  text-black" style="margin-top:20px;margin:20px;color:white;">Search By Image</h2><br>
            <h5 class="h5"  style="margin-top:20px;color:white;">Please upload your image then search for medicine name </h5><br>
              <input type="file" id="myFile" name="filename">
              <br><br>

              <input type="text" name="searchTerm" id="convertedText" hidden>
<BR>
              <button type="submit" class="btn btn-warning">Search Medicine</button>
            </form>
          </div>
        </div>
      </div>
    </div>



<?php include 'includes/footer.php'; ?>


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>





</div>
                
</div>

<script src='https://cdn.rawgit.com/naptha/tesseract.js/1.0.10/dist/tesseract.js'></script>

<script>  

    var myFile = document.getElementById('myFile');
    myFile.addEventListener('change', recognizeText);

    async function recognizeText({ target: { files }  }) {
        Tesseract.recognize(files[0]).then(function(result) {
            console.log("recognizeText: result.text:", result.text);
            document.getElementById("convertedText").value = result.text;
        });
    }

</script>
              
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
                  
                      
                    </body>
                    </html>