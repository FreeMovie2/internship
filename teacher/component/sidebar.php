<aside class="app-sidebar bg-light shadow" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link--> <a href="index.php" class="brand-link">
            <!--begin::Brand Image--> <img src="assets/img/logo.png" alt="Logo"
                class="brand-image opacity-75">
            <!--end::Brand Image-->
            <!--begin::Brand Text--> <span class="brand-text fw-bold">ระบบบันทึกการฝึกงาน</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <?php if($_SESSION['t_status'] != 'A'){ ?>
                <li class="nav-header">เมนูการใช้งาน</li>
                <li class="nav-item"> 
                    <a href="index.php" class="nav-link"> <i class="nav-icon bi bi bi-house-door"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="manage_student_internship.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการนิเทศนักเรียน</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="manage_student_advisor.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการนักเรียนที่ปรึกษา</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="statistics_internship.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>สถิติการฝึกอาชีพ</p>
                    </a>
                </li>
                <?php } else { ?>
                <li class="nav-header">เมนูผู้ดูแลระบบ</li>
                <li class="nav-item"> 
                    <a href="manage_student.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการนักเรียนทั้งหมด</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="manage_teacher.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการครู</p>
                    </a>
                </li>


                <li class="nav-item"> 
                    <a href="manage_news_student.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการข่าวสารนักเรียน</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="manage_news_teacher.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บริหารจัดการข่าวสารครู</p>
                    </a>
                </li>

                <?php } ?>

                

            



                
                

                

       

               

                

                


            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
<!--begin::App Main-->