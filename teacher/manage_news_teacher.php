<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_news = $conn->prepare("SELECT * FROM news_teacher ORDER BY n_id ASC");
        $sql_news->execute();
        $result_news = $sql_news->get_result(); 
       
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
                            <h3 class="mb-0">บริหารจัดการข่าวสารครู</h3>
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
                                    <h3 class="card-title">บริหารจัดการข่าวสารครู</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <form method="post" action="process/add_news_teacher.php" enctype="multipart/form-data">
                                                <input type="text" name="n_author" value="<?php echo $_SESSION['t_id'];?>" class="d-none" readonly>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalDel_verify">
                                                    <i class="bi bi-newspaper"></i> เพิ่มข่าวสาร
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade modal-lg"
                                                    id="exampleModalDel_verify"
                                                    tabindex="-1"
                                                    aria-labelledby="exampleModalDelLabel_verify"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="border-bottom: none;">
                                                                <h1 class="modal-title fs-5"
                                                                    id="exampleModalDelLabel_verify">
                                                                    เพิ่มข่าวสาร
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">พาดหัวข่าว</label>
                                                                        <input
                                                                            type="text"
                                                                            class="form-control"
                                                                            name="n_name"
                                                                            id=""
                                                                            aria-describedby="helpId"
                                                                            placeholder=""
                                                                            required
                                                                        />
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="n_date" class="form-label">วัน/เดือน/ปี</label>
                                                                        <input type="text" class="form-control buddhist-date-picker" id="buddhistDate_1" name="n_date" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">เนื้อหาข่าว</label>
                                                                        <textarea class="form-control summernote" name="n_detail" id="summernote" rows="3" required></textarea>
                                                                    </div>

                                                                    <div class="mb-3 mt-3">
                                                                        <label for="" class="form-label">อัพโหลดไฟล์ประกาศ (.pdf, .jpg, .jpeg, .png)</label>
                                                                        <input
                                                                            type="file"
                                                                            class="form-control"
                                                                            name="n_pic"
                                                                            id=""
                                                                            placeholder=""
                                                                            aria-describedby="fileHelpId"
                                                                            
                                                                        />
                                                                    </div> 

                                                                </div>

                                                            </div>
                                                            <div class="modal-footer" style="border-top: none;">
                                                                <p class="text-center">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">ปิด</button>
                                                                    <button type="submit" class="btn btn-primary"
                                                                        name="submit"><i class="bi bi-newspaper"></i>
                                                                        เพิ่มข่าวสาร</button>
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    

                                    <hr>






                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับที่</th>
                                                <th>พาดหัวข่าว</th>
                                                <th>ดูรายละเอียดข่าว</th>
                                                <th>แก้ไข</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            <?php while($fetch_news = $result_news->fetch_assoc()){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td><?php echo $fetch_news['n_name']; ?></td>
                                                <td><a href="news_teacher.php?news_id=<?php echo $fetch_news['n_id']; ?>" class="btn btn-info w-100"><i class="bi bi-newspaper"></i> อ่านข่าว</a></td>
                                                <td>
                                                    <form method="post" action="process/edit_news_teacher.php" enctype="multipart/form-data">
                                                            <input type="text" name="n_author" value="<?php echo $_SESSION['t_id'];?>" class="d-none" readonly>
                                                            <input type="text" name="n_id" value="<?php echo $fetch_news['n_id'];?>" class="d-none" readonly>
                                                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModalDel_verify<?php echo $fetch_news['n_id']; ?>">
                                                                <i class="bi bi-pencil-square"></i> แก้ไขข่าวสาร
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade modal-lg"
                                                                id="exampleModalDel_verify<?php echo $fetch_news['n_id']; ?>"
                                                                tabindex="-1"
                                                                aria-labelledby="exampleModalDelLabel_verify<?php echo $fetch_news['n_id']; ?>"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header" style="border-bottom: none;">
                                                                            <h1 class="modal-title fs-5"
                                                                                id="exampleModalDelLabel_verify<?php echo $fetch_news['n_id']; ?>">
                                                                                แก้ไขข่าวสาร
                                                                            </h1>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="mb-3">
                                                                                    <label for="" class="form-label">พาดหัวข่าว</label>
                                                                                    <input
                                                                                        type="text"
                                                                                        class="form-control"
                                                                                        name="n_name"
                                                                                        id=""
                                                                                        aria-describedby="helpId"
                                                                                        placeholder=""
                                                                                        value="<?php echo $fetch_news['n_name']; ?>"
                                                                                        required
                                                                                    />
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="n_date" class="form-label">วัน/เดือน/ปี</label>
                                                                                    <input type="text" class="form-control buddhist-date-picker" id="buddhistDate_1" name="n_date" value="<?php echo ConvertToThaiDateSplit2($fetch_news['n_date']); ?>" required>
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <label for="" class="form-label">เนื้อหาข่าว</label>
                                                                                    <textarea class="form-control summernote" name="n_detail" id="summernote" rows="3" required><?php echo $fetch_news['n_detail']; ?></textarea>
                                                                                </div>

                                                                                

                                                                                <div class="mb-3 mt-3">
                                                                                    <label for="" class="form-label">อัพโหลดไฟล์ประกาศ (.pdf, .jpg, .jpeg, .png)</label>
                                                                                    <?php 
                                                                                        if($fetch_news['n_pic'] == "default.pdf"){                       
                                                                                    ?>
                                                                                        <a href="#" class="btn btn-sm btn-dark">ไม่ได้อัพโหลดไฟล์</a>
                                                                                    <?php }else{ ?>
                                                                                        <a href="uploaded/news_resources/<?php echo $fetch_news['n_pic'];?>" class="btn btn-sm btn-primary" target="_blank">ดูไฟล์ที่อัพโหลด</a>
                                                                                    <?php } ?>
                                                                                    <input
                                                                                        type="file"
                                                                                        class="form-control"
                                                                                        name="n_pic"
                                                                                        id=""
                                                                                        placeholder=""
                                                                                        aria-describedby="fileHelpId"
                                                                                        
                                                                                    />
                                                                                </div> 

                                                                            </div>

                                                                        </div>
                                                                        <div class="modal-footer" style="border-top: none;">
                                                                            <p class="text-center">
                                                                                <button type="button" class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">ปิด</button>
                                                                                <button type="submit" class="btn btn-warning"
                                                                                    name="submit"><i class="bi bi-pencil-square"></i>
                                                                                    แก้ไขข่าวสาร</button>
                                                                            </p>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </form>                                             

                                                </td>
                                                <td>
                                                    <form method="post" action="process/delete_news_teacher.php">
                                                        <input type="text" name="n_id" class="d-none"
                                                            value="<?php echo $fetch_news['n_id']; ?>" readonly>
                                                        <button type="button" class="btn btn-danger w-100"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModalDel<?php echo $fetch_news['n_id']; ?>">
                                                            <i class="bi bi-trash"></i> ลบข่าว
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade"
                                                            id="exampleModalDel<?php echo $fetch_news['n_id']; ?>"
                                                            tabindex="-1"
                                                            aria-labelledby="exampleModalDelLabel<?php echo $fetch_news['n_id']; ?>"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header"
                                                                        style="border-bottom: none;">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="exampleModalDelLabel<?php echo $fetch_news['n_id']; ?>">
                                                                        </h1>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <h4 class="text-center text-danger">
                                                                                ยืนยันการลบข่าว
                                                                                <?php echo $fetch_news['n_name']; ?>
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
                                                                                ลบข่าว</button>
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