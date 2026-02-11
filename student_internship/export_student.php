<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }
    $sql = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql->bind_param("s", $_SESSION["s_id"]);
    $sql->execute();
    $result = $sql->get_result();
    $fetch_company = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<?php
    include("component/header_print.php");
?>

<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์" onclick="window.print();" />
    </form>
    <div class="page">
        <div class="subpage">
            <p class="text-center" style="margin-bottom: 120px;">ประทับตราสถานประกอบการ</p>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <p>........................</p>
                    </div>
                    <div class="col-4">
                        <p></p>
                    </div>
                    <div class="col-4">
                        <p><?php echo $fetch_company['c_name']; ?></p>
                    </div>
                    
                    <div class="col-5"></div>
                    <div class="col-5">
                        <br/>
                        <p class="text-center">......................................................</p>
                        <br/>
                    </div>
                    
                    <div class="col-2"></div>

                    <div class="col-12">
                        <p>เรียน&nbsp;&nbsp;ผู้อำนวยการวิทยาลัยเทคนิคฉะเชิงเทรา</p>
                        <p>เรื่อง&nbsp;&nbsp;ขอส่งตัวนักศึกษาฝึกอาชีพกลับสถานศึกษา</p>
                        <p>สิ่งที่ส่งมาด้วย&nbsp;&nbsp;แบบประเมินผลการฝึกอาชีพ</p>
                        <br/>
                        <p class="text-justify">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            ตามที่วิทยาลัยเทคนิคฉะเชิงเทราได้ส่ง <?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?> 
                            นักศึกษาชั้น <?php echo $_SESSION["s_year"]; ?> สาขาวิชา  <?php echo $_SESSION["s_major"]; ?>มาปฏิบัตการฝึกอาชีพ ณ <?php echo $fetch_company['c_name']; ?> 
                            ตั้งแต่วันที่ <?php echo $fetch_company['c_start']; ?>
                            ถึง วันที่  <?php echo $fetch_company['c_end']; ?> ซึ่งนักศึกษาดังกล่าวได้ฝึกอาชีพในสถานประกอบการในด้าน  <?php echo $fetch_company['c_position']; ?>
                            มีผลการฝึกอาชีพอยู่ในระดับ........................และได้รับคะแนนการปฏิบัติฝึกอาขีพ ตามแบบประเมินการฝึกอาชีพเป็น............คะแนน 
                        </p>
                        <br/>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            จึงเรียนมาเพื่อโปรดทราบ 
                        </p>
                    </div>

                    <div class="col-5"></div>
                    <div class="col-5">
                        <p class="text-center">ขอแสดงความนับถือ</p>
                        <br>
                        <br>
                        <br>
                        <p class="text-center">(........................................)</p>
                        <p class="text-center">ตำแหน่ง.......................................................</p>
                    </div>
                   
                    <div class="col-2"></div>
                </div>
            </div>
        
            <br/>

            

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


</body>

</html>