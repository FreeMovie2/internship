<?php
    include("connect/connect.php");
    include("component/function.php")
?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header.php");
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
                            <h2 class="h1 mb-4">ระบบการจัดการฝึกประสบการณ์สมรรถนะวิชาชีพของผู้เรียนสังกัดสำนักงานคณะกรรมการอาชีวศึกษา</h2>
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
                                    <div class="mb-4">
                                        <p class="d-md-none text-center"><img class="img-fluid rounded mb-4 w-25" loading="lazy" src="assets/img/logo.png"></p>
                                        
                                        <h2 class="text-center d-md-none">เข้าสู่ระบบ</h2>
                                        <p class="text-center d-md-none">สำหรับผู้เรียน</p>

                                        <h2 class="d-none d-md-block">เข้าสู่ระบบ</h2>
                                        <p class="d-none d-md-block">สำหรับผู้เรียน</p>
                                        <?php // AlertBox(); ?>
                                    </div>
                                </div>
                            </div>
                            <form action="process/login.php" method="post">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="s_username" placeholder="username" required>
                                            <label for="text" class="form-label">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="s_password" id="password" value="" placeholder="Password" required>
                                            <label for="password" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" type="submit" name="submit">เข้าสู่ระบบ</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-center mt-4">
                                        <a href="../index.php" class="link-secondary text-decoration-none">
                                            <i class="bi bi-arrow-left-circle"></i> กลับไปหน้าหลัก
                                        </a>
                                    </div>
                                    <p class="mt-4 mb-0 text-center">&copy; <?php echo date("Y")?> วิทยาลัยเทคนิคฉะเชิงเทรา - โดยนายอาคม วงษ์คง</p>
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