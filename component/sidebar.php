<aside class="app-sidebar bg-light shadow" data-bs-theme="light">
<?php
                        $sql_company_side = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
                        $sql_company_side->bind_param("s", $_SESSION["s_id"]);
                        $sql_company_side->execute();
                        $result_company_side = $sql_company_side->get_result();
                        $fetch_company_side = $result_company_side->fetch_assoc();

                        $sql_student_side = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
                        $sql_student_side->bind_param("s", $_SESSION["s_id"]);
                        $sql_student_side->execute();
                        $result_student_side = $sql_student_side->get_result();
                        $fetch_student_side = $result_student_side->fetch_assoc();

                        $sql_information_side  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
                        $sql_information_side->bind_param("s", $_SESSION["s_id"]);
                        $sql_information_side->execute();
                        $result_information_side = $sql_information_side->get_result();
                        $fetch_information_side = $result_information_side->fetch_assoc();

                        $sql_parent_side  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
                        $sql_parent_side->bind_param("s", $_SESSION["s_id"]);
                        $sql_parent_side->execute();
                        $result_parent_side = $sql_parent_side->get_result();
                        $fetch_parent_side = $result_parent_side->fetch_assoc();
    ?>
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
                <li class="nav-header">เมนูการใช้งาน</li>
                <li class="nav-item"> 
                    <a href="index.php" class="nav-link"> <i class="nav-icon bi bi bi-house-door"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <li class="nav-item"> 
                    <a href="internship.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บันทึกการฝึกอาชีพ</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="activity.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บันทึกการเข้าร่วมกิจกรรม</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="volunteer.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บันทึกความดีและจิตอาสา</p>
                    </a>
                </li>

                <li class="nav-item"> 
                    <a href="seminar.php" class="nav-link"> <i class="nav-icon bi bi-book"></i>
                        <p>บันทึกกิจกรรมสัมมนา</p>
                    </a>
                </li>

                <?php if($fetch_student_side["s_update_information"] == "Y" && $fetch_parent_side["p_update_status"] == "Y" && $fetch_company_side["c_update_status"] == "Y"){  ?>

                <li class="nav-item"> 
                    <a href="export_book.php" class="nav-link"> <i class="nav-icon bi bi-printer"></i>
                        <p>พิมพ์เล่มแบบบันทึก</p>
                    </a>
                </li>



                
                

                <li class="nav-item"> <a href="#" class="nav-link">
                <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>
                            แบบฟอร์ม
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        
                        <li class="nav-item"> 
                            <a href="export_company.php" class="nav-link"> 
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>รายละเอียดสถานประกอบการ</p>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a href="export_information.php" class="nav-link"> 
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>ประวัติผู้ฝึกอาชีพ</p>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a href="export_internship.php" class="nav-link"> 
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>แบบประเมินการฝึกอาชีพ</p>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a href="export_student.php" class="nav-link"> 
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>แบบฟอร์มส่งตัวกลับ</p>
                            </a> 
                        </li>

                        <li class="nav-item"> 
                            <a href="export_portfolio.php" class="nav-link"> 
                                <i class="nav-icon bi bi-file-earmark-text"></i>
                                <p>แฟ้มสะสมผลงาน</p>
                            </a> 
                        </li>
                       
                    </ul>
                </li>

                <?php } ?>

                <li class="nav-item"> <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            แก้ไขข้อมูล
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <?php if($fetch_student_side["s_update_information"] == "N"){  ?>
                        <li class="nav-item"> 
                            <a href="edit_information.php" class="nav-link <?php echo "bg-danger";?> <?php echo "text-light"; ?>"> 
                                <i class="nav-icon bi bi-hourglass"></i>
                                <p>แก้ไขข้อมูลส่วนตัว</p>
                            </a> 
                        </li>

                        <?php }else{ ?>
                        <li class="nav-item"> 
                            <a href="edit_information.php" class="nav-link"> 
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>แก้ไขข้อมูลส่วนตัว</p>
                            </a> 
                        </li>
                        <?php } ?>

                        <?php if($fetch_parent_side["p_update_status"] == "N"){  ?>
                        <li class="nav-item"> 
                            <a href="edit_parent.php" class="nav-link <?php echo "bg-danger";?> <?php echo "text-light"; ?>"> 
                                <i class="nav-icon bi bi-hourglass"></i>
                                <p>แก้ไขข้อมูลผู้ปกครอง/บุคคลใกล้ชิด/เพื่อนสนิท</p>
                            </a> 
                        </li>

                        <?php }else{ ?>
                        <li class="nav-item"> 
                            <a href="edit_parent.php" class="nav-link"> 
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>แก้ไขข้อมูลผู้ปกครอง/บุคคลใกล้ชิด/เพื่อนสนิท</p>
                            </a> 
                        </li>
                        <?php } ?>

                        <?php if($fetch_company_side["c_update_status"] == "N"){  ?>
                        <li class="nav-item"> 
                            <a href="edit_company.php" class="nav-link <?php echo "bg-danger";?> <?php echo "text-light"; ?>"> 
                                <i class="nav-icon bi bi-hourglass"></i>
                                <p>แก้ไขข้อมูลสถานที่ฝึกอาชีพ</p>
                            </a> 
                        </li>

                        <?php }else{ ?>
                        <li class="nav-item"> 
                            <a href="edit_company.php" class="nav-link"> 
                                <i class="nav-icon bi bi-pencil-square"></i>
                                <p>แก้ไขข้อมูลสถานที่ฝึกอาชีพ</p>
                            </a> 
                        </li>
                        <?php } ?>

                        

                        
                        
                        
                    </ul>
                </li>

               

                

                


            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
<!--begin::App Main-->