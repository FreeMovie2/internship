<?php
    session_start();
    include("connect/connect.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $sql_news = $conn->prepare("SELECT * FROM news ORDER BY n_id ASC");
        $sql_news->execute();
        $result_news = $sql_news->get_result();
        
        // $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
        // $sql_company->bind_param("s", $_SESSION["s_id"]);
        // $sql_company->execute();
        // $result_company = $sql_company->get_result();
        // $fetch_company = $result_company->fetch_assoc();

        $sql_student = $conn->prepare("SELECT * FROM students ORDER BY s_id ASC");
        $sql_student->execute();
        $result_student = $sql_student->get_result();
        $num_students = $result_student->num_rows;

        $sql_teacher = $conn->prepare("SELECT * FROM teachers ORDER BY t_id ASC");
        $sql_teacher->execute();
        $result_teacher = $sql_teacher->get_result();
        $num_teachers = $result_teacher->num_rows;
        $fetch_teacher = $result_teacher->fetch_assoc();


        $stmt_men = $conn->prepare("SELECT * FROM students WHERE s_prefix = 'นาย'");
        $stmt_men->execute();
        $result_men = $stmt_men->get_result();
        $num_men = $result_men->num_rows;

        $stmt_women = $conn->prepare("SELECT * FROM students WHERE s_prefix = 'นาง'");
        $stmt_women->execute();
        $result_women = $stmt_women->get_result();
        $num_women = $result_women->num_rows;

        function FetchProvince($province_id, $conn){
            $sql_province = $conn->prepare("SELECT * FROM th_province where province_id = ?");
            $sql_province->bind_param("i",$province_id);
            $sql_province->execute();
            $result_province = $sql_province->get_result();
            $fetch_province = $result_province->fetch_assoc();
            return $fetch_province['name_th'];
        }
        
        //นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ 
        $datesave = ['ผู้ชาย','ผู้หญิง'];
        $total = [$num_men, $num_women];

        //ตัด commar อันสุดท้ายโดยใช้ implode เพื่อให้โครงสร้างข้อมูลถูกต้องก่อนจะนำไปแสดงบนกราฟ
        $datesave = implode(",", $datesave); 
        $total = implode(",", $total); 

        $stmt = $conn->prepare("SELECT c_province AS province,
        COUNT(c_id) AS total_ids
        FROM 
            company
        GROUP BY 
            c_province
        ORDER BY 
            total_ids DESC;");
        $stmt->execute();
        $resultset = $stmt->get_result();
        $result = $resultset->fetch_all(MYSQLI_ASSOC);
        
        // นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมูลให้ถูกโครงสร้างของกราฟที่ใช้ 
        $province_names = array();
        $total_ids = array();
        
        foreach ($result as $rs) {
            $province_names[] = "\"" . FetchProvince($rs['province'], $conn) . "\""; // ดึงค่าจากคอลัมน์ province
            $total_ids[] = $rs['total_ids']; // ดึงค่าจากคอลัมน์ total_ids
        }
        
        // ตัด comma อันสุดท้ายโดยใช้ implode เพื่อให้โครงสร้างข้อมูลถูกต้องก่อนจะนำไปแสดงบนกราฟ
        $province_names = implode(",", $province_names); 
        $total_ids = implode(",", $total_ids); 


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
                        <div class="col-12">
                            <h3 class="mb-0">สถิติการฝึกอาชีพของ วิทยาลัยเทคนิคฉะเชิงเทรา</h3>
                        </div>
                      
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->


            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                        <div class="col-lg-6 col-md-6 col-12"> <!--begin::Small Box Widget 1-->
                            <div class="small-box text-light" style="background: #EF172D !important; background: linear-gradient(135deg, #EF172D, #E84A3C) !important;">
                                <div class="inner">
                                    <h3 class="mb-0"><?php echo $num_students;?><sup class="fs-5"> คน</sup></h3>
                                    <p>จำนวนนักเรียนในระบบ</p>
                                </div> 
                            </div> <!--end::Small Box Widget 1-->
                        </div> <!--end::Col-->
                        <div class="col-lg-6 col-md-6 col-12"> <!--begin::Small Box Widget 2-->
                            <div class="small-box text-light" style="background: #FF3835;background: linear-gradient(135deg, #FF3835, #E87B9D);">
                                <div class="inner">
                                    <h3 class="mb-0"><?php echo $num_teachers;?><sup class="fs-5"> คน</sup></h3>
                                    <p>จำนวนครูในระบบ</p>
                                </div> 
                                
                            </div> <!--end::Small Box Widget 2-->
                        </div> <!--end::Col-->

                    </div> <!--end::Row--> <!--begin::Row-->
                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-light">
                                    <h3 class="card-title">สถิติการฝึกอาชีพของ วิทยาลัยเทคนิคฉะเชิงเทรา</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <canvas id="myChart" width=100%" height="50%"></canvas>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <canvas id="myChart2" width=100%" height="50%"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- /.card --> <!-- DIRECT CHAT -->
                            
                        </div> 
                    </div> <!-- /.row (main row) -->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->

            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->

                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header bg-danger text-light">
                                    <h3 class="card-title">ดูบันทึกการฝึกอาชีพของนักเรียน</h3>
                                </div>
                                <div class="card-body">








                                    <table id="myTable" class="display">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ลำดับที่</th>
                                                <th>ชื่อ-สกุล</th>
                                                <th>ชั้น</th>
                                                <th>บันทึกฝึกอาชีพ</th>
                                               



                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i =1; ?>
                                            <?php while($fetch_student = $result_student->fetch_assoc()){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i++; ?></td>
                                                <td>
                                                    <?php echo $fetch_student['s_prefix'].$fetch_student['s_name']." ".$fetch_student['s_surname']; ?>
                                                    <br/>
                                                    เลขประจำตัว <?php echo $fetch_student['s_student_id']; ?>
                                                    <?php
                                                        $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
                                                        $sql_company->bind_param("s", $fetch_student['s_id']);
                                                        $sql_company->execute();
                                                        $result_company = $sql_company->get_result();
                                                        $fetch_company = $result_company->fetch_assoc();

                                                        $sql_parent  = $conn->prepare("SELECT * FROM parent_information WHERE s_id = ?");
                                                        $sql_parent->bind_param("s", $fetch_student['s_id']);
                                                        $sql_parent->execute();
                                                        $result_parent = $sql_parent->get_result();
                                                        $fetch_parent = $result_parent->fetch_assoc();
                                                    ?>

                                                    <?php if($fetch_student['s_update_information'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลส่วนตัว</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลส่วนตัวแล้ว</p>
                                                    <?php }?>

                                                    <?php if($fetch_parent['p_update_status'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลผู้ปกครอง/บุคคลใกล้ชิด</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลผู้ปกครอง/บุคคลใกล้ชิดแล้ว</p>
                                                    <?php }?>

                                                    <?php if($fetch_company['c_update_status'] == 'N'){?>
                                                        <p class="text-danger mb-0"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้อัพเดทข้อมูลสถานประกอบการ</p>
                                                    <?php }else{ ?>
                                                        <p class="text-success mb-0"><i class="bi bi-check-circle-fill"></i> อัพเดทข้อมูลสถานประกอบการแล้ว</p>
                                                    <?php }?>
                                                </td>
                                                <td><?php echo $fetch_student['s_year']; ?></td>
                                                <td>
                                                    <a href="export_book.php?student_id=<?php echo $fetch_student['s_id']; ?>"
                                                        class="btn btn-info w-100"> <i class="bi bi-book"></i>
                                                        แบบบันทึก</a>
                                                </td>

                             













                                            </tr>

                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card -->
                            <!-- DIRECT CHAT -->

                        </div>
                    </div> <!-- /.row (main row) -->
                </div>
                <!--end::Container-->
            </div>
        </main> <!--end::App Main--> 
        <?php
            include("component/footer.php");
        ?>
    </div> <!--end::App Wrapper--> 

    <?php
        include("component/script.php");
    ?>
        <script>
              var ctx = document.getElementById("myChart").getContext('2d');
              var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ["ชาย", "หญิง"
                  
                      ],
                      datasets: [{
                          label: 'จำนวนนักเรียนฝึกอาชีพแยกตามเพศ',
                          data: [<?php echo $total;?>
                          ],
                          backgroundColor: [
                              'rgba(255, 99, 132, 0.2)',
                              'rgba(54, 162, 235, 0.2)',
                          ],
                          borderColor: [
                              'rgba(255,99,132,1)',
                              'rgba(54, 162, 235, 1)',
                          ],
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });

              var ctx2 = document.getElementById("myChart2").getContext('2d');
              var myChart2 = new Chart(ctx2, {
                  type: 'bar',
                  data: {
                      labels: [<?php echo $province_names;?>],
                      datasets: [{
                          label: 'จำนวนจังหวัดของสถานประกอบการ',
                          data: [<?php echo $total_ids;?>
                          ],
                         
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
    </script>
</body><!--end::Body-->

</html>

<?php } ?>