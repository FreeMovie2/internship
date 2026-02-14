<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_teacher = $conn->prepare("SELECT * FROM teachers ORDER BY t_id ASC");
        $sql_teacher->execute();
        $result_teacher = $sql_teacher->get_result(); 
       
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<?php
    include("component/header.php");
?>
<style>
    @media (max-width: 767.98px) {
        .manage-teacher-page .card-body {
            padding: 1rem;
        }

        .manage-teacher-page .card-title,
        .manage-teacher-page h4 {
            font-size: 1.05rem;
        }

        .manage-teacher-page .btn-mobile-full {
            width: 100%;
        }

        .manage-teacher-page .download-link {
            display: block;
            padding-left: 0.25rem;
            margin-bottom: 0.35rem;
            word-break: break-word;
        }

        .manage-teacher-page #myTable {
            font-size: 0.92rem;
        }

        .manage-teacher-page #myTable td,
        .manage-teacher-page #myTable th {
            white-space: normal !important;
            word-break: break-word;
            vertical-align: top;
        }

        .manage-teacher-page .btn {
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
                            <h3 class="mb-0">บริหารจัดการครูทั้งหมด</h3>
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
                                    <h3 class="card-title">บริหารจัดการครูทั้งหมด</h3>
                                </div>
                                <div class="card-body manage-teacher-page">
                                    <?php
                                        AlertBox();
                                    ?>

                                    <div class="row g-3">
                                        <div class="col-12 col-md-6">
                                            <h4>นำเข้าฐานข้อมูลครู (.csv)</h4>

                                            <a href="csv_file/teacher_db.csv"
                                                style="text-decoration: none;" class="download-link">&nbsp;&nbsp;&nbsp;1. <i
                                                    class="bi bi-download"></i> ดาวน์โหลดตัวอย่างฐานข้อมูล</a>
                                            <br />
                                            <a href="csv_file/teacher_db.pdf" target="_blank"
                                                style="text-decoration: none;" class="download-link">&nbsp;&nbsp;&nbsp;2. <i
                                                    class="bi bi-download"></i>
                                                ดาวน์โหลดคำอธิบายคอลัมน์ตัวอย่างฐานข้อมูล</a>

                                            <form action="process/import_teacher.php" method="post"
                                                enctype="multipart/form-data">
                                                <div class="mb-3 mt-3">
                                                    <label for="" class="form-label">อัพโหลดไฟล์ (.csv)</label>
                                                    <input type="file" class="form-control" name="file" id=""
                                                        placeholder="" aria-describedby="fileHelpId" accept=".csv"
                                                        required />


                                                </div>
                                                <button type="submit" name="submit" class="btn btn-primary w-100"><i
                                                        class="bi bi-file-earmark-spreadsheet"></i> นำเข้าฐานข้อมูลครู
                                                    (.csv)</button>

                                            </form>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <h4>รีเซ็ตข้อมูลครูทั้งหมด</h4>
                                            <form method="post" action="process/delete_teacher_all.php">
                                                <input type="text" name="t_id" value="<?php echo $_SESSION['t_id'];?>"
                                                    class="d-none" readonly>
                                                <button type="button" class="btn btn-danger w-100"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalDel_verify">
                                                    <i class="bi bi-trash"></i> รีเซ็ตข้อมูลครูทั้งหมด
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModalDel_verify" tabindex="-1"
                                                    aria-labelledby="exampleModalDelLabel_verify" aria-hidden="true">
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
                                                                        ยืนยันการรีเซ็ตข้อมูลครูทั้งหมดใช่หรือไม่?
                                                                    </h5>

                                                                    <div class="mb-3">

                                                                        <input type="password" class="form-control"
                                                                            name="t_password" id=""
                                                                            placeholder="Password" required />
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

                                    <form method="post" action="process/add_teacher.php" enctype="multipart/form-data" class="mb-3">
                                        <button type="button" class="btn btn-primary btn-mobile-full" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalAdd">
                                            <i class="bi bi-person-add"></i> เพิ่มครู
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
                                                            เพิ่มครู
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="form-group mb-3">
                                                                <label class="form-label">คำนำหน้าชื่อ</label>
                                                                <select class="form-control" name="t_prefix" required>
                                                                    <option>นาย</option>
                                                                    <option>นางสาว</option>
                                                                    <option>นาง</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">ชื่อ</label>
                                                                <input type="text" class="form-control" name="t_name"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">นามสกุล</label>
                                                                <input type="text" class="form-control" name="t_surname"
                                                                    id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Username</label>
                                                                <input type="text" class="form-control"
                                                                    name="t_username" id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Password</label>
                                                                <input type="password" class="form-control"
                                                                    name="t_password" id="" placeholder=""
                                                                    
                                                                    required />
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label class="form-label">สิทธิ์การใช้งาน</label>
                                                                <select class="form-control" name="t_status" required>
                                                                    <option value="U">ครูผู้ใช้งานทั่วไป</option>
                                                                    <option value="A">ครูผู้ดูแลระบบ</option>
                                                                    <option value="P">ผู้อำนวยการ</option>
                                                                </select>
                                                            </div>


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer" style="border-top: none;">
                                                        <p class="text-center">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">ปิด</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                name="submit"><i class="bi bi-person-add"></i>
                                                                เพิ่มครู</button>
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
                                                <th>สถานะ</th>

                                                <th>แก้ไข</th>

                                                <th>ลบ</th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            <?php while($fetch_teacher = $result_teacher->fetch_assoc()){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td>
                                                    <?php echo $fetch_teacher['t_prefix'].$fetch_teacher['t_name']." ".$fetch_teacher['t_surname']; ?>
                                                </td>

                                                <td>
                                                    <?php 
                                                        if($fetch_teacher['t_status'] == "U"){
                                                            echo "ครูผู้ใช้งานทั่วไป";
                                                        }else if($fetch_teacher['t_status'] == "A") {
                                                            echo "ครูผู้ดูแลระบบ";
                                                        } else {
                                                            echo "ผู้อำนวยการ";
                                                        }
                                                    ?>

                                                </td>
                                                <td>
                                                    <form method="post" action="process/edit_teacher.php"
                                                        enctype="multipart/form-data">

                                                        <input type="text" name="t_id"
                                                            value="<?php echo $fetch_teacher['t_id'];?>" class="d-none"
                                                            readonly>
                                                        <button type="button" class="btn btn-warning w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel_verify<?php echo $fetch_teacher['t_id']; ?>">
                                                            <i class="bi bi-pencil-square"></i> แก้ไขครู
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade modal-lg"
                                                            id="exampleModalDel_verify<?php echo $fetch_teacher['t_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel_verify<?php echo $fetch_teacher['t_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-fullscreen-sm-down">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel_verify<?php echo $fetch_teacher['t_id']; ?>">
                                                                            แก้ไขครู
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="form-label">คำนำหน้าชื่อ</label>
                                                                                <select class="form-control"
                                                                                    name="t_prefix" required>
                                                                                    <option
                                                                                        value="<?php echo $fetch_teacher['t_prefix']; ?>">
                                                                                        <?php echo $fetch_teacher['t_prefix']; ?>
                                                                                    </option>
                                                                                    <option>นาย</option>
                                                                                    <option>นางสาว</option>
                                                                                    <option>นาง</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="form-label">ชื่อ</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="t_name" id="" placeholder=""
                                                                                    value="<?php echo $fetch_teacher['t_name']; ?>"
                                                                                    required />
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="form-label">นามสกุล</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="t_surname" id=""
                                                                                    placeholder=""
                                                                                    value="<?php echo $fetch_teacher['t_surname']; ?>"
                                                                                    required />
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="form-label">Username</label>
                                                                                <input type="text" class="form-control"
                                                                                    name="t_username" id=""
                                                                                    placeholder=""
                                                                                    value="<?php echo $fetch_teacher['t_username']; ?>"
                                                                                    required />
                                                                            </div>

                                                                            <div class="mb-3">
                                                                                <label for=""
                                                                                    class="form-label">Password</label>
                                                                                <input type="password"
                                                                                    class="form-control"
                                                                                    name="t_password" id=""
                                                                                    placeholder=""
                                                                                    value="<?php echo $fetch_teacher['t_password']; ?>"
                                                                                    required />
                                                                            </div>

                                                                            <div class="form-group mb-3">
                                                                                <label
                                                                                    class="form-label">สิทธิ์การใช้งาน</label>
                                                                                <select class="form-control" name="t_status" required>

                                                                                    <option value="U" <?php echo ($fetch_teacher['t_status'] == 'U') ? 'selected' : ''; ?>>
                                                                                        ครูผู้ใช้งานทั่วไป
                                                                                    </option>

                                                                                    <option value="A" <?php echo ($fetch_teacher['t_status'] == 'A') ? 'selected' : ''; ?>>
                                                                                        ครูผู้ดูแลระบบ
                                                                                    </option>
                                                                                    
                                                                                    <option value="P" <?php echo ($fetch_teacher['t_status'] == 'P') ? 'selected' : ''; ?>>
                                                                                        ผู้อำนวยการ
                                                                                    </option>

                                                                                </select>
                                                                            </div>


                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer" style="border-top: none;">
                                                                        <p class="text-center">
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">ปิด</button>
                                                                            <button type="submit"
                                                                                class="btn btn-warning" name="submit"><i
                                                                                    class="bi bi-pencil-square"></i>
                                                                                แก้ไขครู</button>
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>





                                                <td>
                                                    <form method="post" action="process/delete_teacher_by_person.php">
                                                        <input type="text" name="t_id" class="d-none"
                                                            value="<?php echo $fetch_teacher['t_id']; ?>" readonly>
                                                        <button type="button" class="btn btn-danger w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel<?php echo $fetch_teacher['t_id']; ?>">
                                                            <i class="bi bi-trash"></i> ลบครู
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalDel<?php echo $fetch_teacher['t_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel<?php echo $fetch_teacher['t_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen-sm-down">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel<?php echo $fetch_teacher['t_id']; ?>">

                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <h4 class="text-center text-danger">
                                                                                ยืนยันการลบ
                                                                                <?php echo $fetch_teacher['t_prefix'].$fetch_teacher['t_name']." ".$fetch_teacher['t_surname']; ?>
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
                    { responsivePriority: 2, targets: 3 },
                    { responsivePriority: 3, targets: 0 },
                    { responsivePriority: 100, targets: [2, 4] }
                ]
            });
        })();
    </script>
</body>
<!--end::Body-->

</html>

<?php } ?>
