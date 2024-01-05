<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập, chuyển hướng tới trang đăng nhập
if (!isset($_SESSION['Admin-name'])) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lịch Sử</title>
  <link rel="stylesheet" type="text/css" href="css/userslog.css">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
</head>
<body>
  <?php include 'header.php'; ?> 
  <main>
    <section>
      <!--User table-->
      <h1 class="slideInDown animated">Lịch sử ra/vào của học sinh</h1>
      <div class="form-style-5 slideInDown animated">
        <form method="POST" action="Export_Excel.php">
          <input type="date" name="date_sel" id="date_sel">
          <button type="button" name="user_log" id="user_log">Select Date</button>
          <input type="submit" name="To_Excel" value="Export to Excel">
        </form>
      </div>
      <div class="tbl-header slideInRight animated">
        <table cellpadding="0" cellspacing="0" border="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên</th>
              <th>MSV</th>
              <th>ID Vân tay</th>
              <th>Ngày</th>
              <th>Vào</th>
              <th>Ra</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="tbl-content slideInRight animated">
        <div id="userslog"></div>
      </div>
    </section>
  </main>

  <!-- Place jQuery script before your other scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"
          integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
          crossorigin="anonymous">
  </script>
  <script src="js/jquery-2.2.3.min.js"></script>
  <script src="js/user_log.js"></script>
  <script>
    $(document).ready(function(){
      $.ajax({
        url: "user_log_up.php",
        type: 'POST',
        data: {
          'select_date': 1,
        }
      });

      setInterval(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
            'select_date': 0,
          }
        }).done(function(data) {
          $('#userslog').html(data);
        });
      },5000);
    });
  </script>
</body>
</html>
