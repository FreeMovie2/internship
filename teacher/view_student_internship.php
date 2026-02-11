<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        if(isset($_GET['student_id']) && $_SERVER["REQUEST_METHOD"] == "GET"){
        
            $s_id = $_GET['student_id'];
            $sql_chceker_starter = $conn->prepare("SELECT * FROM company WHERE s_id = ? ");
            $sql_chceker_starter->bind_param("i", $s_id);
            $sql_chceker_starter->execute();
            $result_student_starter = $sql_chceker_starter->get_result();
            $fetch_checker_starter = $result_student_starter->fetch_assoc();

            if($fetch_checker_starter['c_advice2'] == $_SESSION['t_id']){
                $sql_chceker_count = $conn->prepare("SELECT * FROM internship WHERE i_s_id = ? ");
                $sql_chceker_count->bind_param("i", $s_id);
                $sql_chceker_count->execute();
                $result_checker_count = $sql_chceker_count->get_result();
                $count = $result_checker_count->num_rows;
                $all = 18*5;

                $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
                $sql_student->bind_param("i", $s_id);
                $sql_student->execute();
                $result_student = $sql_student->get_result(); 
                $fetch_student = $result_student->fetch_assoc();


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
                        <div class="col-12">
                            <h3 class="mb-0">บันทึกการฝึกอาชีพของ
                                <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?>
                            </h3>
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
                        <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">บันทึกการฝึกอาชีพของ
                                        <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <a href="export_book.php?student_id=<?php echo $s_id; ?>"
                                        class="btn btn-info mb-3"><i class="bi bi-printer"></i> พิมพ์แบบบันทึก</a>
                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">สัปดาห์ที่</th>
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">บันทึกครูนิเทศ</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for($i = 1; $i <= 18; $i++){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>




                                                <?php
                                                        $sql_chceker = $conn->prepare("SELECT * FROM teacher_comment WHERE t_id = ? AND s_id = ? AND tc_week = ?");
                                                        $sql_chceker->bind_param("sss", $_SESSION['t_id'], $s_id, $i);
                                                        $sql_chceker->execute();
                                                        $result_checker = $sql_chceker->get_result();
                                                        $num_check = $result_checker->num_rows;
                                                        $fetch_checker = $result_checker->fetch_assoc();

                                                        if($num_check == 0){
                                                    ?>

                                                <td class="text-danger text-center">
                                                    <i class="bi bi-exclamation-square"></i> ยังไม่ได้บันทึกการนิเทศ
                                                </td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal<?php echo $i; ?>">
                                                        <i class="bi bi-pencil-square"></i> บันทึกข้อมูล
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade modal-lg"
                                                        id="exampleModal<?php echo $i; ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel<?php echo $i; ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel<?php echo $i; ?>">
                                                                        บันทึกการนิเทศประจำสัปดาห์ที่ <?php echo $i; ?>
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form action="process/add_teacher_comment.php" method="post"
                                                                    enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input type="hidden" name="t_id"
                                                                                    value="<?php echo $_SESSION['t_id'];?>"
                                                                                    readonly>


                                                                                <input type="hidden" name="s_id"
                                                                                    value="<?php echo $s_id;?>"
                                                                                    readonly>

                                                                                <input type="hidden" name="tc_week"
                                                                                    value="<?php echo $i;?>"
                                                                                    readonly>
                                                                            </div>

                                                                            <div class="col-12">

                                                                                <div class="mb-3">
                                                                                    <label for="" class="form-label">บันทึกการนิเทศ</label>
                                                                                    <textarea class="form-control" name="tc_detail" id="" rows="3"></textarea>
                                                                                </div>

                                                                


                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">ปิด</button>
                                                                        <button type="submit" class="btn btn-primary"
                                                                            name="submit">บันทึกข้อมูล</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <?php }else{ ?>
                                                <td class="text-success text-center">
                                                    <i class="bi bi-check"></i> บันทึกการนิเทศแล้ว
                                                </td>

                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal<?php echo $i; ?>">
                                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade modal-lg"
                                                        id="exampleModal<?php echo $i; ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel<?php echo $i; ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel<?php echo $i; ?>">
                                                                        แก้ไขบันทึกการนิเทศประจำสัปดาห์ที่ <?php echo $i; ?>
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form action="process/edit_teacher_commment.php" method="post"
                                                                    enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input type="hidden" name="tc_id"
                                                                                    value="<?php echo $fetch_checker['tc_id'];?>"
                                                                                    readonly>

                                                                                <input type="hidden" name="s_id"
                                                                                    value="<?php echo $s_id;?>"
                                                                                    readonly>


                                                                            
                                                                            </div>

                                                                            <div class="col-12">
                                                                                <div class="mb-3">
                                                                                    <label for="" class="form-label">บันทึกการนิเทศ</label>
                                                                                    <textarea class="form-control" name="tc_detail" rows="3"><?php echo $fetch_checker['tc_detail'] ;?></textarea>
                                                                                </div>
                                                                            
                                                                               

                                        

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">ปิด</button>
                                                                        <button type="submit" class="btn btn-warning"
                                                                            name="submit">แก้ไขข้อมูล</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <?php } ?>

                                      
                                            </tr>

                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>
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
<?php }else{ ?>
<?php  header("Location:manage_student_internship.php"); ?>
<?php } ?>

<?php }else{ ?>
<?php  header("Location:manage_student_internship.php"); ?>
<?php } ?>

<?php } ?>