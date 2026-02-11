<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }

    $sql = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql->bind_param("s", $_SESSION["s_id"]);
    $sql->execute();
    $result = $sql->get_result();
    $fetch_company = $result->fetch_assoc();

    $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
    $sql_student->bind_param("s", $_SESSION["s_id"]);
    $sql_student->execute();
    $result_student = $sql_student->get_result();
    $fetch_student = $result_student->fetch_assoc();

    function FetchProvince($province_id, $conn){
        $sql_province = "SELECT * FROM th_province WHERE province_id = '".$province_id."'";
        $query_province = mysqli_query($conn,$sql_province);
        $fetch_province = mysqli_fetch_assoc($query_province);
        return $fetch_province['name_th'];
    }

    function FetchDistrict($distrcit_id, $conn_district){
        $sql_district = $conn_district->prepare("SELECT * FROM th_district where district_id = ?");
        $sql_district->bind_param("i",$distrcit_id);
        $sql_district->execute();
        $result_district = $sql_district->get_result();
        $fetch_aumpher = $result_district->fetch_assoc();
        return $fetch_aumpher['name_th'];
    }

    function FetchSubDistrict($subdistrict_id, $conn_subdistrict){
        $sql_subdistrict = "SELECT * FROM th_subdistrict where subdistrict_id = '".$subdistrict_id."'";
        $query_subdistrict = mysqli_query($conn_subdistrict,$sql_subdistrict);
        $fetch_tumbon =  mysqli_fetch_assoc($query_subdistrict);
        return $fetch_tumbon['name_th'];
    }


?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header_print.php");
?>

<style>
  /* คอนเทนเนอร์หลัก */
  .border-dotted {
    position: relative;
    display: flex; /* ใช้ Flexbox เพื่อจัดให้อยู่ในบรรทัดเดียวกัน */
    align-items: center; /* จัดให้เนื้อหากึ่งกลางแนวตั้ง */
  }

  /* เส้นใต้แบบจุด */
  .border-dotted::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%; /* ขยายเส้นใต้ให้เต็มความกว้าง */
    border-bottom: 1px dotted #000; /* เส้นใต้แบบจุด */
    z-index: 0; /* ทำให้เส้นอยู่ด้านล่าง */
  }

  /* ข้อความภายใน */
  .border-dotted b {
  	background: #fff; 
    position: relative;
    z-index: 1; /* ให้หัวข้ออยู่เหนือเส้นใต้ */
  }

  .border-dotted span {
    position: relative;
    z-index: 1; /* ให้ข้อความอยู่เหนือเส้นใต้ */
  }
  .img-frame{
    border: 1px solid #000;
    padding: 10px;
  }
  p{
    margin-bottom: 3px !important;
  }
  hr {
            border: none;
            border-top: 2px dotted #000;
            color: #fff;
            background-color: #fff;
            height: 10px;
           
    }
</style>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์แบบประเมิน" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center;margin-bottom:40px">แฟ้มสะสมผลงานผู้ฝึกอาชีพ<br/>(PORTFOLIO)</h5>
            <p class="text-center">
                <img src="information_file/profile/<?php echo $fetch_student["s_pic"]; ?>" class="img-fluid" style="width: 3cm;height:4cm">
            </p>
            

            <p class="border-dotted" style="margin-top: 40px;">
                <b>&nbsp;ชื่อ-สกุล&nbsp;</b> <span><?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?></span>
                <b>&nbsp;รหัสประจำตัว&nbsp;</b> <span><?php echo $fetch_student["s_student_id"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;ระดับชั้น / กลุ่ม&nbsp;</b> <span><?php echo $fetch_student["s_year"]; ?></span>
                <b>&nbsp;สาขางาน&nbsp;</b> <span><?php echo $fetch_student["s_major"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;สถานศึกษา&nbsp;</b> <span>วิทยาลัยเทคนิคฉะเชิงเทรา</span>
            </p>


            <p class="border-dotted mt-5">
                <b>&nbsp;สถานประกอบการ&nbsp;</b> <span><?php echo $fetch_company["c_name"]; ?>
            </p>

            <p class="border-dotted">
                <b>&nbsp;ที่ตั้งเลขที่&nbsp;</b> <span><?php echo $fetch_company["c_home"]; ?> </span>
                <b>&nbsp;หมูที่&nbsp;</b> <span><?php echo $fetch_company["c_moo"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b> <span><?php echo $fetch_company["c_soi"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b> <span><?php echo $fetch_company["c_road"]; ?></span>
            </p>

           
            <p class="border-dotted">
                <b>&nbsp;ตำบล&nbsp;</b> <span><?php echo FetchSubDistrict($fetch_company["c_tumbon"],$conn); ?></span> 
                <b>&nbsp;อำเภอ&nbsp;</b> <span><?php echo FetchDistrict($fetch_company["c_aumpher"],$conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b> <span><?php echo FetchProvince($fetch_company["c_province"],$conn); ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_company["c_tel"]; ?></span>
                <b>&nbsp;โทรสาร&nbsp;</b> <span><?php echo $fetch_company["c_tel2"]; ?></span>
            </p>
           
           
           
            <br/>

        </div>
    </div>
    


</body>

</html>