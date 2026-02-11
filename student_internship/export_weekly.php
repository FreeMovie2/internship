<?php
    session_start();
    include 'connect/connect.php';
    include 'component/function.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }
?>

<?php
    if(isset($_GET['week'])){
        $week_ref = $_GET['week'];
        $sql_weekly = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? ORDER BY i_day ASC");
        $sql_weekly->bind_param("ii", $_SESSION["s_id"], $week_ref);
        $sql_weekly->execute();
        $result_weekly = $sql_weekly->get_result();

        $sql_weekly_2 = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? ORDER BY i_day ASC");
        $sql_weekly_2->bind_param("ii", $_SESSION["s_id"], $week_ref);
        $sql_weekly_2->execute();
        $result_weekly_2 = $sql_weekly_2->get_result();

        $cont_weekly = $result_weekly->num_rows;
        $days = ["อาทิตย์","จันทร์", "อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
        if($cont_weekly == 0){
            header('Location: index.php');
            exit();
        }else{
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header_print.php");
?>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์แบบประเมิน" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="font-weight: bold;text-align:center">แบบบันทึกการฝึกอาชีพประจำวัน</p>
            <p class="text-center">
                สัปดาห์ที่ <?php echo $week_ref; ?>
                <?php
                    $sql_start = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
                    $s = 1;
                    $sql_start->bind_param("iii",$_SESSION['s_id'], $week_ref, $s);
                    $sql_start->execute();
                    $result_start = $sql_start->get_result();
                    $fetch_start = $result_start->fetch_assoc();
                    echo ConvertToThaiDate($fetch_start['i_date']);
                ?>
                ถึง
                <?php
                    $sql_end = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
                    $s = 5;
                    $sql_end->bind_param("iii",$_SESSION['s_id'], $week_ref, $s);
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
                                            ลงชื่อ <?php echo $_SESSION['s_name']; ?> ผู้ฝึกอาชีพ
                                        
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
                            (...........................................)
                        </p>
                    </div>

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

                            <p class="text-center"><img src="uploaded/internship_img/<?php echo $fetch_weekly2['i_img1']; ?>" class="img-fluid w-75"/></p>
                            <p class="text-justify mt-2"><b>รายละเอียด : </b><?php echo $fetch_weekly2['i_img1_detail']; ?></p>

                            <p class="text-center"><img src="uploaded/internship_img/<?php echo $fetch_weekly2['i_img2']; ?>" class="img-fluid w-75 mt-5"/></p>
                            <p class="text-justify mt-2"><b>รายละเอียด : </b><?php echo $fetch_weekly2['i_img2_detail']; ?></p>
                            
                        </div>


                    </div>
                </div>
            </div>
                

            
                
        </div>
    <?php } ?>
    


</body>

</html>
<?php } ?>