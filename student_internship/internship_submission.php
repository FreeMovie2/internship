<?php
    session_start();
    include("connect/connect.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $days = ["อาทิตย์","จันทร์", "อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
        $days_eng = ["Sunday","Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday"];
        
?>
<?php
    if(isset($_GET['week'])){
        $week_count = filter_input(INPUT_GET , 'week');
    
?>
<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<?php
    include("component/header.php");
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <?php
            include("component/navbar.php");
        ?>
        <?php
            include("component/sidebar.php");
        ?>
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">บันทึกการฝึกอาชีพ สัปดาห์ที่ <?php echo $week_count; ?></h3>
                        </div>
                      
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
             
                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">บันทึกการฝึกอาชีพ สัปดาห์ที่ <?php echo $week_count; ?></h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">วัน</th>
                                    
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">บันทึก/แก้ไข</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i = 1; $i <=5 ; $i++){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $days[$i]; ?></td>
                                                   
                                                   
                                                    <?php
                                                        $sql_chceker = $conn->prepare("SELECT COUNT(*) FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
                                                        $sql_chceker->bind_param("iii", $_SESSION['s_id'], $week_count ,$i);
                                                        $sql_chceker->execute();
                                                        $result_checker = $sql_chceker->get_result();
                                                        $fetch_checker = $result_checker->fetch_assoc();

                                                        if(1-$fetch_checker['COUNT(*)'] != 0){
                                                    ?>
                                                        <td class="text-danger text-center">
                                                            <i class="bi bi-exclamation-square"></i> ยังไม่ได้บันทึก 
                                                        </td>

                                                    <?php }else{ ?>
                                                        <td class="text-success text-center"><i class="bi bi-check"></i> บันทึกแล้ว</td>

                                                    <?php } ?>
                                                    
                                                    
                                                    <td><a href='internship_submission_daily.php?week=<?php echo $week_count; ?>&day=<?php echo $i; ?>' class="btn btn-warning w-100"><i class="bi bi-pencil-square"></i> บันทึก</a></td>
                                                </tr>

                                            <?php } ?>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card --> <!-- DIRECT CHAT -->
                            
                        </div> 
                    </div> <!-- /.row (main row) -->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> 
        <?php
            include("component/footer.php");
        ?>
    </div> <!--end::App Wrapper--> 
    <?php
        include("component/script.php");
    ?>
</body><!--end::Body-->

</html>

<?php } ?>
<?php } ?>