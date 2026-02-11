<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_activity = $conn->prepare("SELECT * FROM activity WHERE s_id = ? ");
        $sql_activity->bind_param("i", $_SESSION['s_id']);
        $sql_activity->execute();
        $result_activity = $sql_activity->get_result();
        $count = $result_activity->num_rows;
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
                            <h3 class="mb-0">บันทึกการเข้าร่วมกิจกรรม</h3>
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
                                    <h3 class="card-title">บันทึกการเข้าร่วมกิจกรรมในสถานประกอบการ</h3>
                                </div>
                                <div class="card-body">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="bi bi-plus-circle"></i> เพิ่มกิจกรรม
                                    </button>

                                    

                                    <?php if($count != 0){ ?>
                                        <a href="export_activity.php" class="btn btn-info mb-3"><i class="bi bi-printer"></i> พิมพ์เอกสาร</a>
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
                                                <form action="process/add_activity.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <input type="hidden" name="s_id"
                                                                    value="<?php echo $_SESSION['s_id'];?>" readonly>
                                                                <input type="hidden" name="s_student_id"
                                                                    value="<?php echo $_SESSION['s_student_id'];?>"
                                                                    readonly>
                                                                <input type="hidden" name="a_count"
                                                                    value="dd<?php echo $count_0;?>as" readonly>

                                                                <label for="" class="form-label">ลักษณะกิจกรรม</label>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="responsibility" value="1" name="a_purpose1">
                                                                    <label class="form-check-label"
                                                                        for="responsibility">
                                                                        เสริมสร้างบุคลิกและความรับผิดชอบต่อสังคม
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="morality" value="3" name="a_purpose3">
                                                                    <label class="form-check-label" for="morality">
                                                                        พัฒนาคุณธรรมและจริยธรรม
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="environment" value="5" name="a_purpose5">
                                                                    <label class="form-check-label" for="environment">
                                                                        อนุรักษ์สิ่งแวดล้อม
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="creativity" value="7" name="a_purpose7">
                                                                    <label class="form-check-label" for="creativity">
                                                                        ส่งเสริมความคิดสร้างสรรค์
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="academic" value="9" name="a_purpose9">
                                                                    <label class="form-check-label" for="academic">
                                                                        พัฒนาความรู้ความสามารถทางวิชาการ
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="health" value="2" name="a_purpose2">
                                                                    <label class="form-check-label" for="health">
                                                                        เสริมสร้างสุขภาพ/กีฬา/นันทนาการ
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="culture" value="4" name="a_purpose4">
                                                                    <label class="form-check-label" for="culture">
                                                                        ส่งเสริมศาสนา/ศิลปะ/วัฒนธรรม
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="ethics" value="6" name="a_purpose6">
                                                                    <label class="form-check-label" for="ethics">
                                                                        พัฒนามาตรฐานวิชาชีพและจรรยาบรรณวิชาชีพ
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="integrated-learning" value="8"
                                                                        name="a_purpose8">
                                                                    <label class="form-check-label"
                                                                        for="integrated-learning">
                                                                        ส่งเสริมการเรียนรู้แบบบูรณาการ
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="global-standard" value="10"
                                                                        name="a_purpose10">
                                                                    <label class="form-check-label"
                                                                        for="global-standard">
                                                                        พัฒนาผู้เรียนให้มีมาตรฐานสู่สากล
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 mt-3">


                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">ชื่อกิจกรรม</label>
                                                                    <input type="text" class="form-control"
                                                                        name="a_name" required />
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">วันที่</label>
                                                                    <input type="text" id="buddhistDate"
                                                                        class="form-control" name="a_date" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">สถานที่</label>
                                                                    <input type="text" class="form-control"
                                                                        name="a_place" required />
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for=""
                                                                        class="form-label">บทบาทและการมีส่วนร่วม</label>
                                                                    <textarea class="form-control" rows="3"
                                                                        name="a_detail" required></textarea>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="" class="form-label">อัพโหลดรูปภาพ
                                                                    </label>
                                                                    <input class="form-control" type="file"
                                                                        id="formFile" name="a_img" required>
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

                                    <?php AlertBox(); ?>


                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">กิจกรรมที่</th>
                                                <th>ชื่อกิจกรรม</th>
                                                <th class="text-center">วันที่เข้าร่วม</th>
                                                <th class="text-center">แก้ไข</th>
                                                <th class="text-center">ลบ</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($feth_activity = $result_activity->fetch_assoc()){  $count_2++; ?>
                                            <tr>
                                                <td class="text-center"><?php echo $count_2; ?></td>
                                                <td class="text-center"><?php echo $feth_activity['a_name']; ?></td>
                                                <td class="text-center">
    <?php echo ConvertToThaiDateSplit3($feth_activity['a_date']); ?>
</td>

                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning w-100"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $feth_activity['a_id']; ?>">
                                                        <i class="bi bi-pencil-square"></i>แก้ไข
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade modal-lg" id="exampleModal<?php echo $feth_activity['a_id']; ?>" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel<?php echo $feth_activity['a_id']; ?>" aria-hidden="true">
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
                                                                <form action="process/edit_activity.php" method="post"
                                                                    enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <input type="hidden" name="s_id"
                                                                                    value="<?php echo $_SESSION['s_id'];?>"
                                                                                    readonly>
                                                                                <input type="hidden" name="s_student_id"
                                                                                    value="<?php echo $_SESSION['s_student_id'];?>"
                                                                                    readonly>
                                                                                <input type="hidden" name="a_count"
                                                                                    value="<?php echo $count+1;?>"
                                                                                    readonly>

                                                                                    <input type="hidden" name="a_id"
                                                                                    value="<?php echo $feth_activity['a_id'];?>"
                                                                                    readonly>

                                                                                <label for=""
                                                                                    class="form-label">ลักษณะกิจกรรม</label>
                                                                            </div>
                                                                            <?php
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
                                                                            <div class="col-6">
                                                                                <?php
                                                                                    for($i=0; $i < count($checker); $i++) {
                                                                                        if ($i % 2 == 0) {
                                                                                ?>
                                                                                        <?php if($checker[$i] !== "-"){ ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value="<?php echo $i+1; ?>"
                                                                                                    id="<?php echo $list_arr[$i]; ?>"
                                                                                                    name="a_purpose<?php echo $i+1; ?>" checked>
                                                                                                <label class="form-check-label"
                                                                                                    >
                                                                                                    <?php echo $list_arr[$i]; ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        <?php }else{ ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value="<?php echo $i+1; ?>"
                                                                                                    name="a_purpose<?php echo $i+1; ?>">
                                                                                                <label class="form-check-label"
                                                                                                    >
                                                                                                    <?php echo $list_arr[$i]; ?>
                                                                                                </label>
                                                                                            </div>
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
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value="<?php echo $i+1; ?>"
                                                                                                    id="<?php echo $list_arr[$i]; ?>"
                                                                                                    name="a_purpose<?php echo $i+1; ?>" checked>
                                                                                                <label class="form-check-label"
                                                                                                    >
                                                                                                    <?php echo $list_arr[$i]; ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        <?php }else{ ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input"
                                                                                                    type="checkbox"
                                                                                                    value="<?php echo $i+1; ?>"
                                                                                                    name="a_purpose<?php echo $i+1; ?>">
                                                                                                <label class="form-check-label"
                                                                                                    >
                                                                                                    <?php echo $list_arr[$i]; ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        <?php }?>
                                                                                    <?php }?>
                                                                                <?php } ?>
                                                                            </div>
                                                                            <div class="col-12 mt-3">


                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">ชื่อกิจกรรม</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="a_name" value="<?php echo $feth_activity['a_name']; ?>" required />
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">วันที่</label>
                                                                                    <input type="text" id="buddhistDate_<?php echo $feth_activity['a_id']; ?>"
                                                                                       class="form-control buddhist-date-picker"
                                                                                        name="a_date" value="<?php echo ConvertToThaiDateSplit3($feth_activity['a_date']); ?>" required>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">สถานที่</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        name="a_place" value="<?php echo $feth_activity['a_place']; ?>" required />
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">บทบาทและการมีส่วนร่วม</label>
                                                                                    <textarea class="form-control"
                                                                                        rows="3" name="a_detail"
                                                                                        required><?php echo $feth_activity['a_detail']; ?></textarea>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for=""
                                                                                        class="form-label">อัพโหลดรูปภาพ
                                                                                    </label>
                                                                                    <br/>
                                                                                    <img src="uploaded/activity_img/<?php echo $feth_activity['a_img']; ?>" class="img-fluid w-25 mb-3" />
                                                                                    <input class="form-control"
                                                                                        type="file" id="formFile"
                                                                                        name="a_img">
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
                                                    <form method="post" action="process/delete_activity.php">
                                                        <input type="hidden" value="<?php echo $_SESSION['s_id']; ?>"
                                                            name="s_id" />
                                                        <input type="hidden"
                                                            value="<?php echo $feth_activity['a_id']; ?>"
                                                            name="a_id" />
                                                        <button type="button" class="btn btn-danger w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel<?php echo $feth_activity['a_id']; ?>">
                                                           <i class="bi bi-trash"></i> ลบ
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalDel<?php echo $feth_activity['a_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel<?php echo $feth_activity['a_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header" style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel<?php echo $feth_activity['a_id']; ?>">
                                                                            
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