<?php
    session_start();
    include("connect/connect.php");
    if(!isset($_SESSION['t_id'])){
        header("Location:login.php");
        exit();
    }else{
        $days = ["อาทิตย์","จันทร์", "อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"];
        $days_eng = ["Sunday","Monday", "Tuesday", "Wednesday", "Thursday", "Friday","Saturday"];
        
?>
<?php
    if(isset($_GET['news_id'])){
        $n_id = filter_input(INPUT_GET , 'news_id');
        $sql_news = $conn->prepare("SELECT * FROM news_teacher WHERE n_id = ?");
        $sql_news->bind_param("s", $n_id);
        $sql_news->execute();
        $result_news = $sql_news->get_result();
        $fetch_news = $result_news->fetch_assoc();

        function FetchTeacher($teacher_id, $conn){
            $sql_teacher = $conn->prepare("SELECT * FROM teachers where t_id = ?");
            $sql_teacher->bind_param("i",$teacher_id);
            $sql_teacher->execute();
            $result_teacher = $sql_teacher->get_result();
            $fetch_teacher = $result_teacher->fetch_assoc();
            return $fetch_teacher['t_prefix'].$fetch_teacher['t_name']." ".$fetch_teacher['t_surname'];
        }
    
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
                        <div class="col-sm-6">
                            <h3 class="mb-0">ข่าวประชาสัมพันธ์</h3>
                        </div>
                      
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content Header--> <!--begin::App Content-->
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
             
                    <div class="row"> <!-- Start col -->
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title"><?php echo $fetch_news['n_name']; ?></h3>
                                </div>
                                <div class="card-body">
                                    <p><b><i class="bi bi-person"></i> ผู้เขียน : </b><?php echo FetchTeacher($fetch_news['n_author'],$conn); ?></p>
                                    <?php 
                                        if($fetch_news['n_pic'] != "default.pdf"){                       
                                    ?>
                                        <p><b><i class="bi bi-download"></i> ดาวน์โหลดไฟล์ : </b><a href="uploaded/news_resources/<?php echo $fetch_news['n_pic']; ?>" class="">ดาวน์โหลด</a></p>
                                        
                                    <?php } ?>
                                    <p class="text-justify"><?php echo $fetch_news['n_detail']; ?></p>
                                </div>
                            </div> <!-- /.card --> <!-- DIRECT CHAT -->
                            
                        </div> 
                    </div> <!-- /.row (main row) -->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> 
        <?php
            include("component/footer.php");
        ?>
    </div> <!--end::App Wrapper--> 
    <?php
        include("component/script.php");
    ?>
</body><!--end::Body-->

</html>

<?php } ?>
<?php } ?>