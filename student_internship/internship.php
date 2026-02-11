<?php
    session_start();
    include("connect/connect.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_chceker_count = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? ");
        $sql_chceker_count->bind_param("i", $_SESSION['s_id']);
        $sql_chceker_count->execute();
        $result_checker_count = $sql_chceker_count->get_result();
        $count = $result_checker_count->num_rows;
        $all = 18*5;
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
                            <h3 class="mb-0">บันทึกการฝึกอาชีพ</h3>
                        </div>
                      
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                        <div class="col-lg-6 col-md-6 col-12"> <!--begin::Small Box Widget 1-->
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3 class="mb-0"><?php echo $count;?><sup class="fs-5"> วัน</sup></h3>
                                    <p>บันทึกแล้ว</p>
                                </div> 
                            </div> <!--end::Small Box Widget 1-->
                        </div> <!--end::Col-->
                        <div class="col-lg-6 col-md-6 col-12"> <!--begin::Small Box Widget 2-->
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3 class="mb-0"><?php echo $all-$count; ?><sup class="fs-5"> วัน</sup></h3>
                                    <p>ยังไม่ได้บันทึก</p>
                                </div> 
                                
                            </div> <!--end::Small Box Widget 2-->
                        </div> <!--end::Col-->

                    </div> <!--end::Row--> <!--begin::Row-->
                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">บันทึกการฝึกอาชีพ</h3>
                                </div>
                                <div class="card-body">
                                <a href="export_all.php" class="btn btn-info mb-3"><i class="bi bi-printer"></i> พิมพ์เอกสารทุกสัปดาห์</a>
                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">สัปดาห์ที่</th>
                                                <th>รายละเอียด</th>
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">บันทึก/แก้ไข</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i = 1; $i <= 18; $i++){ ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    
                                                   
                                                    
                                                    
                                                    <?php
                                                        $sql_chceker = $conn->prepare("SELECT COUNT(*) FROM internship WHERE i_s_id = ? AND i_week = ?");
                                                        $sql_chceker->bind_param("ss", $_SESSION['s_id'], $i);
                                                        $sql_chceker->execute();
                                                        $result_checker = $sql_chceker->get_result();
                                                        $fetch_checker = $result_checker->fetch_assoc();

                                                        if(5-$fetch_checker['COUNT(*)'] != 0){
                                                    ?>
                                                        <td>เหลืออีก <?php echo 5-$fetch_checker['COUNT(*)']; ?> วันถึงจะบันทึกครบ</td>
                                                        <td class="text-danger text-center">
                                                        <i class="bi bi-exclamation-square"></i> ยังบันทึกไม่ครบ 
                                                        </td>

                                                    <?php }else{ ?>
                                                        <td class="text-success"><i class="bi bi-check"></i> บันทึกครบแล้ว</td>
                                                        <td><a href="export_weekly.php?week=<?php echo $i; ?>" class="btn btn-success w-100"><i class="bi bi-printer"></i> พิมพ์เอกสาร</a></td>

                                                    <?php } ?>
                                                    <td><a href='internship_submission.php?week=<?php echo $i; ?>' class="btn btn-warning w-100"><i class="bi bi-pencil-square"></i> บันทึก</a></td>
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