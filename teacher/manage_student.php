<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_student = $conn->prepare("SELECT * FROM students ORDER BY s_id ASC");
        $sql_student->execute();
        $result_student = $sql_student->get_result(); 
       
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<?php
    include("component/header.php");
?>
<style>
    @media (max-width: 767.98px) {
        .manage-student-page .card-body {
            padding: 1rem;
        }

        .manage-student-page .card-title,
        .manage-student-page h4 {
            font-size: 1.05rem;
        }

        .manage-student-page .btn-mobile-full {
            width: 100%;
        }

        .manage-student-page .download-link {
            display: block;
            padding-left: 0.25rem;
            margin-bottom: 0.35rem;
            word-break: break-word;
        }

        .manage-student-page #myTable {
            font-size: 0.92rem;
        }

        .manage-student-page #myTable td,
        .manage-student-page #myTable th {
            white-space: normal !important;
            word-break: break-word;
            vertical-align: top;
        }

        .manage-student-page .dropdown .btn,
        .manage-student-page .btn {
            white-space: normal;
        }
    }
</style>

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
                            <h3 class="mb-0">บริหารจัดการนักเรียนทั้งหมด</h3>
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
                                    <h3 class="card-title">บริหารจัดการนักเรียนทั้งหมด</h3>
                                </div>
                                <div class="card-body manage-student-page">
                                    <?php
                                        AlertBox();
                                    ?>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <h4>นำเข้าฐานข้อมูลนักเรียน (.csv)</h4>
                                            
                                            <a href="csv_file/student_db.csv" style="text-decoration: none;" class="download-link">&nbsp;&nbsp;&nbsp;1. <i class="bi bi-download"></i> ดาวน์โหลดตัวอย่างฐานข้อมูล</a>
                                            <br/>
                                            <a href="csv_file/student_db.pdf" target="_blank" style="text-decoration: none;" class="download-link">&nbsp;&nbsp;&nbsp;2. <i class="bi bi-download"></i> ดาวน์โหลดคำอธิบายคอลัมน์ตัวอย่างฐานข้อมูล</a>

                                            <form action="process/import_student.php" method="post" enctype="multipart/form-data">
                                                <div class="mb-3 mt-3">
                                                    <label for="" class="form-label">อัพโหลดไฟล์ (.csv)</label>
                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        name="file"
                                                        id=""
                                                        placeholder=""
                                                        aria-describedby="fileHelpId"
                                                        accept=".csv"
                                                        required
                                                    />
                                                    
                                                
                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary w-100"><i class="bi bi-file-earmark-spreadsheet"></i> นำเข้าฐานข้อมูลนักเรียน (.csv)</button>
                                                
                                            </form>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <h4>รีเซ็ตข้อมูลนักเรียนทั้งหมด</h4>
                                            <form method="post" action="process/delete_student_all.php">
                                                <input type="text" name="t_id" value="<?php echo $_SESSION['t_id'];?>" class="d-none" readonly>
                                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalDel_verify">
                                                    <i class="bi bi-trash"></i> รีเซ็ตข้อมูลนักเรียนทั้งหมด
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="exampleModalDel_verify"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalDelLabel_verify"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="border-bottom: none;">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalDelLabel_verify">

                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <h5 class="text-danger">
                                                                        ยืนยันการรีเซ็ตข้อมูลนักเรียนทั้งหมดใช่หรือไม่?
                                                                    </h5>

                                                                <div class="mb-3">
                                                                        
                                                                        <input
                                                                            type="password"
                                                                            class="form-control"
                                                                            name="t_password"
                                                                            id=""
                                                                            placeholder="Password"
                                                                            required
                                                                        />
                                                                    </div>
                                                                    

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer" style="border-top: none;">
                                                                <p class="text-center">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">ปิด</button>
                                                                    <button type="submit" class="btn btn-danger"
                                                                        name="submit"><i class="bi bi-trash"></i>
                                                                        ลบข้อมูล</button>
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </form>

                                            <h4 class="mt-3">รีเซ็ตข้อมูลบันทึกฝึกอาชีพ</h4>
                                            <form method="post" action="process/delete_internship_submission.php">
                                                <input type="text" name="t_id" value="<?php echo $_SESSION['t_id'];?>" class="d-none" readonly>
                                                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalDel_verify_dels">
                                                    <i class="bi bi-trash"></i> รีเซ็ตข้อมูลบันทึกฝึกอาชีพ
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade"
                                                    id="exampleModalDel_verify_dels"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalDelLabel_verify_del"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="border-bottom: none;">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalDelLabel_verify_del">

                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <h5 class="text-danger">
                                                                        ยืนยันการรีเซ็ตข้อมูลบันทึกฝึกอาชีพใช่หรือไม่?
                                                                    </h5>

                                                                <div class="mb-3">                
                                                                        <input
                                                                            type="password"
                                                                            class="form-control"
                                                                            name="t_password"
                                                                            id=""
                                                                            placeholder="Password"
                                                                            required
                                                                        />
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer" style="border-top: none;">
                                                                <p class="text-center">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">ปิด</button>
                                                                    <button type="submit" class="btn btn-danger"
                                                                        name="submit"><i class="bi bi-trash"></i>
                                                                        ลบข้อมูล</button>
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>

                                    

                                    <hr>

                                    <form method="post" action="process/add_student.php" enctype="multipart/form-data" class="mb-3">
                                        <button type="button" class="btn btn-primary btn-mobile-full" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalAdd">
                                            <i class="bi bi-person-add"></i> เพิ่มนักเรียน
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade modal-lg"
                                            id="exampleModalAdd"
                                            tabindex="-1"
                                            aria-labelledby="exampleModalAdd"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-fullscreen-sm-down">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="border-bottom: none;">
                                                        <h1 class="modal-title fs-5"
                                                            id="exampleModalAdd">
                                                            เพิ่มนักเรียน
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">เลขประจำตัว</label>
                                                                <input type="text" class="form-control" name="s_student_id"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label class="form-label">คำนำหน้าชื่อ</label>
                                                                <select class="form-control" name="s_prefix" required>
                                                                    <option>นาย</option>
                                                                    <option>นางสาว</option>
                                                                    <option>นาง</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">ชื่อ</label>
                                                                <input type="text" class="form-control" name="s_name"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">นามสกุล</label>
                                                                <input type="text" class="form-control" name="s_surname"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">ระดับชั่น</label>
                                                                <input type="text" class="form-control" name="s_year"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Username</label>
                                                                <input type="text" class="form-control"
                                                                    name="s_username" id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="s_password" id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer" style="border-top: none;">
                                                        <p class="text-center">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                name="submit"><i class="bi bi-person-add"></i>
                                                                เพิ่มนักเรียน</button>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>






                                    <table id="myTable" class="table table-striped table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับที่</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ชั้น</th>
                                                <th>บันทึกฝึกอาชีพ</th>
                                                <th>จัดการนักเรียน</th>
                                                <th>ลบ</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            <?php while($fetch_student = $result_student->fetch_assoc()){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td>
                                                    <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?>
                                                    <br/>
                                                    เลขประจำตัว <?php echo $fetch_student['s_student_id']; ?>
                                                    <?php
                                                        $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
                                                        $sql_company->bind_param("s", $fetch_student['s_id']);
                                                        $sql_company->execute();
                                                        $result_company = $sql_company->get_result();
                                                        $fetch_company = $result_company->fetch_assoc();

                                                        $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
                                                        $sql_parent->bind_param("s", $fetch_student['s_id']);
                                                        $sql_parent->execute();
                                                        $result_parent = $sql_parent->get_result();
                                                        $fetch_parent = $result_parent->fetch_assoc();
                                                    ?>

                                                    <?php if($fetch_student['s_update_information'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลส่วนตัว</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลส่วนตัวแล้ว</p>
                                                    <?php }?>

                                                    <?php if($fetch_parent['p_update_status'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลผู้ปกครอง/บุคคลใกล้ชิด</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลผู้ปกครอง/บุคคลใกล้ชิดแล้ว</p>
                                                    <?php }?>

                                                    <?php if($fetch_company['c_update_status'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลสถานประกอบการ</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลสถานประกอบการแล้ว</p>
                                                    <?php }?>
                                                </td>
                                                <td><?php echo $fetch_student['s_year']; ?></td>
                                                <td>
                                                    <a href="export_book.php?student_id=<?php echo $fetch_student['s_id']; ?>"
                                                        class="btn btn-info w-100"> <i class="bi bi-book"></i>
                                                        แบบบันทึก</a>
                                                </td>

                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            เมนูการใช้งาน
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="edit_information.php?student_id=<?php echo $fetch_student['s_id']; ?>">แก้ไขข้อมูลส่วนตัว</a></li>
                                                            <li><a class="dropdown-item" href="edit_parent.php?student_id=<?php echo $fetch_student['s_id']; ?>">แก้ไขข้อมูลผู้ปกครอง/บุคคลใกล้ชิด</a></li>
                                                            <li><a class="dropdown-item" href="edit_company.php?student_id=<?php echo $fetch_student['s_id']; ?>">แก้ไขข้อมูลสถานประกอบการ</a></li>
                                                        </ul>
                                                    </div>

                                                </td>



                                                <td>
                                                    <form method="post" action="process/delete_student_by_person.php">
                                                        <input type="text" name="s_id" class="d-none"
                                                            value="<?php echo $fetch_student['s_id']; ?>" readonly>
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
                                                                    <div class="modal-header"
                                                                        style="border-bottom: none;">
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
                                                                                ยืนยันการลบ
                                                                                <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?>
                                                                                ใช่หรือไม่?
                                                                            </h4>

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer" style="border-top: none;">
                                                                        <p class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">ปิด</button>
                                                                            <button type="submit" class="btn btn-danger"
                                                                                name="submit"><i
                                                                                    class="bi bi-trash"></i>
                                                                                ลบข้อมูล</button>
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
    <script>
        (function () {
            if (typeof $ === "undefined" || typeof $.fn.DataTable === "undefined") {
                return;
            }

            if ($.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }

            $('#myTable').DataTable({
                autoWidth: false,
                responsive: {
                    details: {
                        type: 'inline',
                        target: 'tr'
                    }
                },
                columnDefs: [
                    { responsivePriority: 1, targets: 1 },
                    { responsivePriority: 2, targets: 4 },
                    { responsivePriority: 3, targets: 0 },
                    { responsivePriority: 100, targets: [2, 3, 5] }
                ]
            });
        })();
    </script>
</body>
<!--end::Body-->

</html>

<?php } ?>
