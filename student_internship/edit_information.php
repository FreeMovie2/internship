<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{

        $sql_student  = $conn->prepare("SELECT * FROM students WHERE s_id = ?");
        $sql_student->bind_param("s", $_SESSION["s_id"]);
        $sql_student->execute();
        $result_student = $sql_student->get_result();
        $fetch_student = $result_student->fetch_assoc();
    
        $sql_student_information  = $conn->prepare("SELECT * FROM student_information WHERE s_id = ?");
        $sql_student_information->bind_param("s", $_SESSION["s_id"]);
        $sql_student_information->execute();
        $result_information = $sql_student_information->get_result();
        $fetch_information = $result_information->fetch_assoc();
    

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
                                                value="<?php echo $_SESSION['s_id']; ?>" readonly
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
                                            value="<?php echo ConvertToThaiDateSplit3($fetch_information['s_birthday']); ?>">
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
                                            <label for="s_email" class="form-label">อีเมล</label>
                                            <input type="email" class="form-control" id="s_email" name="s_email"
                                                value="<?php echo $fetch_student['s_email']; ?>" required>
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
                                            <img src="information_file/profile/<?php echo $fetch_student['s_pic']; ?>"
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
</body>
<!--end::Body-->

</html>

<?php } ?>