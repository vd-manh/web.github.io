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
	<title>Quản lí</title>
<link rel="stylesheet" type="text/css" href="css/manageusers.css">
<script>
  $(window).on("load resize ", function() {
    var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
    $('.tbl-header').css({'padding-right':scrollWidth});
}).resize();
</script>
<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha1256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous">
</script>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/manage_users.js"></script>
<script>
  $(document).ready(function(){
  	  $.ajax({
        url: "manage_users_up.php"
        }).done(function(data) {
        $('#manage_users').html(data);
      });
    setInterval(function(){
      $.ajax({
        url: "manage_users_up.php"
        }).done(function(data) {
        $('#manage_users').html(data);
      });
    },5000);
  });
</script>
</head>
<body>
<?php include'header.php';?>
<main>
	<h1 class="slideInDown animated">THÊM NGƯỜI DÙNG MỚI HOẶC CẬP NHẬT THÔNG TIN CỦA NGƯỜI DÙNG  <br> HOẶC XÓA NGƯỜI DÙNG</h1>
	<div class="form-style-5 slideInDown animated">
		<div class="alert">
		<label id="alert"></label>
		</div>
		<form>
			<fieldset>
			<legend><span class="number">1</span> ID học sinh</legend>
				<label>Vui lòng nhập id từ 1 đến 127:</label>
				<input type="number" name="fingerid" id="fingerid" placeholder="ID vân tay...">
				<button type="button" name="fingerid_add" class="fingerid_add">Thêm ID</button>
			</fieldset>
			<fieldset>
				<legend><span class="number">2</span> Thông tin học sinh</legend>
				<input type="text" name="name" id="name" placeholder="Họ tên...">
				<input type="text" name="number" id="number" placeholder="Mã sinh viên...">
				<input type="email" name="email" id="email" placeholder="Email...">
			</fieldset>
			<fieldset>
			<legend><span class="number">3</span> Thông tin bổ xung</legend>
			<label>
				Thời gian:
				<input type="time" name="timein" id="timein">
				<input type="radio" name="gender" class="gender" value="Nữ">Nữ
				<input type="radio" name="gender" class="gender" value="Nam" checked="checked">Nam


	      	</label >
			</fieldset>
			<button type="button" name="user_add" class="user_add">Thêm học sinh</button>
			<button type="button" name="user_upd" class="user_upd">Cập nhật thông tin</button>
			<button type="button" name="user_rmo" class="user_rmo">Xóa</button>
		</form>
	</div>

	<div class="section">
	<!--User table-->
		<div class="tbl-header slideInRight animated">
		    <table cellpadding="0" cellspacing="0" border="0">
		      <thead>
		        <tr>
	        	  <th>ID</th>
		          <th>Tên</th>
		          <th>Giới tính</th>
		          <th>MSV</th>
		          <th>Ngày</th>
		          <th>Thời Gian</th>
		        </tr>
		      </thead>
		    </table>
		</div>
		<div class="tbl-content slideInRight animated">
		    <table cellpadding="0" cellspacing="0" border="0">
		      <div id="manage_users"></div>
		</div>
	</div>

</main>
</body>
</html>