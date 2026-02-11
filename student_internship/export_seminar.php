<?php
    session_start();
    include 'connect/connect.php';
    include 'component/function.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }
    $sql_seminar = $conn->prepare("SELECT * FROM seminar WHERE s_id = ? ");
    $sql_seminar->bind_param("i", $_SESSION['s_id']);
    $sql_seminar->execute();
    $result_seminar = $sql_seminar->get_result();
    $count_3 = 0;

    $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql_company->bind_param("s", $_SESSION["s_id"]);
    $sql_company->execute();
    $result_company = $sql_company->get_result();
    $fetch_company = $result_company->fetch_assoc();

    function FetchTeacher($teacher_id, $conn){
        $sql_teacher = $conn->prepare("SELECT * FROM teachers where t_id = ?");
        $sql_teacher->bind_param("i",$teacher_id);
        $sql_teacher->execute();
        $result_teacher = $sql_teacher->get_result();
        $fetch_teacher = $result_teacher->fetch_assoc();
        return $fetch_teacher['t_prefix'].$fetch_teacher['t_name']." ".$fetch_teacher['t_surname'];
    }


?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header_print.php");
?>

<body style="font-size: 16px !important;">

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="font-weight: bold;text-align:center">แบบเข้าร่วมกิจกรรมการสัมมนา</p>


            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <p class="text-center mt-3">
                            <b>ชื่อ-สกุล</b> <?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?> 
                            <b>รหัสประจำตัว</b> <?php echo $_SESSION["s_student_id"]; ?> 
                            <b>ระดับชั้น / กลุ่ม</b> <?php echo $_SESSION["s_year"]; ?><br/>
                            <b>สาขาวิชา</b> <?php echo $_SESSION["s_major"]; ?>
                            <b>สถานศึกษา</b> วิทยาลัยเทคนิคฉะเชิงเทรา
                        </p>
                        <br/>
                        <table style="margin-top: 5px;" class="w-100">
                            <tr style="text-align:center">
                                <th>วัน/เดือน/ปี</th>
                                <th>กิจกรรม</th>
                                <th>ผู้รับรอง</th>
                            </tr>
                            <?php while($fetch_seminar = $result_seminar->fetch_assoc()){  $count_3++; ?>
                            <tr class="text-center">
                                <td><?php echo ConvertToThaiDateSplit3($fetch_seminar['se_date']); ?></td>
                                <td><?php echo $fetch_seminar['se_detail']; ?></td>
                                <td>...........................</td>
                            </tr>
                            <?php } ?>

                            
                        </table>
                        <br/>
                        <p>สรุปผลการเข้าร่วมกิจกรรมสัมมนา.....วัน มา.....วัน มาสาย.....วัน ขาด.....วัน</p>
                        <br>
                    </div>

                    <div class="col-4">
                        <p class="text-center">...................................</p>
                        <p class="text-center">(<?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?>)</p>
                        <p class="text-center">ผู้ฝึกอาชีพ</p>
                    </div>

                    <div class="col-4">
                        <p class="text-center">...................................</p>
                        <p class="text-center">(<?php echo FetchTeacher($fetch_company['c_advice2'] ,$conn)?>)</p>
                        <p class="text-center">ครูนิเทศ</p>,
                    </div>

                    <div class="col-4">
                        <p class="text-center">...................................</p>
                        <p class="text-center">(<?php echo $fetch_company['c_head'] ?>)</p>
                        <p class="text-center">หัวหน้าแผนก</p>
                    </div>
                </div>
            </div>

        </div>        
    </div>
    


</body>

</html>