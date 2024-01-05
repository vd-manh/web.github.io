<?php
///các logic lien quan đến đăng nhập admin
session_start();
if (isset($_SESSION['Admin-name'])) {
  header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="icons/atte1.jpg">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="js/jquery-2.2.3.min.js"></script>
    <script>
      $(window).on("load resize ", function() {
          var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
          $('.tbl-header').css({'padding-right':scrollWidth});
      }).resize();
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $(document).on('click', '.message', function(){
          $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
          $('h1').animate({height: "toggle", opacity: "toggle"}, "slow");
        });
      });
    </script>   
</head>
<body>
<?php include'bglogin.php'; ?> 
<main>
  <h1 class="slideInDown animated">Đăng nhập với tài khoản Admin</h1> <!--để sửa các thẻ bên này tìm đúng tên thẻ been css để sửa giao diện->
  
<!-- Log In -->
<section>
  <div class="slideInDown animated">
    <div class="login-page">
      <div class="form">
        <?php  
        //kiem tra loi va thong bao
          if (isset($_GET['error'])) {// lỗi này là nhập không đúng định dạng mail
            if ($_GET['error'] == "invalidEmail") {
                echo '<div class="alert alert-danger">
                        Email sai định dạng!
                      </div>';
            }
            elseif ($_GET['error'] == "sqlerror") {
                echo '<div class="alert alert-danger">
                        Lỗi cơ sợ dữ liệu!!
                      </div>';
            }
            elseif ($_GET['error'] == "wrongpassword") {
                echo '<div class="alert alert-danger">
                        Sai mật khẩu!!
                      </div>';
            }
            elseif ($_GET['error'] == "nouser") {
                echo '<div class="alert alert-danger">
                        Email không tồn tại!!
                      </div>';
            }
          }         
        ?>
        <div class="alert1"></div>
        <form class="reset-form" action="reset_pass.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" placeholder="E-mail..." required/>
          <button type="submit" name="reset_pass">Reset</button>
          <p class="message"><a href="#">LogIn</a></p>
        </form>
        <form class="login-form" action="ac_login.php" method="post" enctype="multipart/form-data">
          <input type="email" name="email" id="email" placeholder="E-mail..." required/>
          <input type="password" name="pwd" id="pwd" placeholder="Password" required/>
          <button type="submit" name="login" id="login">Đăng nhập</button>
          
        </form>
      </div>
    </div>
  </div>
</section>
</main>
</body>
</html>