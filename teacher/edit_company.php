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

            $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
            $sql_company->bind_param("s", $s_id);
            $sql_company->execute();
            $result_company = $sql_company->get_result();
            $fetch_company = $result_company->fetch_assoc();

            $sql_teacher = $conn->prepare("SELECT * FROM teachers WHERE t_status = ?");
            $role = "U";
            $sql_teacher->bind_param("s", $role);
            $sql_teacher->execute();
            $result_teacher = $sql_teacher->get_result();

            $sql_teacher2 = $conn->prepare("SELECT * FROM teachers WHERE t_status = ?");
            $role2 = "U";
            $sql_teacher2->bind_param("s", $role2);
            $sql_teacher2->execute();
            $result_teacher2 = $sql_teacher2->get_result();
            


            $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
            $query_province = mysqli_query($conn,$sql_province);
            $sql_district = "SELECT * FROM th_district where province_id = '".$fetch_company['c_province']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_district = mysqli_query($conn,$sql_district);
            $sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '".$fetch_company['c_aumpher']."' order by CONVERT( name_th USING tis620 ) ASC";
            $query_subdistrict = mysqli_query($conn,$sql_subdistrict); 

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<?php
    include("component/header.php");
?>

<style>
.custom-select-container {
    position: relative;
}

.custom-dropdown {
    position: absolute;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
    z-index: 1000;
    display: none;
}

.custom-dropdown .dropdown-item {
    padding: 8px 12px;
    cursor: pointer;
}

.custom-dropdown .dropdown-item:hover {
    background-color: #f1f1f1;
}

.search-input {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
    padding: 8px;
    box-sizing: border-box;
}

.search-input:focus {
    outline: none;
    border-bottom: 1px solid #007bff;
}

.custom-select-container2 {
    position: relative;
}

.custom-dropdown2 {
    position: absolute;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: #fff;
    z-index: 1000;
    display: none;
}

.custom-dropdown2 .dropdown-item2 {
    padding: 8px 12px;
    cursor: pointer;
}

.custom-dropdown2 .dropdown-item2:hover {
    background-color: #f1f1f1;
}

.search-input2 {
    width: 100%;
    border: none;
    border-bottom: 1px solid #ccc;
    padding: 8px;
    box-sizing: border-box;
}

.search-input2:focus {
    outline: none;
    border-bottom: 1px solid #007bff;
}

.custom-dropdown2 {
    display: none;
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    z-index: 1000;
}

.custom-dropdown2.show {
    display: block;
}

.dropdown-item2 {
    padding: 10px;
    cursor: pointer;
}

.dropdown-item2:hover {
    background-color: #f0f0f0;
}

