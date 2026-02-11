<?php
    session_start();
    include 'connect/connect.php';
    include 'component/function.php';

    if (!isset($_SESSION['s_id'])){
        header('Location: login.php');
        exit();
    }
    $sql_volunteer = $conn->prepare("SELECT * FROM volunteer WHERE s_id = ? ");
    $sql_volunteer->bind_param("i", $_SESSION['s_id']);
    $sql_volunteer->execute();
    $result_volunteer = $sql_volunteer->get_result();
    $count_2 = 0;


    $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql_company->bind_param("s", $_SESSION["s_id"]);
    $sql_company->execute();
    $result_company = $sql_company->get_result();
    $fetch_company = $result_company->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header_print.php");
?>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์แบบบันทึก" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="font-weight: bold;text-align:center">แบบบันทีกความดีและจิตอาสา</p>
            
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
                    <th>บันทึกความดี(จิตอาสา)/สถานที่</th>
                    <th>ผู้รับรอง</th>
                </tr>
                <?php while($fetch_volunteer = $result_volunteer->fetch_assoc()){  $count_2++; ?>
                <tr class="text-center">
                    <td><?php echo ConvertToThaiDateSplit3($fetch_volunteer['v_date']);?></td>
                    <td><?php echo $fetch_volunteer['v_detail']?></td>
                    <td></td>
                </tr>
                <?php } ?>

                
            </table>
            <br/>
           
            <p><b>หมายเหตุ</b> ระบุขอบเขตของพฤติกรรมที่ต้องการพัฒนาหรือความดีที่ควรกระทำ เช่น</p>
            <p style="margin-left: 10px;">
                &#x25CF; การช่วยเหลือครู <br/>
                &#x25CF; การช่วยเพื่อน <br/>
                &#x25CF; การช่วยเหลืองานของสถานศึกษา <br/>
                &#x25CF; การช่วยเหลือชุมชุน ฯลฯ 
            </p>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กิจกรรมต้องเปิดกว้างต่อการททำความดีโดยทั่วไปของผู้ฝึกอาชีพ โดยผู้สอนสามารถสังเกตและจำแนกพฤติกรรมเพื่อตรวจสอบประเมินผู้ฝึกอาชีพโดยไม่ยากนัก</p>
        </div>
    </div>
    


</body>

</html>