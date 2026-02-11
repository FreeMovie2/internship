<?php
    function ThDate(){
        //เดือนภาษาไทย
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        
        //กำหนดคุณสมบัติ
        $week = date( "w" ); // ค่าวันในสัปดาห์ (0-6)
        $months = date( "m" )-1; // ค่าเดือน (1-12)
        $day = date( "d" ); // ค่าวันที่(1-31)
        $years = date( "Y" )+543; // ค่า ค.ศ.บวก 543 ทำให้เป็น ค.ศ.
        
        return "วันที่ $day $ThMonth[$months] พ.ศ. $years";
    }

    function AlertBox(){
        if (isset($_GET['status']) && $_GET['status'] == 'error') {
            echo '<div class="callout callout-danger mb-3">
                    Username หรือ Password ไม่ถูกต้อง !        
            </div>';
        }elseif(isset($_GET['status']) && $_GET['status'] == 'error_img'){
            echo '<div class="callout callout-danger mb-3">
                รองรับเฉพาะไฟล์ภาพ ()        
            </div>';
        }elseif(isset($_GET['status']) && $_GET['status'] == 'success'){
            echo '<div class="callout callout-success mb-3">
                    บันทึกข้อมูลเรียบร้อยแล้ว !        
            </div>';
        }else{
           
        }
    }

    function ConvertToThaiDate($date_stater){
       $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
       $date_arr = explode("/",$date_stater);
       $day = (int)$date_arr[0];
       $month = (int)$date_arr[1];
       $year = (int)$date_arr[2];
       $bd_year = $year+543;
       $convert = "วันที่ ".$day." เดือน ".$ThMonth[$month-1]." พ.ศ.".$bd_year;
       return $convert;
    }

    function ConvertToThaiDateFull($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $full_date = "วันที่ ".$day." เดือน ".$ThMonth[$month-1]." พ.ศ.".$year+543;
        return $full_date;
    }

    function ConvertToThaiDateShort($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $short_date = $day." ".$ThMonth[$month-1]." ".$year+543;
        return $short_date;
    }

    function ConvertToThaiDateSplit($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $split_date = $day."/".$ThMonth[$month-1]."/".$year+543;
        return $split_date;
    }

    function ConvertToThaiDateSplit2($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $split_date2 = $day."/".$month."/".$year+543;
        return $split_date2;
    }
   function ConvertToThaiDateSplit3($date_starter) {
    if (!$date_starter) return "";

    $date_arr = explode("/", $date_starter);

    // กรณี explode ไม่ได้ (กัน error เผื่อ)
    if (count($date_arr) < 3) return $date_starter;

    $day = (int)$date_arr[0];
    $month = (int)$date_arr[1];
    $year = (int)$date_arr[2];

    return $day . "/" . $month . "/" . ($year + 543);
}


 
?>