.dropdown-item2.selected {
    background-color: #007bff;
    color: white;
}
</style>

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
                            <h3 class="mb-0">แก้ไขข้อมูลสถานที่ฝึกอาชีพ</h3>
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
                                    <h3 class="card-title">แก้ไขข้อมูลสถานที่ฝึกอาชีพ</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <form action="process/edit_company.php" method="POST" enctype="multipart/form-data">
                                        <!-- ข้อมูลส่วนตัว -->

                                        <div class="mb-3 d-none">
                                            <input type="text" class="form-control" id="s_id" name="s_id"
                                                value="<?php echo $s_id; ?>" readonly>
                                        </div>

                                        <h4>1. แก้ไขข้อมูลสถานประกอบการ</h4>
                                        <div class="mb-3">
                                            <label for="c_name" class="form-label">ชื่อ-สถานประกอบการ</label>
                                            <input type="text" class="form-control" id="p_dad" name="p_dad"
                                                value="<?php echo $fetch_company['c_name']; ?>" required>
                                        </div>


                                        <div>
                                            <div class="mb-3">
                                                <label for="c_home" class="form-label">ที่ตั้งเลขที่</label>
                                                <input type="text" class="form-control" name="c_home"
                                                    value="<?php echo $fetch_company['c_home']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="c_moo" class="form-label">หมู่ที่</label>
                                                <input type="text" class="form-control" name="c_moo"
                                                    value="<?php echo $fetch_company['c_moo']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="c_soi" class="form-label">ตรอก/ซอย</label>
                                                <input type="text" class="form-control" name="c_soi"
                                                    value="<?php echo $fetch_company['c_soi']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="c_road" class="form-label">ถนน</label>
                                                <input type="text" class="form-control" name="c_road"
                                                    value="<?php echo $fetch_company['c_road']; ?>" required>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label class="form-label">จังหวัด</label>
                                                <select class="form-control" id="province_id" name="c_province"
                                                    required>
                                                    <option value="">เลือกจังหวัด</option>
                                                    <?php while ($province = mysqli_fetch_array($query_province)) { ?>
                                                    <option
                                                        <?= ($fetch_company['c_province'] == $province['province_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $province['province_id'] ?>">
                                                        <?php echo $province['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">อำเภอ</label>
                                                <select class="form-control" id="district_id" name="c_aumpher" required>
                                                    <option value="">เลือกอำเภอ</option>
                                                    <?php while ($district = mysqli_fetch_array($query_district)) { ?>
                                                    <option
                                                        <?= ($fetch_company['c_aumpher'] == $district['district_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $district['district_id'] ?>">
                                                        <?php echo $district['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">ตำบล</label>
                                                <select class="form-control" id="subdistrict_id" name="c_tumbon"
                                                    required>
                                                    <option value="">เลือกตำบล</option>
                                                    <?php while ($subdistrict = mysqli_fetch_array($query_subdistrict)) { ?>
                                                    <option
                                                        <?= ($fetch_company['c_tumbon'] == $subdistrict['subdistrict_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $subdistrict['subdistrict_id'] ?>">
                                                        <?php echo $subdistrict['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_tel2" class="form-label">โทรศัพท์</label>
                                            <input type="text" class="form-control" name="c_tel"
                                                value="<?php echo $fetch_company['c_tel']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_tel2" class="form-label">โทรสาร</label>
                                            <input type="text" class="form-control" name="c_tel2"
                                                value="<?php echo $fetch_company['c_tel2']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_website" class="form-label">เว็ปไซต์</label>
                                            <input type="text" class="form-control" name="c_website"
                                                value="<?php echo $fetch_company['c_website']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_similar"
                                                class="form-label">สถานที่อยู่ใกล้เคียงและสังเกตุได้ง่าย</label>
                                            <input type="text" class="form-control" name="c_similar"
                                                value="<?php echo $fetch_company['c_similar']; ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_map"
                                                class="form-label">อัพโหลดรูปภาพแผนที่ตั้งสถานประกอบการ</label>
                                            <?php
                                                if($fetch_company['c_map'] != ""){
                                            ?>
                                            <br />
                                            <img src="../student_internship/information_file/company/<?php echo $fetch_company['c_map']; ?>"
                                                class="img-fluid w-25 mb-3" />

                                            <?php }else{ ?>
                                            <br />
                                            <img src="assets/img/no_img.jpg" class="img-fluid w-25 mb-3" />
                                            <?php } ?>
                                            <input class="form-control" type="file" id="formFile" name="c_map">
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_map"
                                                class="form-label">อัพโหลดรูปภาพโครงสร้างตำแหน่งงานสถานประกอบการ</label>
                                            <?php
                                                if($fetch_company['c_org'] != ""){
                                            ?>
                                            <br />
                                            <img src="../student_internship/information_file/company/<?php echo $fetch_company['c_org']; ?>"
                                                class="img-fluid w-25 mb-3" />

                                            <?php }else{ ?>
                                            <br />
                                            <img src="assets/img/no_img.jpg" class="img-fluid w-25 mb-3" />
                                            <?php } ?>
                                            <input class="form-control" type="file" id="formFile" name="c_org">
                                        </div>

                                        <h4>2. ข้อมูลครูผู้รับผิดชอบ/ประสานงาน</h4>

                                        <div class="mb-3">
                                            <label for="c_head" class="form-label">หน้าแผนก ชื่อ สกุล
                                                (สามารถเว้นไว้ก่อนได้)</label>
                                            <input type="text" class="form-control" name="c_head"
                                                value="<?php echo $fetch_company['c_head']; ?>">
                                        </div>

                                        <label for="c_advice" class="form-label">ครูที่ปรึกษา</label>
                                        <div class="custom-select-container">
                                            <button class="form-select text-start" id="customSelectButton"
                                                type="button">
                                                <?php
                                                    if($fetch_company['c_advice'] == ""){
                                                ?>
                                                    เลือกชื่อครูที่ปรึกษา
                                                <?php }else ?>
                                                    <?php
                                                        $sql_current = $conn->prepare("SELECT * FROM teachers WHERE t_id = ?");
                                                        $sql_current->bind_param("s", $fetch_company['c_advice']);
                                                        $sql_current->execute();
                                                        $result_current = $sql_current->get_result();
                                                        $fetch_current = $result_current->fetch_assoc();

                                                        echo $fetch_current['t_prefix'].$fetch_current['t_name']." ".$fetch_current['t_surname'];
                                                    ?>

                                                <?php ?>
                                            </button>
                                            <div class="custom-dropdown" id="customDropdown">
                                                <input type="text" class="search-input" id="dropdownSearch"
                                                    placeholder="ค้นหาชื่อครู..." />
                                                <?php while($fetch_teacher = $result_teacher->fetch_assoc()) { ?>
                                                <div class="dropdown-item"
                                                    data-value="<?php echo $fetch_teacher['t_id']; ?>">
                                                    <?php echo $fetch_teacher['t_prefix'].$fetch_teacher['t_name']." ".$fetch_teacher['t_surname']; ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <input type="hidden" name="c_advice" id="selectedTeacherId" />
                                        </div>


                                        <label for="c_map" class="form-label mt-3">ครูนิเทศ</label>

                                        <div class="custom-select-container">
                                            <button class="form-select text-start" id="customSelectButton2"
                                                type="button">
                                                <?php
                                                    if($fetch_company['c_advice2'] == ""){
                                                ?>
                                                    เลือกชื่อครูนิเทศ
                                                <?php }else ?>
                                                    <?php
                                                        $sql_current2 = $conn->prepare("SELECT * FROM teachers WHERE t_id = ?");
                                                        $sql_current2->bind_param("s", $fetch_company['c_advice2']);
                                                        $sql_current2->execute();
                                                        $result_current2 = $sql_current2->get_result();
                                                        $fetch_current2 = $result_current2->fetch_assoc();

                                                        echo $fetch_current2['t_prefix'].$fetch_current2['t_name']." ".$fetch_current2['t_surname'];
                                                    ?>

                                                <?php ?>
                                            </button>
                                            <div class="custom-dropdown2" id="customDropdown2">
                                                <input type="text" class="search-input2" id="dropdownSearch2"
                                                    placeholder="ค้นหาชื่อครู..." />
                                                <?php while($fetch_teacher2 = $result_teacher2->fetch_assoc()) { ?>
                                                <div class="dropdown-item2"
                                                    data-value="<?php echo $fetch_teacher2['t_id']; ?>">
                                                    <?php echo $fetch_teacher2['t_prefix'].$fetch_teacher2['t_name']." ".$fetch_teacher2['t_surname']; ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <input type="hidden" name="c_advice2" id="selectedTeacherId2" />
                                        </div>






                                        <h4 class="mt-3">3. ระยะการฝึกอาชีพ</h4>
                                        <div class="mb-3">
                                            <label for="c_start" class="form-label">เริ่มต้น (ที่กรอกไว้
                                                <?php echo $fetch_company['c_start']; ?>)</label>
                                            <input type="text" id="buddhistDate_1" class="form-control buddhist-date-picker" name="c_start" 
                                            value="<?php echo ConvertToThaiDateSplit2($fetch_company['c_start']); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="c_end" class="form-label">สิ้นสุด (ที่กรอกไว้
                                                <?php echo $fetch_company['c_end']; ?>)</label>
                                            <input type="text" id="buddhistDate_2" class="form-control buddhist-date-picker" name="c_end"
                                            value="<?php echo ConvertToThaiDateSplit2($fetch_company['c_end']); ?>">
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
<?php } ?>