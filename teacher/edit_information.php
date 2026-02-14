<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{

        if(isset($_GET['student_id'])&& $_SERVER["REQUEST_METHOD"] == "GET"){
            $s_id = $_GET['student_id'];
        
            $sql_student  = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
            $sql_student->bind_param("s", $s_id);
            $sql_student->execute();
            $result_student = $sql_student->get_result();
            $fetch_student = $result_student->fetch_assoc();
        
            $sql_student_information  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
            $sql_student_information->bind_param("s", $s_id);
            $sql_student_information->execute();
            $result_information = $sql_student_information->get_result();
            $fetch_information = $result_information->fetch_assoc();

            $subject_rows = [];
            $sql_subjects = $conn->prepare("SELECT subject_code, subject_name FROM student_internship_subjects WHERE s_id = ? ORDER BY id ASC");
            if ($sql_subjects) {
                $sql_subjects->bind_param("s", $s_id);
                $sql_subjects->execute();
                $result_subjects = $sql_subjects->get_result();
                while ($subject = $result_subjects->fetch_assoc()) {
                    $subject_rows[] = $subject;
                }
            }
        

            $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
            $query_province = mysqli_query($conn,$sql_province);
            $sql_district = "SELECT * FROM th_district where province_id = '".$fetch_information['s_province1']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_district = mysqli_query($conn,$sql_district);
            $sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '".$fetch_information['s_aumpher1']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_subdistrict = mysqli_query($conn,$sql_subdistrict);
    
            $sql_province2 = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
            $query_province2 = mysqli_query($conn,$sql_province2);
            $sql_district2 = "SELECT * FROM th_district where province_id = '".$fetch_information['s_province2']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_district2 = mysqli_query($conn,$sql_district2);
            $sql_subdistrict2 = "SELECT * FROM th_subdistrict where district_id = '".$fetch_information['s_aumpher2']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_subdistrict2 = mysqli_query($conn,$sql_subdistrict2);
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
                            <h3 class="mb-0">แก้ไขข้อมูลส่วนตัว</h3>
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
                                    <h3 class="card-title">แก้ไขข้อมูลส่วนตัว</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <form action="process/edit_information.php" method="POST" enctype="multipart/form-data">
                                        <!-- ข้อมูลส่วนตัว -->

                                        <div class="mb-3 d-none">
                                           
                                            <input type="text" class="form-control" id="s_id" name="s_id"
                                                value="<?php echo $s_id; ?>" readonly
                                            >
                                        </div>

                                        <h4>1. ข้อมูลเกี่ยวกับผู้ฝึกอาชีพ</h4>
                                        <div class="form-group mb-3">
                                                <label class="form-label">คำนำหน้าชื่อ</label>
                                                <select class="form-control" name="s_prefix" required>
                                                    <option value="<?php echo $fetch_student['s_prefix']; ?>"><?php echo $fetch_student['s_prefix']; ?></option>
                                                    <option>นาย</option>
                                                    <option>นางสาว</option>
                                                    <option>นาง</option>
                                                </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ</label>
                                            <input type="text" class="form-control" id="s_name" name="s_name"
                                                value="<?php echo $fetch_student['s_name']; ?>"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">นามสกุล</label>
                                            <input type="text" class="form-control" id="s_surname" name="s_surname"
                                                value="<?php echo $fetch_student['s_surname']; ?>"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_year" class="form-label">ระดับชั้น / กลุ่ม</label>
                                            <input type="text" class="form-control" id="s_year" name="s_year"
                                                value="<?php echo $fetch_student['s_year']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_student_id" class="form-label">รหัสประจำตัว</label>
                                            <input type="text" class="form-control" id="s_student_id"
                                                name="s_student_id" value="<?php echo $fetch_student['s_student_id']; ?>">
                                        </div>

                                        <div class="form-group mb-3">
                                                <label class="form-label">หลักสูตรการศึกษา</label>
                                                <select class="form-control" name="s_type_edu" required>
                                                    <option value="<?php echo $fetch_student['s_type_edu']; ?>"><?php echo $fetch_student['s_type_edu']; ?></option>
                                                    <option>ภาคปกติ</option>
                                                    <option>ภาคสมทบ</option>
                                                    <option>ระบบทวิภาค</option>
                                                </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_major" class="form-label">แผนกวิชา</label>
                                            <input type="text" class="form-control" id="s_major"
                                                name="s_major" value="<?php echo $fetch_student['s_major']; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_birthday" class="form-label">วัน/เดือน/ปีเกิด (ที่กรอกไว้ <?php echo $fetch_information['s_birthday']; ?>)</label>
                                            <input type="text" class="form-control buddhist-date-picker" id="buddhistDate_1" name="s_birthday"
                                            value="<?php echo ConvertToThaiDateSplit2($fetch_information['s_birthday']); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_age" class="form-label">อายุ</label>
                                            <input type="number" class="form-control" id="s_age" name="s_age"
                                                value="<?php echo $fetch_information['s_age']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_height" class="form-label">ส่วนสูง (เซนติเมตร)</label>
                                            <input type="number" class="form-control" id="s_height" name="s_height"
                                                value="<?php echo $fetch_information['s_height']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_weight" class="form-label">น้ำหนัก (กิโลกรัม)</label>
                                            <input type="number" class="form-control" id="s_weight" name="s_weight"
                                                value="<?php echo $fetch_information['s_weight']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_nation1" class="form-label">สัญชาติ</label>
                                            <input type="text" class="form-control" id="s_nation1" name="s_nation1"
                                                value="<?php echo $fetch_information['s_nation1']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_nation2" class="form-label">เชื้อชาติ</label>
                                            <input type="text" class="form-control" id="s_nation2" name="s_nation2"
                                                value="<?php echo $fetch_information['s_nation2']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_region" class="form-label">ศาสนา</label>
                                            <input type="text" class="form-control" id="s_region" name="s_region"
                                                value="<?php echo $fetch_information['s_region']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_hospital" class="form-label">โรคประจำตัว</label>
                                            <input type="text" class="form-control" id="s_hospital" name="s_hospital"
                                                value="<?php echo $fetch_information['s_hospital']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_medicine" class="form-label">ประวัติการแพ้ยา/อื่นๆ</label>
                                            <input type="text" class="form-control" id="s_medicine" name="s_medicine"
                                                value="<?php echo $fetch_information['s_medicine']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_blood" class="form-label">หมู่เลือด</label>
                                            <input type="text" class="form-control" id="s_blood" name="s_blood"
                                                value="<?php echo $fetch_information['s_blood']; ?>" required>
                                        </div>


                                        <div class="mb-3">
                                            <label for="s_tel" class="form-label">โทรศัพท์</label>
                                            <input type="text" class="form-control" id="s_tel" name="s_tel"
                                                value="<?php echo $fetch_student['s_tel']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="s_line_id" class="form-label">Line ID</label>
                                            <input type="text" class="form-control" id="s_line_id" name="s_line_id"
                                                value="<?php echo $fetch_student['s_line_id'] ?? ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_email" class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" id="s_email" name="s_email"
                                                value="<?php echo $fetch_student['s_email']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label mb-0">รายวิชาที่นำออกฝึกประสบการณ์</label>
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-subject-row">เพิ่มรายวิชา</button>
                                            </div>
                                            <div id="subject-rows">
                                                <?php if (!empty($subject_rows)) { ?>
                                                    <?php foreach ($subject_rows as $subject) { ?>
                                                        <div class="row g-2 mb-2 subject-row">
                                                            <div class="col-md-4">
                                                                <input type="text" class="form-control" name="subject_code[]" placeholder="รหัสรายวิชา" value="<?php echo htmlspecialchars($subject['subject_code']); ?>">
                                                            </div>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" name="subject_name[]" placeholder="ชื่อรายวิชา" value="<?php echo htmlspecialchars($subject['subject_name']); ?>">
                                                            </div>
                                                            <div class="col-md-1 d-grid">
                                                                <button type="button" class="btn btn-outline-danger remove-subject-row">ลบ</button>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <div class="row g-2 mb-2 subject-row">
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" name="subject_code[]" placeholder="รหัสรายวิชา">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input type="text" class="form-control" name="subject_name[]" placeholder="ชื่อรายวิชา">
                                                        </div>
                                                        <div class="col-md-1 d-grid">
                                                            <button type="button" class="btn btn-outline-danger remove-subject-row">ลบ</button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <label for="s_special" class="form-label">ความสามารถพิเศษ</label>
                                        </div>
                                            <?php
                                                $specials = explode(",", $fetch_student['s_special']);
                                                foreach($specials as $index => $special){
                                            ?>
                                             <div class="mb-3 input-group">
                                                <span class="input-group-text" id="s_special<?php echo $index; ?>"><?php echo $index+1; ?></span>
                                               <input type="text" class="form-control" name="s_special<?php echo $index; ?>"
                                                value="<?php echo $special; ?>" aria-describedby="s_special<?php echo $index; ?>" required>
                                            </div>

                                            <?php } ?>

                                        <div class="mb-3">
                                            <label for="s_grade" class="form-label">คะแนนเฉลี่ยสะสม (เกรด)</label>
                                            <input type="text" class="form-control" id="s_grade" name="s_grade"
                                                value="<?php echo $fetch_student['s_grade']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_map"
                                                class="form-label">อัพโหลดรูปภาพประจำตัว</label>
                                            <?php
                                                if($fetch_student['s_pic'] != ""){
                                            ?>
                                            <br />
                                            <img src="../student_internship/information_file/profile/<?php echo $fetch_student['s_pic']; ?>"
                                                class="img-fluid w-25 mb-3" />

                                            <?php }else{ ?>
                                            <br />
                                                <img src="assets/img/no_img.jpg" class="img-fluid w-25 mb-3" />
                                            <?php } ?>
                                            <input class="form-control" type="file" id="formFile" name="s_pic">
                                        </div>
                                        

                                        

                                        <!-- ที่อยู่ -->
                                        <h4>2. ข้อมูลที่อยู่</h4>
                                        <h5>2.1) ภูมิลำเนาของผู้ฝึกอาชีพ</h5>
                                        <div>
                                            <div class="mb-3">
                                                <label for="s_home1" class="form-label">เลขที่</label>
                                                <input type="text" class="form-control" id="form_1_s_home1" name="s_home1"
                                                    value="<?php echo $fetch_information['s_home1']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_moo1" class="form-label">หมู่ที่</label>
                                                <input type="text" class="form-control" id="form_1_s_moo1" name="s_moo1"
                                                    value="<?php echo $fetch_information['s_moo1']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_soi1" class="form-label">ตรอก/ซอย</label>
                                                <input type="text" class="form-control" id="form_1_s_soi1" name="s_soi1"
                                                    value="<?php echo $fetch_information['s_soi1']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_road1" class="form-label">ถนน</label>
                                                <input type="text" class="form-control" id="form_1_s_road1" name="s_road1"
                                                    value="<?php echo $fetch_information['s_road1']; ?>" required>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label class="form-label">จังหวัด</label>
                                                <select class="form-control" id="province_id" name="s_province1" required>
                                                    <option value="">เลือกจังหวัด</option>
                                                    <?php while ($province = mysqli_fetch_array($query_province)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_province1'] == $province['province_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $province['province_id'] ?>">
                                                        <?php echo $province['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">อำเภอ</label>
                                                <select class="form-control" id="district_id" name="s_aumpher1" required>
                                                    <option value="">เลือกอำเภอ</option>
                                                    <?php while ($district = mysqli_fetch_array($query_district)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_aumpher1'] == $district['district_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $district['district_id'] ?>">
                                                        <?php echo $district['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">ตำบล</label>
                                                <select class="form-control" id="subdistrict_id" name="s_tumbon1"
                                                    required>
                                                    <option value="">เลือกตำบล</option>
                                                    <?php while ($subdistrict = mysqli_fetch_array($query_subdistrict)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_tumbon1'] == $subdistrict['subdistrict_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $subdistrict['subdistrict_id'] ?>">
                                                        <?php echo $subdistrict['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <h5>2.2) ที่อยู่ปัจจุบัน </h5>
                                        <div>
                                            <div class="mb-3">
                                                <label for="s_home1" class="form-label">เลขที่</label>
                                                <input type="text" class="form-control" id="form_2_s_home1" name="s_home2"
                                                    value="<?php echo $fetch_information['s_home2']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_moo1" class="form-label">หมู่ที่</label>
                                                <input type="text" class="form-control" id="form_2_s_moo1" name="s_moo2"
                                                    value="<?php echo $fetch_information['s_moo2']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_soi1" class="form-label">ตรอก/ซอย</label>
                                                <input type="text" class="form-control" id="form_2_s_soi1" name="s_soi2"
                                                    value="<?php echo $fetch_information['s_soi2']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_road1" class="form-label">ถนน</label>
                                                <input type="text" class="form-control" id="form_2_s_road1" name="s_road2"
                                                    value="<?php echo $fetch_information['s_road2']; ?>" required>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label class="form-label">จังหวัด</label>
                                                <select class="form-control" id="province_id2" name="s_province2" required>
                                                    <option value="">เลือกจังหวัด</option>
                                                    <?php while ($province2 = mysqli_fetch_array($query_province2)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_province2'] == $province2['province_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $province2['province_id'] ?>">
                                                        <?php echo $province2['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">อำเภอ</label>
                                                <select class="form-control" id="district_id2" name="s_aumpher2" required>
                                                    <option value="">เลือกอำเภอ</option>
                                                    <?php while ($district2 = mysqli_fetch_array($query_district2)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_aumpher2'] == $district2['district_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $district2['district_id'] ?>">
                                                        <?php echo $district2['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label">ตำบล</label>
                                                <select class="form-control" id="subdistrict_id2" name="s_tumbon2" required>
                                                    <option value="">เลือกตำบล</option>
                                                    <?php while ($subdistrict2 = mysqli_fetch_array($query_subdistrict2)) { ?>
                                                    <option
                                                        <?= ($fetch_information['s_tumbon2'] == $subdistrict2['subdistrict_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $subdistrict2['subdistrict_id'] ?>">
                                                        <?php echo $subdistrict2['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>


                                        <!-- ปุ่มส่ง -->
                                        <button name="submit" class="btn btn-primary w-100">บันทึกข้อมูล</button>
                                       
                                    </form>
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
    <style>
        .edit-section {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            background: #fff;
        }

        .edit-section > .section-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin: 0;
        }

        .edit-section-body {
            padding-top: 0.75rem;
        }

        .edit-section-body.form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem 1rem;
        }

        .edit-section-body.form-grid > .mb-3,
        .edit-section-body.form-grid > .form-group {
            margin-bottom: 0 !important;
        }

        .edit-section-body.form-grid > .full-width {
            grid-column: 1 / -1;
        }

        .sub-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem 1rem;
        }

        .sub-grid > .mb-3,
        .sub-grid > .form-group {
            margin-bottom: 0 !important;
        }

        .sticky-save-btn {
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .sticky-save-btn {
                position: sticky;
                bottom: 0.75rem;
                z-index: 25;
            }
        }

        @media (max-width: 576px) {
            .edit-section {
                padding: 0.65rem 0.8rem;
            }

            .edit-section-body.form-grid {
                grid-template-columns: 1fr;
            }

            .sub-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <script>
        (function () {
            const addButton = document.getElementById('add-subject-row');
            const container = document.getElementById('subject-rows');
            if (!addButton || !container) {
                return;
            }

            addButton.addEventListener('click', function () {
                const row = document.createElement('div');
                row.className = 'row g-2 mb-2 subject-row';
                row.innerHTML = `
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="subject_code[]" placeholder="รหัสรายวิชา">
                    </div>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="subject_name[]" placeholder="ชื่อรายวิชา">
                    </div>
                    <div class="col-md-1 d-grid">
                        <button type="button" class="btn btn-outline-danger remove-subject-row">ลบ</button>
                    </div>
                `;
                container.appendChild(row);
            });

            container.addEventListener('click', function (event) {
                if (!event.target.classList.contains('remove-subject-row')) {
                    return;
                }

                const rows = container.querySelectorAll('.subject-row');
                if (rows.length === 1) {
                    const codeInput = rows[0].querySelector('input[name="subject_code[]"]');
                    const nameInput = rows[0].querySelector('input[name="subject_name[]"]');
                    if (codeInput) codeInput.value = '';
                    if (nameInput) nameInput.value = '';
                    return;
                }

                event.target.closest('.subject-row').remove();
            });
        })();

        (function () {
            const form = document.querySelector('form[action="process/edit_information.php"]');
            if (!form) {
                return;
            }

            const headings = Array.from(form.querySelectorAll('h4'));
            if (!headings.length) {
                return;
            }

            headings.forEach(function (heading) {
                const section = document.createElement('div');
                section.className = 'edit-section';

                const title = document.createElement('h4');
                title.className = 'section-title';
                title.textContent = heading.textContent.trim();
                section.appendChild(title);

                const body = document.createElement('div');
                body.className = 'edit-section-body';

                let current = heading.nextSibling;
                while (current && !(current.nodeType === 1 && current.tagName === 'H4')) {
                    const next = current.nextSibling;
                    body.appendChild(current);
                    current = next;
                }

                section.appendChild(body);
                heading.parentNode.replaceChild(section, heading);
            });
        })();

        (function () {
            const form = document.querySelector('form[action="process/edit_information.php"]');
            if (!form) {
                return;
            }

            const sectionBodies = form.querySelectorAll('.edit-section-body');
            sectionBodies.forEach(function (body) {
                body.classList.add('form-grid');

                Array.from(body.children).forEach(function (el) {
                    const tag = el.tagName;
                    if (
                        tag === 'H5' ||
                        (tag === 'DIV' && !el.classList.contains('mb-3') && !el.classList.contains('form-group'))
                    ) {
                        el.classList.add('full-width');
                    }

                    if (
                        el.classList.contains('mb-3') &&
                        (
                            el.querySelector('#buddhistDate_1') ||
                            el.querySelector('#s_major') ||
                            el.querySelector('#s_email') ||
                            el.querySelector('#s_hospital') ||
                            el.querySelector('#s_medicine') ||
                            el.querySelector('#s_grade') ||
                            el.querySelector('#formFile') ||
                            el.querySelector('#subject-rows') ||
                            el.querySelector('.input-group')
                        )
                    ) {
                        el.classList.add('full-width');
                    }

                    if (
                        el.classList.contains('full-width') &&
                        el.tagName === 'DIV' &&
                        el.querySelector(':scope > .mb-3, :scope > .form-group')
                    ) {
                        el.classList.add('sub-grid');
                    }
                });
            });

            const submitBtn = form.querySelector('button[name="submit"]');
            if (submitBtn) {
                submitBtn.classList.add('sticky-save-btn');
            }

            const telInput = form.querySelector('#s_tel');
            if (telInput) {
                telInput.setAttribute('inputmode', 'numeric');
                telInput.addEventListener('input', function () {
                    this.value = this.value.replace(/\D+/g, '');
                });
            }

            const emailInput = form.querySelector('#s_email');
            if (emailInput) {
                emailInput.addEventListener('input', function () {
                    if (!this.value || this.validity.valid) {
                        this.setCustomValidity('');
                    } else {
                        this.setCustomValidity('Invalid email format');
                    }
                });
            }
        })();
    </script>
</body>
<!--end::Body-->

</html>
<?php } ?>
<?php } ?>
