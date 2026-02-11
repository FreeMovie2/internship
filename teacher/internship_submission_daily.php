<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $days = ["อาทิตย์","จันทร์", "อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
        $days_eng = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]
        
?>
<?php
    if(isset($_GET['week']) && isset($_GET['day'])){
        $week_ref = filter_input(INPUT_GET , 'week');
        $day_ref = filter_input(INPUT_GET, "day");
        $sql_chceker = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? AND i_week = ? AND i_day = ?");
        $sql_chceker->bind_param("iii", $_SESSION['s_id'], $week_ref, $day_ref);
        $sql_chceker->execute();
        $result_checker = $sql_chceker->get_result();
        $count = $result_checker->num_rows;
        $fetch_checker = $result_checker->fetch_assoc();
        $path  = "uploaded/internship_img/";
       
    
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<?php
    include("component/header.php");
?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <?php
            include("component/navbar.php");
        ?>
        <?php
            include("component/sidebar.php");
        ?>
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">บันทึกการฝึกอาชีพ</h3>
                        </div>

                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content Header-->
            <!--begin::App Content-->
            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <!--begin::Col-->
                        <div class="col-12">

                        </div>
                        <!--end::Col-->


                    </div>
                    <!--end::Row-->
                    <!--begin::Row-->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <?php
                                    if(1-$count != 0){
                                ?>
                                <div class="card-header">
                                    <h3 class="card-title"><b class="text-danger">[ยังไม่ได้บันทึก]</b> บันทึกการฝึกอาชีพ วัน<?php echo $days[$day_ref]; ?>
                                        สัปดาห์ที่ <?php echo $week_ref; ?> </h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <form action="process/add_internship.php" method="post"
                                        enctype="multipart/form-data">
                                        <div class="d-none">
                                            <input type="text" name="i_s_id" class="form-control"
                                                value="<?php echo $_SESSION['s_id'];?>" readonly>
                                            <input type="text" name="s_student_id" class="form-control"
                                                value="<?php echo $_SESSION['s_student_id'];?>" readonly>
                                            <input type="text" name="i_week" class="form-control"
                                                value="<?php echo $week_ref;?>" readonly>
                                            <input type="number" name="i_day" class="form-control"
                                                value="<?php echo $day_ref;?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">วันที่</label>
                                            <input type="text" id="buddhistDate_1" class="form-control buddhist-date-picker" name="i_date"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">เวลาเข้างาน</label>
                                            <input type="time" class="form-control" name="i_start" required />
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">เวลาออกงาน</label>
                                            <input type="time" class="form-control" name="i_end" required />
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">รายละเอียดงาน</label>
                                            <textarea class="form-control" rows="3" name="i_detail" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">อัพโหลดรูปภาพ 1</label>
                                            <input class="form-control" type="file" id="formFile" name="i_img1"
                                                >
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">คำอธิบายรูป 1</label>
                                            <textarea class="form-control" rows="3" name="i_img1_detail" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">อัพโหลดรูปภาพ 2</label>
                                            <input class="form-control" type="file" id="formFile" name="i_img2"
                                                >
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">คำอธิบายรูป 2</label>
                                            <textarea class="form-control" rows="3" name="i_img2_detail" required></textarea>
                                        </div>

                                        <input type="submit" name="submit" value="บันทึก" class="btn btn-info w-100" />
                                    </form>
                                </div>

                                <?php }else{ ?>
                                <div class="card-header">
                                    <h3 class="card-title"><b class="text-success">[บันทึกแล้ว]</b> บันทึกการฝึกอาชีพ วัน<?php echo $days[$day_ref]; ?>
                                        สัปดาห์ที่ <?php echo $week_ref; ?> </h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <form action="process/edit_internship.php" method="post" enctype="multipart/form-data">
                                        <div class="d-none">
                                            <input type="text" name="s_student_id" class="form-control"
                                            value="<?php echo $_SESSION['s_student_id'];?>" readonly>
                                            <input type="text" name="i_s_id" class="form-control"
                                                value="<?php echo $_SESSION['s_id'];?>" readonly>
                                            <input type="text" name="i_week" class="form-control"
                                                value="<?php echo $week_ref;?>" readonly>
                                            <input type="text" name="i_day" class="form-control"
                                                value="<?php echo $day_ref;?>" readonly>
                                            <input type="text" name="i_id" class="form-control"
                                                value="<?php echo $fetch_checker['i_id']; ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">วันที่</label>
                                            <input type="text" id="buddhistDate_1" class="form-control buddhist-date-picker" name="i_date"
                                                value="<?php echo ConvertToThaiDateSplit2($fetch_checker['i_date']); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">เวลาเข้างาน</label>
                                            <input type="time" class="form-control" name="i_start"
                                                value="<?php echo $fetch_checker['i_start']; ?>" />
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">เวลาออกงาน</label>
                                            <input type="time" class="form-control" name="i_end"
                                                value="<?php echo $fetch_checker['i_end']; ?>" />
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">รายละเอียดงาน</label>
                                            <textarea class="form-control"
                                                name="i_detail"><?php echo $fetch_checker['i_detail']; ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">อัพโหลดรูปภาพ 1</label>
                                            <br/>
                                            <?php
                                                if($fetch_checker['i_img1'] == ''){
                                                    echo "<img src='assets/img/no_img.jpg' class='img-fluid w-25'/>";
                                                }else{
                                                    echo "<img src='$path$fetch_checker[i_img1]' class='img-fluid w-25'/>";
                                                }
                                            ?>
                                            
                                            <input class="form-control mt-3" type="file" id="formFile" name="i_img1"
                                            
                                                >
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">คำอธิบายรูป 1</label>
                                            <textarea class="form-control" name="i_img1_detail" required><?php echo $fetch_checker['i_img1_detail']; ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">อัพโหลดรูปภาพ 2</label>
                                            <br/>
                                            <?php
                                                if($fetch_checker['i_img2'] == ''){
                                                    echo "<img src='assets/img/no_img.jpg' class='img-fluid w-25'/>";
                                                }else{
                                                    echo "<img src='$path$fetch_checker[i_img2]' class='img-fluid w-25'/>";
                                                }
                                            ?>
                                            <input class="form-control mt-3" type="file" id="formFile" name="i_img2"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="" class="form-label">คำอธิบายรูป 2</label>
                                            <textarea class="form-control" name="i_img2_detail" required><?php echo $fetch_checker['i_img2_detail']; ?></textarea>
                                        </div>

                                        <input type="submit" name="submit" value="แก้ไข"
                                            class="btn btn-warning w-100" />
                                    </form>
                                </div>

                                <?php } ?>


                            </div> <!-- /.card -->
                            <!-- DIRECT CHAT -->

                        </div>
                    </div> <!-- /.row (main row) -->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->
        <?php
            include("component/footer.php");
        ?>
    </div>
    <!--end::App Wrapper-->
    <?php
        include("component/script.php");
    ?>
</body>
<!--end::Body-->

</html>

<?php } ?>
<?php } ?>