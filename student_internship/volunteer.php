<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_volunteer = $conn->prepare("SELECT * FROM volunteer WHERE s_id = ? ");
        $sql_volunteer->bind_param("i", $_SESSION['s_id']);
        $sql_volunteer->execute();
        $result_volunteer = $sql_volunteer->get_result();
        $count = $result_volunteer->num_rows;
        $count_2 = 0;
 
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
                            <h3 class="mb-0">บันทึกความดีและจิตอาสา</h3>
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
                                    <h3 class="card-title">บันทึกความดีและจิตอาสา</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="bi bi-plus-circle"></i> เพิ่มบันทึก
                                    </button>

                                    <?php if($count != 0){ ?>
                                    <a href="export_volunteer.php" class="btn btn-info mb-3"><i
                                            class="bi bi-printer"></i> พิมพ์เอกสาร</a>
                                    <?php } ?>

                                    <!-- Modal -->
                                    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">เพิ่มกิจกรรม
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="process/add_volunteer.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="hidden" name="s_id"
                                                                    value="<?php echo $_SESSION['s_id'];?>" readonly>



                                                            </div>

                                                            <div class="col-12 mt-3">

                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">วันที่</label>
                                                                    <input type="text" id="buddhistDate"
                                                                        class="form-control" name="v_date" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for=""
                                                                        class="form-label">บันทึกความดี</label>
                                                                    <input type="text" class="form-control"
                                                                        name="v_detail" required />
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


                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">กิจกรรมที่</th>

                                                <th class="text-center">วันที่เข้าร่วม</th>
                                                <th class="text-center">แก้ไข</th>
                                                <th class="text-center">ลบ</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($fetch_volunteer = $result_volunteer->fetch_assoc()){  $count_2++; ?>
                                            <tr>
                                                <td class="text-center"><?php echo $count_2; ?></td>
                                                <td class="text-center"><?php echo ConvertToThaiDateSplit3($fetch_volunteer['v_date']); ?></td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal<?php echo $fetch_volunteer['v_id']; ?>">
                                                        <i class="bi bi-pencil-square"></i> แก้ไข
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade modal-lg"
                                                        id="exampleModal<?php echo $fetch_volunteer['v_id']; ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="exampleModalLabel<?php echo $fetch_volunteer['v_id']; ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                        แก้ไขกิจกรรม
                                                                    </h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form action="process/edit_volunteer.php" method="post"
                                                                    enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input type="hidden" name="s_id"
                                                                                    value="<?php echo $_SESSION['s_id'];?>"
                                                                                    readonly>


                                                                                <input type="hidden" name="v_id"
                                                                                    value="<?php echo $fetch_volunteer['v_id'];?>"
                                                                                    readonly>


                                                                            </div>

                                                                            <div class="col-12 mt-3">

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">วันที่ (ที่เลือกไว้ <?php echo ConvertToThaiDateSplit3($fetch_volunteer['v_date']); ?>)</label>
                                                                                    <input type="text" id="buddhistDate2"
                                                                                        class="form-control"
                                                                                        name="v_date"
                                                                
                                                                                        >
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">บันทึกความดี</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="v_detail"
                                                                                        value="<?php echo $fetch_volunteer['v_detail'];?>"
                                                                                        required />
                                                                                </div>


                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">ปิด</button>
                                                                        <button type="submit" class="btn btn-primary"
                                                                            name="submit">แก้ไขข้อมูล</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <form method="post" action="process/delete_volunteer.php">
                                                        <input type="hidden" value="<?php echo $_SESSION['s_id']; ?>"
                                                            name="s_id" />
                                                        <input type="hidden"
                                                            value="<?php echo $fetch_volunteer['v_id']; ?>"
                                                            name="v_id" />
                                                        <button type="button" class="btn btn-danger w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel<?php echo $fetch_volunteer['v_id']; ?>">
                                                           <i class="bi bi-trash"></i> ลบ
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalDel<?php echo $fetch_volunteer['v_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel<?php echo $fetch_volunteer['v_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel<?php echo $fetch_volunteer['v_id']; ?>">
                                                                            
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                   
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <h4 class="text-center text-danger">ยืนยันการลบใช่หรือไม่</h4>

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