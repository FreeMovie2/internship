<?php
    session_start();
    include 'connect/connect.php';

    if (!isset($_SESSION['s_id'])) {
        header('Location: login.php');
        exit();
    }

    $sql_company = $conn->prepare("SELECT * FROM company WHERE s_id = ?");
    $sql_company->bind_param("s", $_SESSION["s_id"]);
    $sql_company->execute();
    $result_company = $sql_company->get_result();
    $fetch_company = $result_company->fetch_assoc();

    function FetchProvince($province_id, $conn){
        $sql_province = "SELECT * FROM th_province WHERE province_id = '".$province_id."'";
        $query_province = mysqli_query($conn,$sql_province);
        $fetch_province = mysqli_fetch_assoc($query_province);
        return $fetch_province['name_th'];
    }

    function FetchDistrict($distrcit_id, $conn_district){
        $sql_district = $conn_district->prepare("SELECT * FROM th_district where district_id = ?");
        $sql_district->bind_param("i",$distrcit_id);
        $sql_district->execute();
        $result_district = $sql_district->get_result();
        $fetch_aumpher = $result_district->fetch_assoc();
        return $fetch_aumpher['name_th'];
    }

    function FetchSubDistrict($subdistrict_id, $conn_subdistrict){
        $sql_subdistrict = "SELECT * FROM th_subdistrict where subdistrict_id = '".$subdistrict_id."'";
        $query_subdistrict = mysqli_query($conn_subdistrict,$sql_subdistrict);
        $fetch_tumbon =  mysqli_fetch_assoc($query_subdistrict);
        return $fetch_tumbon['name_th'];
    }


?>
<!DOCTYPE html>
<html lang="en">


<?php
    include("component/header_print.php");
?>

<style>
  /* คอนเทนเนอร์หลัก */
  .border-dotted {
    position: relative;
    display: flex; /* ใช้ Flexbox เพื่อจัดให้อยู่ในบรรทัดเดียวกัน */
    align-items: center; /* จัดให้เนื้อหากึ่งกลางแนวตั้ง */
  }

  /* เส้นใต้แบบจุด */
  .border-dotted::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%; /* ขยายเส้นใต้ให้เต็มความกว้าง */
    border-bottom: 1px dotted #000; /* เส้นใต้แบบจุด */
    z-index: 0; /* ทำให้เส้นอยู่ด้านล่าง */
  }

  /* ข้อความภายใน */
  .border-dotted b {
  	background: #fff; 
    position: relative;
    z-index: 1; /* ให้หัวข้ออยู่เหนือเส้นใต้ */
  }

  .border-dotted span {
    position: relative;
    z-index: 1; /* ให้ข้อความอยู่เหนือเส้นใต้ */
  }
  .img-frame{
    border: 1px solid #000;
    padding: 10px;
  }
  p{
    margin-bottom: 3px !important;
  }
</style>


<body>

    <form style="text-align: center;">
        <input class="MyButton" type="button" value="กลับหน้าหลัก" onclick="window.location.href='index.php'" />
        <input class="MyButton2" type="button" value="พิมพ์" onclick="window.print();" />
        
    </form>
    
    <div class="page">
        <div class="subpage">
            <h5 class="text-center" style="font-weight: bold;text-align:center">รายละเอียดสถานประกอบการ</h5>
            <p class="border-dotted">
                <b>ชื่อสถานประกอบการ&nbsp;</b>
                <span>
                    <?php echo $fetch_company["c_name"]; ?>
                </span>
            </p>
            <p class="border-dotted">
                <b>ที่ตั้งเลขที่&nbsp;</b><span><?php echo $fetch_company["c_home"]; ?></span>
                <b>&nbsp;หมูที่&nbsp;</b><span><?php echo $fetch_company["c_moo"]; ?></span>
                <b>&nbsp;ตรอก/ซอย&nbsp;</b><span><?php echo $fetch_company["c_soi"]; ?></span>
                <b>&nbsp;ถนน&nbsp;</b><span><?php echo $fetch_company["c_road"]; ?></span>
            </p>
            <p class="border-dotted">
                <b>ตำบล&nbsp;</b><span><?php echo FetchSubDistrict($fetch_company["c_tumbon"], $conn); ?></span>
                <b>&nbsp;อำเภอ&nbsp;</b><span><?php echo FetchDistrict($fetch_company["c_aumpher"], $conn); ?></span>
                <b>&nbsp;จังหวัด&nbsp;</b><span><?php echo FetchProvince($fetch_company["c_province"], $conn); ?></span>   
            </p>
            <p class="border-dotted">   
                <b>โทรศัพท์&nbsp;</b><span><?php echo $fetch_company["c_tel"]; ?></span>
                <b>&nbsp;โทรสาร&nbsp;</b><span><?php echo $fetch_company["c_tel2"]; ?></span>
                <b>&nbsp;เว็ปไซต์&nbsp;</b><span><?php echo $fetch_company["c_website"]; ?></span>
            </p>
            <p class="border-dotted">  
               <b>สถานที่อยู่ใกล้เคียง และสังเกตได้ง่าย คือ&nbsp;</b><span><?php echo $fetch_company["c_similar"]; ?></span>
            </p>
            <br/>

            <p><b>ชื่อผู้เรียน เข้ารับการฝึกอาชีพ</b></p>
            <p class="border-dotted"> 
                <b>&nbsp;&nbsp;&nbsp;&nbsp;</b><b>1.&nbsp;&nbsp; ชื่อ-สกุล&nbsp;</b> 
                <span><?php echo $_SESSION["s_prefix"].$_SESSION["s_name"]." ".$_SESSION["s_surname"];?></span>  
                <b>&nbsp;แผนกวิชา&nbsp;</b><span><?php echo $fetch_company["c_position"]; ?></span>
            </p>
           
            <br/>

          

        </div>
    </div>

    <div class="page">
        <div class="subpage">
            <p class="text-center"><b>แผนที่ตั้งสถานประกอบการ</b></p>
            <p class="text-center"><img src="information_file/company/<?php echo $fetch_company["c_map"]; ?>" class="ing-fluid img-frame w-75"/></p>

            <p class="text-center mt-5"><b>แผนผังโครงสร้างตำแหน่งงานของสถานประกอบการณ์</b></p>
            <p class="text-center"><img src="information_file/company/<?php echo $fetch_company["c_org"]; ?>" class="ing-fluid img-frame w-75"/></p>
        </div>
    </div>
    


</body>

</html>