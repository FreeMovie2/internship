<?php
    session_start();
    include 'connect/connect.php';
    include 'component/function.php';

    if (!isset($_SESSION['t_id'])) {
        header('Location: login.php');
        exit();
    }

    if(isset($_GET['student_id']) && $_SERVER["REQUEST_METHOD"] == "GET"){
        $s_id = $_GET['student_id'];
        $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
        $sql_company->bind_param("s", $s_id);
        $sql_company->execute();
        $result_company = $sql_company->get_result();
        $fetch_company = $result_company->fetch_assoc();

            $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
            $sql_student->bind_param("s", $s_id);
            $sql_student->execute();
            $result_student = $sql_student->get_result();
            $fetch_student = $result_student->fetch_assoc();

            $sql_information  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
            $sql_information->bind_param("s", $s_id);
            $sql_information->execute();
            $result_information = $sql_information->get_result();
            $fetch_information = $result_information->fetch_assoc();

            $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
            $sql_parent->bind_param("s", $s_id);
            $sql_parent->execute();
            $result_parent = $sql_parent->get_result();
            $fetch_parent = $result_parent->fetch_assoc();

            $sql_activity = $conn->prepare("SELECT * FROM activity WHERE s_id = ? ");
            $sql_activity->bind_param("i", $_SESSION['s_id']);
            $sql_activity->execute();
            $result_activity = $sql_activity->get_result();
            $count = 0;

            $sql_volunteer = $conn->prepare("SELECT * FROM volunteer WHERE s_id = ? ");
            $sql_volunteer->bind_param("i", $_SESSION['s_id']);
            $sql_volunteer->execute();
            $result_volunteer = $sql_volunteer->get_result();
            $count_2 = 0;

            $sql_seminar = $conn->prepare("SELECT * FROM seminar WHERE s_id = ? ");
            $sql_seminar->bind_param("i", $_SESSION['s_id']);
            $sql_seminar->execute();
            $result_seminar = $sql_seminar->get_result();
            $count_3 = 0;

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

            function FetchTeacherComment($student_id, $week , $conn){
                $sql_fetch_comment = $conn->prepare("SELECT * FROM teacher_comment where s_id = ? AND tc_week = ?");
                $sql_fetch_comment->bind_param("ss",$student_id, $week);
                $sql_fetch_comment->execute();
                $result_comment = $sql_fetch_comment->get_result();
                $fetch_comment = $result_comment->fetch_assoc();
                return $fetch_comment['tc_detail'];
            }

            function NumFetchTeacherComment($student_id, $week , $conn){
                $sql_fetch_comment = $conn->prepare("SELECT * FROM teacher_comment where s_id = ? AND tc_week = ?");
                $sql_fetch_comment->bind_param("ss",$student_id, $week);
                $sql_fetch_comment->execute();
                $result_comment = $sql_fetch_comment->get_result();
                $num_comment = $result_comment->num_rows;
                return $num_comment;
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
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.history.go(-1); return false;" />
        <input class="MyButton2" type="button" value="พิมพ์/ส่งออก" onclick="window.print();" />
    </form>

    <!-- Company Information -->
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center">รายละเอียดสถานประกอบการ</h5>
            <p class="border-dotted">
                <b>ชื่อสถานประกอบการ&nbsp;</b>
                <span>
                    <?php echo $fetch_company["c_name"]; ?>
                </span>
            </p>
            <p class="border-dotted">
                <b>ที่ตั้งเลขที่&nbsp;</b><span><?php echo $fetch_company["c_home"]; ?></span>
                <b>&nbsp;หมูที่&nbsp;</b><span><?php echo $fetch_company["c_moo"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b><span><?php echo $fetch_company["c_soi"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b><span><?php echo $fetch_company["c_road"]; ?></span>
            </p>
            <p class="border-dotted">
                <b>ตำบล&nbsp;</b><span><?php echo FetchSubDistrict($fetch_company["c_tumbon"], $conn); ?></span>
                <b>&nbsp;อำเภอ&nbsp;</b><span><?php echo FetchDistrict($fetch_company["c_aumpher"], $conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b><span><?php echo FetchProvince($fetch_company["c_province"], $conn); ?></span>   
            </p>
            <p class="border-dotted">   
                <b>โทรศัพท์&nbsp;</b><span><?php echo $fetch_company["c_tel"]; ?></span>
                <b>&nbsp;โทรสาร&nbsp;</b><span><?php echo $fetch_company["c_tel2"]; ?></span>
                <b>&nbsp;เว็ปไซต์&nbsp;</b><span><?php echo $fetch_company["c_website"]; ?></span>
            </p>
            <p class="border-dotted">  
               <b>สถานที่อยู่ใกล้เคียง และสังเกตได้ง่าย คือ&nbsp;</b><span><?php echo $fetch_company["c_similar"]; ?></span>
            </p>
            <br/>

            <p><b>ชื่อผู้เรียน เข้ารับการฝึกอาชีพ</b></p>
            <p class="border-dotted"> 
                <b>&nbsp;&nbsp;&nbsp;&nbsp;</b><b>1.&nbsp;&nbsp; ชื่อ-สกุล&nbsp;</b> 
                <span><?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?></span>  
                <b>&nbsp;แผนกวิชา&nbsp;</b><span><?php echo $fetch_company["c_position"]; ?></span>
            </p>
           
            <br/>

          

        </div>
    </div>

    <div class="page">
        <div class="subpage">
            <p class="text-center"><b>แผนที่ตั้งสถานประกอบการ</b></p>
            <p class="text-center"><img src="../student_internship/information_file/company/<?php echo $fetch_company["c_map"]; ?>" class="ing-fluid img-frame w-75"/></p>

            <p class="text-center mt-5"><b>แผนผังโครงสร้างตำแหน่งงานของสถานประกอบการณ์</b></p>
            <p class="text-center"><img src="../student_internship/information_file/company/<?php echo $fetch_company["c_org"]; ?>" class="ing-fluid img-frame w-75"/></p>
        </div>
    </div>     


    <!-- Personal Information -->
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center;margin-bottom:40px">ประวัติผู้ฝึกอาชีพ<br/></h5>
            <p class="text-end" style="margin-top: -100px;">
                <img src="../student_internship/information_file/profile/<?php echo $fetch_student["s_pic"]; ?>" class="img-fluid" style="width: 3cm;height:4cm">
            </p>
            
            <p><b>ข้อมูลเกี่ยวกับผู้ฝึกอาชีพ</b></p>
            <p class="border-dotted">
                <b>1. ชื่อ-สกุล&nbsp;</b> <span><?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?></span>
                <b>&nbsp;ระดับชั้น / กลุ่ม&nbsp;</b> <span><?php echo $fetch_student["s_year"]; ?></span>
                <b>&nbsp;รหัสประจำตัว&nbsp;</b> <span><?php echo $fetch_student["s_student_id"]; ?></span>
            </p>

            <p class="border-dotted">
                <b>&nbsp;&nbsp;&nbsp;&nbsp;หลักสูตรการศึกษา&nbsp;</b> <span><?php echo $fetch_student["s_type_edu"]; ?></span>
                <b>&nbsp;แผนกวิชา&nbsp;</b> <span><?php echo $fetch_student["s_major"]; ?></span>
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
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_student["s_tel"]; ?></span>
                <b>&nbsp;Email&nbsp;</b> <span><?php echo $fetch_student["s_email"]; ?></span>
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
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_student["s_tel"]; ?></span>
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
                <b>&nbsp;โทรศัพท์&nbsp;</b> <span><?php echo $fetch_student["s_tel"]; ?></span>
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
                <b>5. คะแนนเฉลี่ยสะสม&nbsp;</b><span><?php echo $fetch_student["s_grade"]; ?></span>              
            </p>

            <p><b>6. ความสามารถพิเศษ</b></p>
            <?php
                $specials = explode(",", $fetch_student['s_special']);                     
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


    <!-- Internship Submission -->
    <?php
        for($week_ref = 1; $week_ref <= 18; $week_ref++){
            $sql_weekly = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? ORDER BY i_day ASC");
            $sql_weekly->bind_param("ii", $fetch_student["s_id"], $week_ref);
            $sql_weekly->execute();
            $result_weekly = $sql_weekly->get_result();
    
            $sql_weekly_2 = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? ORDER BY i_day ASC");
            $sql_weekly_2->bind_param("ii", $fetch_student["s_id"], $week_ref);
            $sql_weekly_2->execute();
            $result_weekly_2 = $sql_weekly_2->get_result();

    
            $cont_weekly = $result_weekly->num_rows;
            $days = ["อาทิตย์","จันทร์", "อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
    ?>
        <?php if($cont_weekly == 5){ ?>
        <div class="page">
            <div class="subpage">
                <p class="text-center" style="font-weight: bold;text-align:center">แบบบันทึกการฝึกอาชีพประจำวัน</p>
                <p class="text-center">
                    สัปดาห์ที่ <?php echo $week_ref; ?>
                    <?php
                        $sql_start = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
                        $s = 1;
                        $sql_start->bind_param("iii",$fetch_student['s_id'], $week_ref, $s);
                        $sql_start->execute();
                        $result_start = $sql_start->get_result();
                        $fetch_start = $result_start->fetch_assoc();
                        echo ConvertToThaiDate($fetch_start['i_date']);
                    ?>
                    ถึง
                    <?php
                        $sql_end = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
                        $s = 5;
                        $sql_end->bind_param("iii",$fetch_student['s_id'], $week_ref, $s);
                        $sql_end->execute();
                        $result_end = $sql_end->get_result();
                        $fetch_end = $result_end->fetch_assoc();
                        echo ConvertToThaiDate($fetch_end['i_date']);
                    ?>
                </p>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="table-responsive">
                                <table class="w-100">
                                    <thead>
                                        <tr class="text-center">
                                            <th>รายละเอียดของงานที่ฝึกอาชีพ</th>
                                            <th>หมายเหตุ</th>
                                            
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php while($fetch_weekly = $result_weekly->fetch_assoc()){?>

                                        <tr class="">
                                            <td>
                                                วัน<?php echo $days[$fetch_weekly['i_day']]; ?> ที่ <?php echo $fetch_weekly['i_date']; ?><br/>
                                                รายละเอียด : <?php echo $fetch_weekly['i_detail']; ?> <br/>
                                                ลงชื่อ <?php echo $fetch_student['s_name']; ?> ผู้ฝึกอาชีพ
                                            
                                            </td>
                                            <td>
                                                เวลาเข้างาน <?php echo $fetch_weekly['i_start'];?> น.<br/>
                                                เวลาออกงาน <?php echo $fetch_weekly['i_end'];?> น.<br/>
                                                จำนวน <?php echo $fetch_weekly['i_count'];?> ชั่วโมง<br/>
                                                <?php
                                                    if($fetch_weekly['i_day']== 5){
                                                ?>
                                                    <br/>
                                                    <p class="text-end">
                                                        (ลงชื่อ).................................<br/>
                                                        ครูฝึก/ผู้ควบคุมการฝึก
                                                    </p>

                                                <?php } ?>
                                            </td>
                                        
                                        </tr>

                                        <?php } ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        <?php if(NumFetchTeacherComment($s_id,$week_ref,$conn) == 0) {?>
                        <div class="col-7">
                            
                            <p><b>บันทึกครูนิเทศ : </b>
                            ...................................................................<br/>
                            ...............................................................................................<br/>
                            ...............................................................................................<br/>
                            </p>
                            <p class="text-center mt-3">
                                ลงชื่อ...........................................ครูนิเทศ
                            </p>
                            <p class="text-center">
                                (<?php echo FetchTeacher($fetch_company['c_advice2'], $conn); ?>)
                            </p>
                        </div>
                        <?php }else{ ?>
                        <div class="col-7">
                            
                            <p>บันทึกครูนิเทศ : <?php echo FetchTeacherComment($s_id,$week_ref,$conn); ?> </p>
                            <p class="text-center mt-3">
                                ลงชื่อ...........................................ครูนิเทศ
                            </p>
                            <p class="text-center">
                                (<?php echo FetchTeacher($fetch_company['c_advice2'], $conn); ?>)
                            </p>
                        </div>
                        <?php } ?>

                        <div class="col-5">
                            <p><b>บันทึกครูฝึก : </b>
                            ..........................................<br/>
                            ..................................................................<br/>
                            ..................................................................<br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
                

            
                
        </div>

        <?php while($fetch_weekly2 = $result_weekly_2->fetch_assoc()){?>
            <div class="page">
                <div class="subpage">
                    
                    <p class="text-center mb-2"  style="font-weight: bold;text-align:center">
                        ภาพประกอบการฝึกอาชีพสัปดาห์ที่ <?php echo $week_ref; ?>
                    
                    </p>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <p class="text-center">วัน<?php echo $days[$fetch_weekly2['i_day']]; ?> ที่ <?php echo $fetch_weekly2['i_date']; ?></p>
                                <hr>

                                <p class="text-center"><img src="../student_internship/uploaded/internship_img/<?php echo $fetch_weekly2['i_img1']; ?>" style="max-width:500px; max-height:300px; display:block; margin:0 auto;"/></p>
                                <p class="text-justify mt-1"><b>รายละเอียด : </b><?php echo $fetch_weekly2['i_img1_detail']; ?></p>

                                <p class="text-center"><img src="../student_internship/uploaded/internship_img/<?php echo $fetch_weekly2['i_img2']; ?>" style="max-width:500px; max-height:300px; display:block; margin:0 auto;"/></p>
                                <p class="text-justify mt-2"><b>รายละเอียด : </b><?php echo $fetch_weekly2['i_img2_detail']; ?></p>
                                
                            </div>


                        </div>
                    </div>
                </div>
                    

                
                    
            </div>
        <?php } ?>
        <?php } ?>

    <?php } ?>


    <!-- Evaluation Page -->
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center">แบบประเมินผลการฝึกอาชีพ</h5>
            <p><b>ชื่อสถานประกอบการ</b> <?php echo $fetch_company["c_name"]; ?></p>
            <p><b>ชื่อ-สกุล ผู้ฝึกอาชีพ</b> <?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?> 
            <b>รหัสนักศึกษา</b> <?php echo $fetch_student["s_student_id"]; ?> 
            <b>แผนกวิชา</b>  <?php echo $fetch_student["s_major"]; ?> 
            </p>
            <br/>
            <table style="margin-top: 5px;" class="w-100">
                <tr style="text-align:center">
                    <th>คุณลักษณะ</th>
                    <th>คะแนนเต็ม</th>
                    <th>คะแนนที่ได้</th>
                </tr>
                <tr>
                    <td>&nbsp;1. &nbsp;มีความรู้เกี่ยวกับงานในหน้าที่</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;2.  &nbsp;มีความตั้งใจแสวงหาความรู้และเรียนรู้งาน</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความขยันอดทน</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความคิดริเริ่ม</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;3.  &nbsp;มีทักษะในการใช้ภาษาเพื่อการศึกษา</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;4.  &nbsp;มีทักษะในการทำงาน การใช้วัสดุและเครื่องมืออุปกรณ์ในการวิชาชีพ</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;5.  &nbsp;ปฏิบัติงานได้อย่างมีระบบและคุณภาพ</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;6.  &nbsp;มีความสามารถในการปรับตัวและปัญหา</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;7.  &nbsp;มีความกระตือรือร้น ตรงต่อเวลา และซื่อสัตย์</td>
                    <td style="text-align: center;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;8.  &nbsp;มีความเอาใจใส่และรับผิดชอบงาน</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;9.  &nbsp;มีการแต่งกาย กิริยา วาจาสุภาพเรียบร้อย</td>
                    <td style="text-align: center;">5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;10.  &nbsp;มีมนุษย์สัมพันธ์และมีความรอบรู้ทันต่อเหตุการณ์</td>
                    <td style="text-align: center;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ความกระตือรือร้น</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- รอบรู้ทันต่อเหตุการณ์ในยุคปัจจุบัน</td>
                    <td style="text-align: center;">2.5</td>
                    <td></td>
                </tr>
                <tr>
                    <td  style="text-align: center;"><b>รวมคะแนน</b></td>
                    <td style="text-align: center;">60</td>
                    <td></td>
                </tr>
                
            </table>
            <br/>
            <p>ข้อเสนอแนะ
              
               

            </p>
            <hr>
            <hr>
            <hr>
            <hr>

            <p><b>ผลการประเมิน  &nbsp;&nbsp;▢ ผ่าน &nbsp;&nbsp;▢ ไม่ผ่าน</b></p>
            <br/>
            <p style="text-align: right;">ลงชื่อ..............................................ครูฝึก</p>
            <p style="text-align: right;">(........................................)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p style="text-align: right;">ตำแหน่ง.......................................................</p>
            <br/>

        
          
            <small><b>หมายเหตุ</b> : ประทับตราสถานประกอบการไว้ใต้ผลการประเมินพร้อมลงลายมือชื่อกำกับ (ถ้ามี)<br/>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           &nbsp;: ผู้ที่จะผ่านการประเมินผลการฝึกอาชีพ จะต้องได้ค่าคะแนนรวมไม่ต่ำกว่าร้อยละ 70 (42 คะแนน)</small>
        </div>
    </div>

    <!-- Export Student -->
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="margin-bottom: 160px !important;">ประทับตราสถานประกอบการ</p>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <p>........................</p>
                    </div>
                    <div class="col-4">
                        <p></p>
                    </div>
                    <div class="col-4">
                        <p><?php echo $fetch_company['c_name']; ?></p>
                    </div>
                    
                    <div class="col-5"></div>
                    <div class="col-5">
                        <br/>
                        <p class="text-center">......................................................</p>
                        <br/>
                    </div>
                    
                    <div class="col-2"></div>

                    <div class="col-12">
                        <p>เรียน&nbsp;&nbsp;ผู้อำนวยการวิทยาลัยเทคนิคฉะเชิงเทรา</p>
                        <p>เรื่อง&nbsp;&nbsp;ขอส่งตัวนักศึกษาฝึกอาชีพกลับสถานศึกษา</p>
                        <p>สิ่งที่ส่งมาด้วย&nbsp;&nbsp;แบบประเมินผลการฝึกอาชีพ</p>
                        <br/>
                        <p class="text-justify">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            ตามที่วิทยาลัยเทคนิคฉะเชิงเทราได้ส่ง <?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?> 
                            นักศึกษาชั้น <?php echo $fetch_student["s_year"]; ?> สาขาวิชา  <?php echo $fetch_student["s_major"]; ?>มาปฏิบัตการฝึกอาชีพ ณ <?php echo $fetch_company['c_name']; ?> 
                            ตั้งแต่วันที่ <?php echo $fetch_company['c_start']; ?>
                            ถึง วันที่  <?php echo $fetch_company['c_end']; ?> ซึ่งนักศึกษาดังกล่าวได้ฝึกอาชีพในสถานประกอบการในด้าน  <?php echo $fetch_company['c_position']; ?>
                            มีผลการฝึกอาชีพอยู่ในระดับ........................และได้รับคะแนนการปฏิบัติฝึกอาขีพ ตามแบบประเมินการฝึกอาชีพเป็น............คะแนน 
                        </p>
                        <br/>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            จึงเรียนมาเพื่อโปรดทราบ 
                        </p>
                    </div>

                    <div class="col-5"></div>
                    <div class="col-5">
                        <p class="text-center">ขอแสดงความนับถือ</p>
                        <br>
                        <br>
                        <br>
                        <p class="text-center">(........................................)</p>
                        <p class="text-center">ตำแหน่ง.......................................................</p>
                    </div>
                   
                    <div class="col-2"></div>
                </div>
            </div>
        
            <br/>

            

        </div>
    </div>
    
    <!-- Export Portfolio -->
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center;margin-bottom:40px">แฟ้มสะสมผลงานผู้ฝึกอาชีพ<br/>(PORTFOLIO)</h5>
            <p class="text-center">
                <img src="../student_internship/information_file/profile/<?php echo $fetch_student["s_pic"]; ?>" class="img-fluid" style="width: 3cm;height:4cm">
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

    <!-- Export Activity -->
    <?php while($feth_activity = $result_activity->fetch_assoc()){   ?>
    <div class="page">
        <div class="subpage">
            <?php
                 $count++;
                //  $sql = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
                //  $sql->bind_param("s", $fetch_student["s_id"]);
                //  $sql->execute();
                //  $result = $sql->get_result();
                //  $fetch_company = $result->fetch_assoc();
                 $checker = explode(",", $feth_activity['a_purpose']);
                 $list_arr = [
                     "เสริมสร้างบุคลิกและความรับผิดชอบต่อสังคม",
                     "เสริมสร้างสุขภาพ/กีฬา/นันทนาการ",
                     "พัฒนาคุณธรรมและจริยธรรม",
                     "ส่งเสริมศาสนา/ศิลปะ/วัฒนธรรม",
                     "อนุรักษ์สิ่งแวดล้อม",
                     "พัฒนามาตรฐานวิชาชีพและจรรยาบรรณวิชาชีพ",
                     "ส่งเสริมความคิดสร้างสรรค์",
                     "ส่งเสริมการเรียนรู้แบบบูรณาการ",
                     "พัฒนาความรู้ความสามารถทางวิชาการ",
                     "พัฒนาผู้เรียนให้มีมาตรฐานสู่สากล"
                 ];                      
            ?>
            <p class="text-center fw-bold">แบบรายงานการเข้าร่วมกิจกรรมในสถานประกอบการ</p>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <p><b>กิจกรรมที่</b> <?php echo $count; ?></p>
                        <p><b>1. ลักษณะของกิจกรรม</b></p>
                        <div class="row" style="margin-left: 10px;">

                            <div class="col-6">
                                <?php
                                    for($i=0; $i < count($checker); $i++) {
                                        if ($i % 2 == 0) {
                                ?>
                                <?php if($checker[$i] !== "-"){ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-square" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                        <path
                                            d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }else{ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }?>
                                <?php }?>
                                <?php } ?>

                            </div>
                            <div class="col-6">
                                <?php
                                    for($i=0; $i < count($checker); $i++) {
                                        if ($i % 2 !== 0) {
                                ?>
                                <?php if($checker[$i] !== "-"){ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check2-square" viewBox="0 0 16 16">
                                        <path
                                            d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z" />
                                        <path
                                            d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }else{ ?>
                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-square" viewBox="0 0 16 16">
                                        <path
                                            d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                    </svg> <?php echo $list_arr[$i]; ?></p>
                                <?php }?>
                                <?php }?>
                                <?php } ?>
                            </div>

                        </div>
                        <p><b>2. ชื่อกิจกรรม</b> <?php echo $feth_activity['a_name']; ?></p>
                        <p><b>3. วัน/เวลา/สถานที่</b> <?php echo $feth_activity['a_date']; ?> (<?php echo $feth_activity['a_place']; ?>)</p>
                        <p><b>4. บทบาทและการมีส่วนร่วม</b> <?php echo $feth_activity['a_detail']; ?></p>
                        <p class="text-center">
                            <img src="uploaded/activity_img/<?php echo $feth_activity['a_img']; ?>" class="mt-3 mb-3 img-fluid w-75">
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">ลงชื่อ...................................ผู้เรียนเจ้าของผลงาน</p>
                        <p class="text-center">
                            (<?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?>)</p>
                    </div>
                    <div class="col-6">
                        <p class="text-center">ลงชื่อ...................................ครูฝึก</p>
                        <p class="text-center">(............................................................)</p>
                        <p class="text-center">ผู้รับรอง</p>
                    </div>

                    <div class="col-2">

                    </div>

                    <div class="col-8 mt-5">
                        <p class="text-center">ลงชื่อ...................................ครูประจำวิชา/ครูนิเทศ</p>
                        <p class="text-center">(............................................................)</p>
                    </div>

                    <div class="col-2">

                    </div>
                </div>
            </div>




        </div>
    </div>
    <?php } ?>

    <!-- Export Volunteer -->
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="font-weight: bold;text-align:center">แบบบันทีกความดีและจิตอาสา</p>
            
            <p class="text-center mt-3">
                <b>ชื่อ-สกุล</b> <?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?> 
                <b>รหัสประจำตัว</b> <?php echo $fetch_student["s_student_id"]; ?> 
                <b>ระดับชั้น / กลุ่ม</b> <?php echo $fetch_student["s_year"]; ?><br/>
                <b>สาขาวิชา</b> <?php echo $fetch_student["s_major"]; ?>
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
                    <td><?php echo $fetch_volunteer['v_date']?></td>
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
    
    <!-- Export Semimar -->
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="font-weight: bold;text-align:center">แบบเข้าร่วมกิจกรรมการสัมมนา</p>


            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <p class="text-center mt-3">
                            <b>ชื่อ-สกุล</b> <?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?> 
                            <b>รหัสประจำตัว</b> <?php echo $fetch_student["s_student_id"]; ?> 
                            <b>ระดับชั้น / กลุ่ม</b> <?php echo $fetch_student["s_year"]; ?><br/>
                            <b>สาขาวิชา</b> <?php echo $fetch_student["s_major"]; ?>
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
                                <td><?php echo $fetch_seminar['se_date']; ?></td>
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
                        <p class="text-center">(<?php echo $fetch_student["s_prefix"].$fetch_student["s_name"]." ".$fetch_student["s_surname"];?>)</p>
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
<?php }else{
    header('Location: manage_student_internship.php');  
}
?>

