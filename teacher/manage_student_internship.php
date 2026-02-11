<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_chceker = $conn->prepare("SELECT * FROM company WHERE c_advice2 = ? ");
        $sql_chceker->bind_param("i", $_SESSION['t_id']);
        $sql_chceker->execute();
        $result_checker = $sql_chceker->get_result();
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
                            <h3 class="mb-0">บริหารจัดการนิเทศนักเรียน</h3>
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
                                    <h3 class="card-title">บริหารจัดการนิเทศนักเรียน</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับที่</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ชั้น</th>
                                                <th>บันทึกฝึกอาชีพ</th>
                                                <th>นิเทศนักเรียน</th>
                                                <th>ลบ</th>
                                                
                                           
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            <?php while($fetch_checker = $result_checker->fetch_assoc()){ ?>
                                                <?php
                                                    $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
                                                    $sql_student->bind_param("i", $fetch_checker['s_id']);
                                                    $sql_student->execute();
                                                    $result_student = $sql_student->get_result(); 
                                                    $fetch_student = $result_student->fetch_assoc();
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i++; ?></td>
                                                    <td><?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?></td>
                                                    <td><?php echo $fetch_student['s_year']; ?></td>
                                                    <td>
                                                        <a href="export_book.php?student_id=<?php echo $fetch_student['s_id']; ?>" class="btn btn-info w-100"> <i class="bi bi-book"></i> แบบบันทึก</a>
                                                    </td>

                                                    <td>
                                                        <a href="view_student_internship.php?student_id=<?php echo $fetch_student['s_id']; ?>" class="btn btn-primary w-100">
                                                            <i class="bi bi-pen"></i> นิเทศนักเรียน
                                                        </a>
                                                     
                                                    </td>

                                                    

                                                    <td>
                                                    <form method="post" action="process/delete_student_internship.php">
                                                        <input type="text" name="s_id" class="d-none" value="<?php echo $fetch_student['s_id']; ?>" readonly>
                                                        <button type="button" class="btn btn-danger w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel<?php echo $fetch_student['s_id']; ?>">
                                                           <i class="bi bi-trash"></i> ลบนักเรียน
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalDel<?php echo $fetch_student['s_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel<?php echo $fetch_student['s_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel<?php echo $fetch_student['s_id']; ?>">
                                                                            
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                   
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <h4 class="text-center text-danger">
                                                                                    ยืนยันการลบ <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?> ใช่หรือไม่?
                                                                                </h4>

                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer" style="border-top: none;">
                                                                           <p class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">ปิด</button>
                                                                            <button type="submit"
                                                                                class="btn btn-danger"
                                                                                name="submit"><i class="bi bi-trash"></i> ลบข้อมูล</button>
                                                                            </p>
                                                                        </div>
                                                               
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </form>
                                                    </td>


                                                   
                                                    
                                                   
                                                    
                                                    
                                                    
                                                      

                                            
                                                    
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