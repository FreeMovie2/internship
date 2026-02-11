<?php
    session_start();
    include("connect/connect.php");
    include("component/function.php");
    if(!isset($_SESSION['s_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
        $sql_parent->bind_param("s", $_SESSION["s_id"]);
        $sql_parent->execute();
        $result_parent = $sql_parent->get_result();
        $fetch_parent = $result_parent->fetch_assoc();

        $sql_province = "SELECT * FROM th_province order by CONVERT( name_th USING tis620 ) ASC";
        $query_province = mysqli_query($conn,$sql_province);
        $sql_district = "SELECT * FROM th_district where province_id = '".$fetch_parent['p_province']."' order by CONVERT( name_th USING tis620 ) ASC";
        $query_district = mysqli_query($conn,$sql_district);
        $sql_subdistrict = "SELECT * FROM th_subdistrict where district_id = '".$fetch_parent['p_aumpher']."' order by CONVERT( name_th USING tis620 ) ASC";
        $query_subdistrict = mysqli_query($conn,$sql_subdistrict); 
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
                        <div class="col-12">
                            <h3 class="mb-0">แก้ไขข้อมูลผู้ปกครอง/บุคคลใกล้ชิด/เพื่อนสนิท</h3>
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
                                    <h3 class="card-title">แก้ไขข้อมูลผู้ปกครอง/ผู้ที่เกี่ยวข้อง</h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        AlertBox();
                                    ?>
                                    <form action="process/edit_parent.php" method="POST" enctype="multipart/form-data">
                                        <!-- ข้อมูลส่วนตัว -->

                                        <div class="mb-3 d-none"> 
                                            <input type="text" class="form-control" id="s_id" name="s_id"
                                                value="<?php echo $_SESSION['s_id']; ?>" readonly
                                            >
                                        </div>

                                        <h4>1. แก้ไขข้อมูลผู้ปกครอง</h4>
                                        <h5>1.1) ข้อมูลบิดา</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล บิดา</label>
                                            <input type="text" class="form-control" id="p_dad" name="p_dad"
                                                value="<?php echo $fetch_parent['p_dad']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ บิดา</label>
                                            <input type="number" class="form-control" id="p_dad_age" name="p_dad_age"
                                                value="<?php echo $fetch_parent['p_dad_age']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อาชีพ บิดา</label>
                                            <input type="text" class="form-control" id="p_dad_position" name="p_dad_position"
                                                value="<?php echo $fetch_parent['p_dad_position']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">เบอร์โทรศัพท์ บิดา</label>
                                            <input type="text" class="form-control" id="p_dad_tel" name="p_dad_tel"
                                                value="<?php echo $fetch_parent['p_dad_tel']; ?>" required
                                            >
                                        </div>

                                        


                                        <h5>1.2) ข้อมูลบิดา</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล มารดา</label>
                                            <input type="text" class="form-control" id="p_mom" name="p_mom"
                                                value="<?php echo $fetch_parent['p_mom']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ มารดา</label>
                                            <input type="number" class="form-control" id="p_mom_age" name="p_mom_age"
                                                value="<?php echo $fetch_parent['p_mom_age']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อาชีพ มารดา</label>
                                            <input type="text" class="form-control" id="p_mom_position" name="p_mom_position"
                                                value="<?php echo $fetch_parent['p_mom_position']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">เบอร์โทรศัพท์ มารดา</label>
                                            <input type="text" class="form-control" id="p_mom_tel" name="p_mom_tel"
                                                value="<?php echo $fetch_parent['p_mom_tel']; ?>" required
                                            >
                                        </div>


                                        <h5>1.3) ข้อมูลผู้ปกครอง</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล ผู้ปกครอง</label>
                                            <input type="text" class="form-control" id="p_parent" name="p_parent"
                                                value="<?php echo $fetch_parent['p_parent']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ ผู้ปกครอง</label>
                                            <input type="number" class="form-control" id="p_parent_age" name="p_parent_age"
                                                value="<?php echo $fetch_parent['p_parent_age']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อาชีพ ผู้ปกครอง</label>
                                            <input type="text" class="form-control" id="p_parent_position" name="p_parent_position"
                                                value="<?php echo $fetch_parent['p_parent_position']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">เบอร์โทรศัพท์ ผู้ปกครอง</label>
                                            <input type="text" class="form-control" id="p_parent_tel" name="p_parent_tel"
                                                value="<?php echo $fetch_parent['p_parent_tel']; ?>" required
                                            >
                                        </div>

                                        <h4>2. แก้ไขข้อมูลเพื่อนสนิท</h4>
                                        <h5>2.1) เพื่อนสนิทคนที่ 1</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล เพื่อนสนิทคนที่ 1</label>
                                            <input type="text" class="form-control" id="p_friend1" name="p_friend1"
                                                value="<?php echo $fetch_parent['p_friend1']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ เพื่อนสนิทคนที่ 1</label>
                                            <input type="number" class="form-control" id="p_friend1_age" name="p_friend1_age"
                                                value="<?php echo $fetch_parent['p_friend1_age']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อาชีพ เพื่อนสนิทคนที่ 1</label>
                                            <input type="text" class="form-control" id="p_friend1_position" name="p_friend1_position"
                                                value="<?php echo $fetch_parent['p_friend1_position']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">เบอร์โทรศัพท์ เพื่อนสนิทคนที่ 1</label>
                                            <input type="text" class="form-control" id="p_friend1_tel" name="p_friend1_tel"
                                                value="<?php echo $fetch_parent['p_friend1_tel']; ?>" required
                                            >
                                        </div>

                                        <h5>2.2) เพื่อนสนิทคนที่ 2</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล เพื่อนสนิทคนที่ 2</label>
                                            <input type="text" class="form-control" id="p_friend2" name="p_friend2"
                                                value="<?php echo $fetch_parent['p_friend2']; ?>"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ เพื่อนสนิทคนที่ 2</label>
                                            <input type="number" class="form-control" id="p_friend2_age" name="p_friend2_age"
                                                value="<?php echo $fetch_parent['p_friend2_age']; ?>"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อาชีพ เพื่อนสนิทคนที่ 2</label>
                                            <input type="text" class="form-control" id="p_friend2_position" name="p_friend2_position"
                                                value="<?php echo $fetch_parent['p_friend2_position']; ?>"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">เบอร์โทรศัพท์ เพื่อนสนิทคนที่ 2</label>
                                            <input type="text" class="form-control" id="p_friend2_tel" name="p_friend2_tel"
                                                value="<?php echo $fetch_parent['p_friend2_tel']; ?>"
                                            >
                                        </div>




                                        
                                        

                                        

                                        <!-- ที่อยู่ -->
                                        <h4>3. บุคคลใกล้ชิดที่ติดต่อได้</h4>
                                        <h5>3.1) ข้อมูลทั่วไป</h5>
                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">ชื่อ-นามสกุล</label>
                                            <input type="text" class="form-control" id="p_close" name="p_close"
                                                value="<?php echo $fetch_parent['p_close']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">อายุ</label>
                                            <input type="number" class="form-control" id="p_close_age" name="p_close_age"
                                                value="<?php echo $fetch_parent['p_close_age']; ?>" required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label for="s_name" class="form-label">มีความเกี่ยวข้องเป็น
                                            </label>
                                            <input type="text" class="form-control" id="p_close_relation" name="p_close_relation"
                                                value="<?php echo $fetch_parent['p_close_relation']; ?>" required
                                            >
                                        </div>

                                        <h5>3.2) ข้อมูลที่อยู่</h5>

                                        <div>
                                            <div class="mb-3">
                                                <label for="s_home1" class="form-label">เลขที่</label>
                                                <input type="text" class="form-control"  name="p_home"
                                                    value="<?php echo $fetch_parent['p_home']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_moo1" class="form-label">หมู่ที่</label>
                                                <input type="text" class="form-control" name="p_moo"
                                                    value="<?php echo $fetch_parent['p_moo']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_soi1" class="form-label">ตรอก/ซอย</label>
                                                <input type="text" class="form-control" name="p_soi"
                                                    value="<?php echo $fetch_parent['p_soi']; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="s_road1" class="form-label">ถนน</label>
                                                <input type="text" class="form-control" name="p_road"
                                                    value="<?php echo $fetch_parent['p_road']; ?>" required>
                                            </div>


                                            <div class="form-group mb-3">
                                                <label class="form-label">จังหวัด</label>
                                                <select class="form-control" id="province_id" name="p_province" required>
                                                    <option value="">เลือกจังหวัด</option>
                                                    <?php while ($province = mysqli_fetch_array($query_province)) { ?>
                                                    <option
                                                        <?= ($fetch_parent['p_province'] == $province['province_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $province['province_id'] ?>">
                                                        <?php echo $province['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">อำเภอ</label>
                                                <select class="form-control" id="district_id" name="p_aumpher" required>
                                                    <option value="">เลือกอำเภอ</option>
                                                    <?php while ($district = mysqli_fetch_array($query_district)) { ?>
                                                    <option
                                                        <?= ($fetch_parent['p_aumpher'] == $district['district_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $district['district_id'] ?>">
                                                        <?php echo $district['name_th']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label class="form-label">ตำบล</label>
                                                <select class="form-control" id="subdistrict_id" name="p_tumbon"
                                                    required>
                                                    <option value="">เลือกตำบล</option>
                                                    <?php while ($subdistrict = mysqli_fetch_array($query_subdistrict)) { ?>
                                                    <option
                                                        <?= ($fetch_parent['p_tumbon'] == $subdistrict['subdistrict_id']) ? 'selected' : ''; ?>
                                                        value="<?php echo $subdistrict['subdistrict_id'] ?>">
                                                        <?php echo $subdistrict['name_th']; ?></option>
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