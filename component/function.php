<?php
    // Years above 2400 are already B.E. (พ.ศ.); smaller ones are C.E. Avoids adding 543 twice.
    function toBuddhistYear($year){
        return $year > 2400 ? $year : $year + 543;
    }
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
       $bd_year = toBuddhistYear($year);
       $convert = "วันที่ ".$day." เดือน ".$ThMonth[$month-1]." พ.ศ.".$bd_year;
       return $convert;
    }

    function ConvertToThaiDateFull($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $full_date = "วันที่ ".$day." เดือน ".$ThMonth[$month-1]." พ.ศ.".toBuddhistYear($year);
        return $full_date;
    }

    function ConvertToThaiDateShort($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $short_date = $day." ".$ThMonth[$month-1]." ".toBuddhistYear($year);
        return $short_date;
    }

    function ConvertToThaiDateSplit($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $split_date = $day."/".$ThMonth[$month-1]."/".toBuddhistYear($year);
        return $split_date;
    }

    function ConvertToThaiDateSplit2($date_starter){
        $ThMonth = array ( "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน","พฤษภาคม", "มิถุนายน", "กรกฏาคม", "สิงหาคม","กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม" );
        $date_arr = explode("/",$date_starter);
        $day = (int)$date_arr[0];
        $month = (int)$date_arr[1];
        $year = (int)$date_arr[2];
        $split_date2 = $day."/".$month."/".toBuddhistYear($year);
        return $split_date2;
    }


 
?>