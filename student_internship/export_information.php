<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }

    $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql_company->bind_param("s", $_SESSION["s_id"]);
    $sql_company->execute();
    $result_company = $sql_company->get_result();
    $fetch_company = $result_company->fetch_assoc();

    $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
    $sql_student->bind_param("s", $_SESSION["s_id"]);
    $sql_student->execute();
    $result_student = $sql_student->get_result();
    $fetch_student = $result_student->fetch_assoc();

    $sql_information  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
    $sql_information->bind_param("s", $_SESSION["s_id"]);
    $sql_information->execute();
    $result_information = $sql_information->get_result();
    $fetch_information = $result_information->fetch_assoc();

    $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
    $sql_parent->bind_param("s", $_SESSION["s_id"]);
    $sql_parent->execute();
    $result_parent = $sql_parent->get_result();
    $fetch_parent = $result_parent->fetch_assoc();

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
    margin-bottom: 4px !important;
  }
</style>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์แบบประวัติ" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center;margin-bottom:40px">ประวัติผู้ฝึกอาชีพ<br/></h5>
            <p class="text-end" style="margin-top: -100px;">
                <img src="information_file/profile/<?php echo $_SESSION["s_pic"]; ?>" class="img-fluid" style="width: 3cm;height:4cm">
            </p>
            
            <p><b>ข้อมูลเกี่ยวกับผู้ฝึกอาชีพ</b></p>
            <p class="border-dotted">
                <b>1. ชื่อ-สกุล&nbsp;</b> <span><?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?></span>
                <b>&nbsp;ระดับชั้น / กลุ่ม&nbsp;</b> <span><?php echo $_SESSION["s_year"]; ?></span>
                <b>&nbsp;รหัสประจำตัว&nbsp;</b> <span><?php echo $_SESSION["s_student_id"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;หลักสูตรการศึกษา&nbsp;</b> <span><?php echo $_SESSION["s_type_edu"]; ?></span>
                <b>&nbsp;แผนกวิชา&nbsp;</b> <span><?php echo $_SESSION["s_major"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;วัน/เดือน/ปีเกิด&nbsp;</b> <span><?php echo $fetch_information["s_birthday"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_information["s_age"]; ?></span>
                <b>&nbsp;สูง&nbsp;</b> <span><?php echo $fetch_information["s_height"]; ?></span>&nbsp;เซนติเมตร 
                <b>&nbsp;น้ำหนัก&nbsp;</b> <span><?php echo $fetch_information["s_weight"]; ?></span>&nbsp;กิโลกรัม
                <b>&nbsp;สัญชาติ&nbsp;</b> <span><?php echo $fetch_information["s_nation1"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;เชื้อชาติ&nbsp;</b> <span><?php echo $fetch_information["s_nation2"]; ?></span>
                <b>&nbsp;ศาสนา&nbsp;</b> <span><?php echo $fetch_information["s_region"]; ?></span>
                <b>&nbsp;โรคประจำตัว&nbsp;</b> <span><?php echo $fetch_information["s_hospital"]; ?></span>
                <b>&nbsp;ประวัติการแพ้ยา/อื่นๆ&nbsp;</b> <span><?php echo $fetch_information["s_medicine"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;กลุ่มเลือด&nbsp;</b> <span><?php echo $fetch_information["s_blood"]; ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $_SESSION["s_tel"]; ?></span>
                <b>&nbsp;Email&nbsp;</b> <span><?php echo $_SESSION["s_email"]; ?></span>
            </p>



            <p class="border-dotted">
                <b>2. ภูมิลำเนาของผู้ฝึกอาชีพ เลขที่&nbsp;</b> <span><?php echo $fetch_information["s_home1"]; ?></span>
                <b>&nbsp;หมู่ที่&nbsp;</b> <span><?php echo $fetch_information["s_moo1"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b> <span><?php echo $fetch_information["s_soi1"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b> <span><?php echo $fetch_information["s_road1"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;ตำบล&nbsp;</b> <span><?php echo FetchSubDistrict($fetch_information["s_tumbon1"], $conn); ?></span>
                <b>&nbsp;อำเภอ&nbsp;</b> <span><?php echo FetchDistrict($fetch_information["s_aumpher1"], $conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b> <span><?php echo FetchProvince($fetch_information["s_province1"], $conn); ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $_SESSION["s_tel"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>3. ที่อยู่ปัจจุบันของผู้ฝึกอาชีพ เลขที่&nbsp;</b> <span><?php echo $fetch_information["s_home2"]; ?></span>
                <b>&nbsp;หมู่ที่&nbsp;</b> <span><?php echo $fetch_information["s_moo2"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b> <span><?php echo $fetch_information["s_soi2"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b> <span><?php echo $fetch_information["s_road2"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;ตำบล&nbsp;</b> <span><?php echo FetchSubDistrict($fetch_information["s_tumbon2"], $conn); ?></span>
                <b>&nbsp;อำเภอ&nbsp;</b> <span><?php echo FetchDistrict($fetch_information["s_aumpher2"], $conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b> <span><?php echo FetchProvince($fetch_information["s_province2"], $conn); ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $_SESSION["s_tel"]; ?></span>
            </p>



         
            
            <p class="border-dotted">
                <b>4. ผู้เกี่ยวข้อง&nbsp;</b>
                <b>&nbsp;ชื่อบิดา&nbsp;</b> <span><?php echo $fetch_parent["p_dad"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_parent["p_dad_age"]; ?></span>
                <b>&nbsp;อาชีพ&nbsp;</b> <span><?php echo $fetch_parent["p_dad_position"]; ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_parent["p_dad_tel"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;ชื่อมารดา&nbsp;</b> <span><?php echo $fetch_parent["p_mom"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_parent["p_mom_age"]; ?></span>
                <b>&nbsp;อาชีพ&nbsp;</b> <span><?php echo $fetch_parent["p_mom_position"]; ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_parent["p_mom_tel"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;ผู้ปกครอง&nbsp;</b> <span><?php echo $fetch_parent["p_parent"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_parent["p_parent_age"]; ?></span>
                <b>&nbsp;อาชีพ&nbsp;</b> <span><?php echo $fetch_parent["p_parent_position"]; ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_parent["p_parent_tel"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;เพื่อนสนิท 1.&nbsp;</b> <span><?php echo $fetch_parent["p_friend1"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_parent["p_friend1_age"]; ?></span>
                <b>&nbsp;อาชีพ&nbsp;</b> <span><?php echo $fetch_parent["p_friend1_position"]; ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_parent["p_friend1_tel"]; ?></span>
                <?php if($fetch_parent["p_friend2"] != "-"){ ?>
                    <b>2.</b><span><?php echo $fetch_parent["p_friend2"]; ?></span>
                    <b>อายุ</b> <span><?php echo $fetch_parent["p_friend2_age"]; ?></span>
                    <b>อาชีพ</b> <span><?php echo $fetch_parent["p_friend2_position"]; ?></span>
                    <b>โทรศัพท์</b> <span><?php echo $fetch_parent["p_friend2_tel"]; ?></span>
                <?php } else {  ?>
                <?php } ?> 
            </p>

          

            <p class="border-dotted">
                <b>5. คะแนนเฉลี่ยสะสม&nbsp;</b><span><?php echo $_SESSION["s_grade"]; ?></span>              
            </p>

            <p><b>6. ความสามารถพิเศษ</b></p>
            <?php
                $specials = explode(",", $_SESSION['s_special']);                     
                foreach($specials as $index => $special){
            ?>
            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "6.".($index+1)." "; ?>&nbsp</b><span><?php echo $special; ?></span>
            </p>
            <?php } ?>

            <p class="border-dotted">
                <b>7. บุคคลใกล้ชิดที่ติดต่อได้ ชื่อ-สกุล&nbsp;</b> <span><?php echo $fetch_parent["p_close"]; ?></span>
                <b>&nbsp;อายุ&nbsp;</b> <span><?php echo $fetch_parent["p_close_age"]; ?></span>
                <b>&nbsp;มีความเกี่ยวข้องเป็น&nbsp;</b> <span><?php echo $fetch_parent["p_close_relation"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;ที่อยู่เลขที่&nbsp;</b> <span><?php echo $fetch_parent["p_home"]; ?></span>
                <b>&nbsp;หมู่ที่&nbsp;</b> <span><?php echo $fetch_parent["p_moo"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b> <span><?php echo $fetch_parent["p_soi"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b> <span><?php echo $fetch_parent["p_road"]; ?></span>
                <b>&nbsp;ตำบล&nbsp;</b> <span><?php echo FetchSubDistrict($fetch_parent["p_tumbon"], $conn); ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;อำเภอ&nbsp;</b> <span><?php echo FetchDistrict($fetch_parent["p_aumpher"],$conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b> <span><?php echo FetchProvince($fetch_parent["p_province"], $conn); ?></span>
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_parent["p_close_tel"]; ?></span>
            </p>



            <p><b>8. ครูผู้รับผิดชอบ/ประสานงาน</b></p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;8.1 หัวหน้าแผนก ชื่อ-สกุล&nbsp;</b> <span><?php echo $fetch_company["c_head"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;8.2 ครูที่ปรึึกษา ชื่อ-สกุล&nbsp;</b> <span><?php echo FetchTeacher($fetch_company["c_advice"], $conn); ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;8.3 ครูนิเทศ ชื่อ-สกุล&nbsp;</b> <span><?php echo FetchTeacher($fetch_company["c_advice2"], $conn); ?></span> 
            </p>

            <p><b>9. ระยะเวลาการฝึกอาชีพ </b></p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;เริ่มต้น&nbsp;</b><span><?php echo $fetch_company["c_start"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;สิ้นสุด&nbsp;</b><span><?php echo $fetch_company["c_end"]; ?></span>
            </p>

         
           
        
           
           
           
            <br/>

        </div>
    </div>
    


</body>

</html>