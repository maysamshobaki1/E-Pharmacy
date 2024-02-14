<div class="site-navbar py-2">

  <div class="search-wrap">
  <div class="container">
    <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
    <form action="shop.php" method="get">
        <input type="text" class="form-control" name="searchTerm" placeholder="Search for medicine by Name">
    </form>
</div>
  </div>

  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <div class="logo">
        <div class="site-logo">
          <a href="index.php" class="js-logo-clone">E-Pharmacy & Care</a>
        </div>
      </div>
      <div class="main-nav d-none d-lg-block">
        <nav class="site-navigation text-right text-md-center" role="navigation">
          <ul class="site-menu js-clone-nav d-none d-lg-block">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <li class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
            <li class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>"><a href="about.php">About Us</a></li>
            <li class="<?php echo $current_page == 'shop.php' ? 'active' : ''; ?>"><a href="shop.php">Store</a></li>
            <li class="<?php echo $current_page == 'ourDoctors.php' ? 'active' : ''; ?>"><a href="ourDoctors.php">Doctors</a></li>
            <li class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php">Contact Us</a></li>
            <li class="has-children">
              <a href="#">Account</a>
              <ul class="dropdown">
                <?php
                if (isset($_SESSION['userId'])) {
                  echo '<li><a href="profile.php">Profile</a></li>';
                  echo '<li><a href="chat/chat.php">Inbox</a></li>';
                  echo '<li><a href="payments.php">My Payments</a></li>';
                  echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                  echo '<li><a href="login.php">Login</a></li>';
                }
                ?>
              </ul>
            </li>
          </ul>
        </nav>
      </div>

      <div class="icons">
        <a  href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
        <a href="cart.php" class="icons-btn d-inline-block bag">
          <span class="icon-shopping-bag"></span>
          <span class="number"style="color:white"><?php echo isset($_SESSION['userId']) ? getCartItemCount($_SESSION['userId']) : 0; ?></span>
        </a>
        <a  href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span
            class="icon-menu"></span></a>
      </div>

      <?php
      function getCartItemCount($userId)
      {
        include 'includes/config.php';

        if ($userId == null) {
          return 0;
        }

        $query = "SELECT COUNT(*) as count FROM cart WHERE userId = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        mysqli_close($con);

        return $count;
      }
      ?>

    </div>
  </div>
</div>
</div>
<br> 

