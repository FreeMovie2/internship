<?php
    session_start();
    include("connect/connect.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_news = $conn->prepare("SELECT * FROM news ORDER BY n_id ASC");
        $sql_news->execute();
        $result_news = $sql_news->get_result();
        
        $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
        $sql_company->bind_param("s", $_SESSION["s_id"]);
        $sql_company->execute();
        $result_company = $sql_company->get_result();
        $fetch_company = $result_company->fetch_assoc();

        $sql_student = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
        $sql_student->bind_param("s", $_SESSION["s_id"]);
        $sql_student->execute();
        $result_student = $sql_student->get_result();
        $fetch_student = $result_student->fetch_assoc();

        $sql_information  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
        $sql_information->bind_param("s", $_SESSION["s_id"]);
        $sql_information->execute();
        $result_information = $sql_information->get_result();
        $fetch_information = $result_information->fetch_assoc();

        $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
        $sql_parent->bind_param("s", $_SESSION["s_id"]);
        $sql_parent->execute();
        $result_parent = $sql_parent->get_result();
        $fetch_parent = $result_parent->fetch_assoc();
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
                            <h3 class="mb-0">ยินดีต้อนรับ</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="index.php">หน้าหลัก</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    แดชบอร์ด
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-light">
                                    <h3 class="card-title">สถานะการอัพเดทข้อมูล</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <?php
                                                if($fetch_student['s_update_information'] == "N"){
                                            ?>
                                                <h4>1. ข้อมูลส่วนบุคคล</h4>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="bi bi-x-circle-fill"></i> ยังไม่ได้แก้ไขข้อมูล <a href="edit_information.php" class="alert-link btn btn-sm btn-danger">แก้ไข</a>
                                                </div>

                                            <?php }else{ ?>
                                                <h4>1. ข้อมูลส่วนบุคคล</h4>
                                                <div class="alert alert-success" role="alert">
                                                    <i class="bi bi-check-circle-fill"></i> แก้ไขข้อมูลแล้ว <a href="edit_information.php" class="alert-link btn btn-sm btn-success">แก้ไขเพิ่มเติม</a>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <?php
                                                if($fetch_parent['p_update_status'] == "N"){
                                            ?>
                                                <h4>2. ข้อมูลผู้ปกครอง/เพื่อนสนิท</h4>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="bi bi-x-circle-fill"></i> ยังไม่ได้แก้ไขข้อมูล <a href="edit_parent.php" class="alert-link btn btn-sm btn-danger">แก้ไข</a>
                                                </div>

                                            <?php }else{ ?>
                                                <h4>2. ข้อมูลผู้ปกครอง/เพื่อนสนิท</h4>
                                                <div class="alert alert-success" role="alert">
                                                    <i class="bi bi-check-circle-fill"></i> แก้ไขข้อมูลแล้ว <a href="edit_parent.php" class="alert-link btn btn-sm btn-success">แก้ไขเพิ่มเติม</a>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <div class="col-xl-4 col-md-6 col-12">
                                            <?php
                                                if($fetch_company['c_update_status'] == "N"){
                                            ?>
                                                <h4>3. ข้อมูลสถานประกอบการ</h4>
                                                <div class="alert alert-danger" role="alert">
                                                    <i class="bi bi-x-circle-fill"></i> ยังไม่ได้แก้ไขข้อมูล <a href="edit_company.php" class="alert-link btn btn-sm btn-danger">แก้ไข</a>
                                                </div>

                                            <?php }else{ ?>
                                                <h4>3. ข้อมูลสถานประกอบการ</h4>
                                                <div class="alert alert-success" role="alert">
                                                    <i class="bi bi-check-circle-fill"></i> แก้ไขข้อมูลแล้ว <a href="edit_company.php" class="alert-link btn btn-sm btn-success">แก้ไขเพิ่มเติม</a>
                                                </div>
                                            <?php } ?>
                                        </div>

                               
                                    </div>
                                </div>
                            </div> <!-- /.card --> <!-- DIRECT CHAT -->
                            
                        </div> 
                    </div> <!-- /.row (main row) -->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->

            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->

                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-light">
                                    <h3 class="card-title">ข่าวประชาสัมพันธ์</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">

                                    
                                    <?php
                                        while($fetch_news = $result_news->fetch_assoc()){
                                    ?>
                                    
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="card">
                                                <img src="assets/img/news.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h4><?php echo $fetch_news['n_name'] ?></h4>
                                                    
                                                    <a href="news.php?news_id=<?php echo $fetch_news['n_id']; ?>" class="btn btn-info w-100">อ่านต่อ</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php } ?>
                                    </div>
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