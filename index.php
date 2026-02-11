<?php
    include("connect/connect.php");
    include("component/function.php");
?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header.php");
?>

<style>
    .role-box {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease-in-out;
        background-color: #f8f9fa;
        color: #333;
        display: block; /* ทำให้ทั้งกล่องเป็นลิงก์ที่คลิกได้ */
    }

    .role-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-color: #0d6efd;
        background-color: #fff;
        text-decoration: none; /* เอาขีดเส้นใต้ลิงก์ออก */
    }

    .role-box i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        color: #0d6efd;
    }
</style>

<body class="bg-danger">
    <?php 
        $sql = "SELECT * FROM setting WHERE s_id = 1";
        $query =  mysqli_query($conn,$sql);
        $fetch = mysqli_fetch_array($query);
    ?>
    
    <section class="py-3 py-md-5 vh-100 d-flex align-items-center justify-content-center" style="background: #EF172D !important;
    background: linear-gradient(135deg, #EF172D, #E84A3C) !important;">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-md-6 col-xl-7 d-none d-md-block">
                    <div class="d-flex justify-content-center text-light">
                        <div class="col-12 col-xl-9">
                            <img class="img-fluid rounded mb-4 w-25" loading="lazy" src="assets/img/logo.png">
                                    <img class="img-fluid rounded mb-4 w-25" loading="lazy" src="assets/img/2.png">
                            <img class="img-fluid rounded mb-4 w-25" loading="lazy" src="assets/img/3.png">
                            <hr class="border-primary-subtle mb-4">
                            <h2 class="h1 mb-4">ระบบการฝึกประสบการณ์สมรรถนะวิชาชีพ/ฝึกอาชีพ</h2>
                            <p class="lead mb-5"><?php echo $fetch['s_school_name']; ?></p>
                            <div class="text-endx">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                                    <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-5">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4 text-center">
                                        <p class="d-md-none"><img class="img-fluid rounded mb-4 w-25" loading="lazy" src="assets/img/logo.png"></p>
                                        <h3>เลือกประเภทผู้ใช้งาน</h3>
                                        <p class="text-muted">กรุณาเลือกช่องทางเพื่อเข้าสู่ระบบ</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row gy-3">
                                <div class="col-12 col-sm-6">
                                    <a href="student_internship/login.php" class="role-box">
                                        <i class="bi bi-people-fill"></i>
                                        <p class="mb-0 fw-bold">สำหรับนักเรียน</p>
                                    </a>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <a href="teacher/login.php" class="role-box">
                                        <i class="bi bi-person-video3"></i>
                                        <p class="mb-0 fw-bold">สำหรับอาจารย์</p>
                                    </a>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <a href="teacher/login.php" class="role-box">
                                       <i class="bi bi-person-circle"></i>
                                        <p class="mb-0 fw-bold">ผู้อำนวยการ</p> </a>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <a href="teacher/login.php" class="role-box">
                                        <i class="bi bi-person-gear"></i>
                                        <p class="mb-0 fw-bold">ผู้ดูแลระบบ</p>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <p class="mt-4 mb-0 text-center text-muted">&copy; <?php echo date("Y")?> วิทยาลัยเทคนิคฉะเชิงเทรา</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    <?php
        include("component/script.php");
    ?>
</body>

</html>