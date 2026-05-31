<nav class="app-header navbar navbar-expand" data-bs-theme="dark" style="border-bottom:none !important; background: #FF3835;background: linear-gradient(135deg, #FF3835, #E87B9D);">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i
                        class="bi bi-list"></i> </a> </li>
            <li class="nav-item d-none d-md-block"> <a href="index.php" class="nav-link">หน้าหลัก</a> </li>
           
        </ul>
        <!--end::Start Navbar Links-->
        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!--begin::Manual Link-->
            <li class="nav-item"> <a class="btn btn-warning btn-sm" href="../manual/<?php 
                $role = $_SESSION['t_role'] ?? 'head';
                $manualMap = [
                    'head' => 'head_manual.pdf',
                    'director' => 'director_manual.pdf',
                    'admin' => 'admin_manual.pdf'
                ];
                echo $manualMap[$role] ?? 'head_manual.pdf';
            ?>" target="_blank"> <i class="bi bi-file-pdf"></i> คู่มือการใช้ระบบ </a> </li>
            <!--end::Manual Link-->
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize"
                        class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit"
                        style="display: none;"></i> </a> </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu"> 
                <a href="#" class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"> 
                    <img src="assets/img/logo.png"
                        class="user-image rounded-circle shadow" alt="User Image"> 
                        <spanclass="d-none d-md-inline">  <?php echo $_SESSION['t_name'] . " " . $_SESSION['t_surname'];  ?></span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header" style="background: #FF3835;background: linear-gradient(135deg, #FF3835, #E87B9D);"> <img src="assets/img/logo.png"
                            class="rounded-circle shadow" alt="User Image">
                        <p>
                            <?php echo $_SESSION['t_name']  . " " . $_SESSION['t_surname'];  ?>
                            <small>วิทยาลัยเทคนิคฉะเชิงเทรา</small>
                        </p>
                    </li>
                    <!--end::User Image-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer bg-white"> <a href="process/logout.php"
                            class="btn btn-danger w-100">ออกจากระบบ</a> </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--end::Header-->
<!--begin::Sidebar-->