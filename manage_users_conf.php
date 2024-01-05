<?php  
//Connect to database
require'connectDB.php';

// chọn người dùng
if (isset($_GET['select'])) {

    $Finger_id = $_GET['Finger_id'];

    $sql = "SELECT fingerprint_select FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            $sql="UPDATE users SET fingerprint_select=0";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_Select";
                exit();
            }
            else{
                mysqli_stmt_execute($result);

                $sql="UPDATE users SET fingerprint_select=1 WHERE fingerprint_id=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_select_Fingerprint";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $Finger_id);
                    mysqli_stmt_execute($result);

                    echo "Đã thêm vân tay người dùng";
                    exit();
                }
            }
        }
        else{
            $sql="UPDATE users SET fingerprint_select=1 WHERE fingerprint_id=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo "SQL_Error_select_Fingerprint";
                exit();
            }
            else{
                mysqli_stmt_bind_param($result, "s", $Finger_id);
                mysqli_stmt_execute($result);

                echo "Đã thêm vân tay người dùng";
                exit();
            }
        }
    } 
}
if (isset($_POST['Add'])) {
     
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email= $_POST['email'];

    //optional
    $Timein = $_POST['timein'];
    $Gender= $_POST['gender'];

    //check if there any selected user
    $sql = "SELECT username FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['username']=="Name") {

                if (!empty($Uname) && !empty($Number) && !empty($Email)) {
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "d", $Number);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, user_date=CURDATE(), time_in=? WHERE fingerprint_select=1";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sdsss", $Uname, $Number, $Gender, $Email, $Timein );
                                mysqli_stmt_execute($result);

                                echo "Thêm thành công";
                                exit();
                            }
                        }
                        else {
                            echo "MSV đã được sử dụng";
                            exit();
                        }
                    }
                }
                else{
                    echo "Trống";
                    exit();
                }
            }
            else{
                echo 'Dấu vân tay đã được thêm!';
                exit();
            }    
        }
        else {
            echo "Không có dấu vân tay nào được chọn!";
            exit();
        }
    }
}
//Add user Fingerprint
if (isset($_POST['Add_fingerID'])) {

    $fingerid = $_POST['fingerid'];

    $Uname = "Name";
    $Number = "000000";
    $Email= "Email";

    //optional
    $Timein = "00:00:00";
    $Gender= "Giới tính";

    if ($fingerid == 0) {
        echo "Nhập ID vân tay!";
        exit();
    }
    else{
        if ($fingerid > 0 && $fingerid < 128) {
            $sql = "SELECT fingerprint_id FROM users WHERE fingerprint_id=?";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
              echo "SQL_Error";
              exit();
            }
            else{
                mysqli_stmt_bind_param($result, "i", $fingerid );
                mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
                if (!$row = mysqli_fetch_assoc($resultl)) {

                    $sql = "SELECT add_fingerid FROM users WHERE add_fingerid=1";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                      echo "SQL_Error";
                      exit();
                    }
                    else{
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            //check if there any selected user
                            $sql="UPDATE users SET fingerprint_select=0 WHERE fingerprint_select=1";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                              echo "SQL_Error";
                              exit();
                            }
                            else{
                                mysqli_stmt_execute($result);
                                $sql = "INSERT INTO users ( username, serialnumber, gender, email, fingerprint_id, fingerprint_select, user_date, time_in, del_fingerid , add_fingerid) VALUES (?, ?, ?, ?, ?, 1, CURDATE(), ?, 0, 1)";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                  echo "SQL_Error";
                                  exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdssis", $Uname, $Number, $Gender, $Email, $fingerid, $Timein );
                                    mysqli_stmt_execute($result);
                                    echo "ID đã sẵn sàng để lấy Dấu vân tay mới";
                                    exit();
                                }
                            }
                        }
                        else{
                            echo "Bạn không thể thêm nhiều ID 1 lần";
                        }
                    }   
                }
                else{
                    echo "ID này đã tồn tại!";
                    exit();
                }
            }
        }
        else{
            echo "Vui lòng nhập id từ 1 đến 127!";
            exit();
        }
    }
}
// Cập nhật người dùng hiện tại
if (isset($_POST['Update'])) {

    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email= $_POST['email'];

    //optional
    $Timein = $_POST['timein'];
    $Gender= $_POST['gender'];

    if ($Number == 0) {
        $Number = -1;
    }
    //check if there any selected user
    $sql = "SELECT * FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if (empty($row['username'])) {//nếu username trống trong spl ---> thông báo
                echo "Bạn cần thêm người dùng!";
                exit();
            }
            else{//Nếu có người dùng tiếp tục check
                if (empty($Uname) && empty($Number) && empty($Email) && empty($Timein)) {// nếu không có những phần này tong spl ---báo lỗi --- thoát
                    echo "....";
                    exit();
                }
                else{
                    //kiểm tra xem có người dùng nào đã có Số sê-ri không
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";//khong có MSV---> báo lỗi + thoát
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "d", $Number);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {

                            if (!empty($Uname) && !empty($Email) && !empty($Timein)) {///kiểm tra các giá trị nếu không rỗng-->

                                $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, time_in=? WHERE fingerprint_select=1";//update thông tin đưa ra thông báo
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {// nếu xảy ra lỗi khi truy vấn
                                    echo "SQL_Error_:((";// thông báo
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdsss", $Uname, $Number, $Gender, $Email, $Timein );// nếu không có lỗi khi truy vấn-- thay đổi thông tin người dùng
                                    mysqli_stmt_execute($result);

                                    echo "Thông tin người dùng đã được thay đổi";// đưa ra thông báo
                                    exit();
                                }
                            }
                            else{
                                if (!empty($Timein)) {
                                    $sql="UPDATE users SET gender=?, time_in=? WHERE fingerprint_select=1";// tương tự như phần trên nhưng ở đây là giới tính và time_in
                                    $result = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($result, $sql)) {
                                        echo "SQL_Error_select_Fingerprint";
                                        exit();
                                    }
                                    else{
                                        mysqli_stmt_bind_param($result, "ss", $Gender, $Timein );
                                        mysqli_stmt_execute($result);

                                        echo "Người dùng đã được cập nhật!";
                                        exit();
                                    }
                                }
                                /*else{
                                    echo "Trống phần tin thời gian vào!";
                                    exit();
                                }   */ 
                            }  
                        }
                        else {
                            echo "MSV đã được sử dụng!";
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "Hãy chọn người dùng để cập nhật!";
            exit();
        }
    }
}
// delete user 
if (isset($_POST['delete'])) {

    $sql = "SELECT fingerprint_select FROM users WHERE fingerprint_select=1";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {// truy vấn đến spl cột  fingerprint_select bảng users tại vị trí WHERE fingerprint_select=1 nếu sai đưa ra thông báo và thoát
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_execute($result);// nếu chuẩn bị thành công .....
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {
            $sql="UPDATE users SET del_fingerid=1 WHERE fingerprint_select=1";//update  del_fingerid=1 ở những dòng fingerprint_select=1
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {// kiểm tra ko đủ điều kị báo lỗi --> thoát
                echo "SQL_Error_delete";
                exit();
            }
            else{
                mysqli_stmt_execute($result);
                echo "Đã xóa vân tay người dùng!";// đã đủ đk (đã thay đổi ở sql)--> hiển thị thông báo
                exit();
            }
        }
        else{
            echo "Chọn người dùng để xóa";
            exit();
        }
    }
}
mysqli_stmt_close($result);
mysqli_close($conn);
?>
