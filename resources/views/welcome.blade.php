<!doctype html>
<?php
//INCLUDE File for use class and new instance;
include_once(app_path() . '/frontend/header.php');
include_once(app_path() . '/frontend/menu.php');
include_once(app_path() . '/frontend/media.php');
include_once(app_path() . '/frontend/custom.php');
include_once(app_path() . '/frontend/blog.php');
include_once(app_path() . '/core_function/core.php');
include_once(app_path() . '/frontend/slide.php');

//NEW Instance class for use;
$header = new header();
$menu = new menu();
$media = new media();
$custom = new custom();
$blog = new blog();
$db = new databaseGet();
$sli = new slide();
?>
<html lang="{{ app()->getLocale() }}">
    <head>
        <?php
        $header->getHead("");
        $header->getCss();
        $custom->getCustom('custom_index');
        ?>
    </head>
    <body>
        <?php
        $menu->navbar("");
        $sli->slideView();

        ?>
<?php $blog->blogOn("cid23", "0", "on"); ?>
        <div class="col-sm-12">
            <hr><h1 class="display-4" style="color:#3399FF;"><b>พร้อมให้บริการ ทำงานเป็นทีม ยิ้มแย้มแจ่มใส ใส่ใจคุณภาพ</b> </h1> <hr>
        </div>
        <?php $blog->blogOff(); ?>

        <?php
        $blog->blogOn("cid-qHHI4vdCrx", "0.7", "on");

        $newsUpdate = DB::table('news')->orderBy('create_date_new', 'desc')->where('cat','!=',47)->where('cat','!=',34)->limit(10)->get();
        $newsActivity = DB::table('news')->orderBy('create_date_new', 'desc')->where('cat', 47)->limit(10)->get();
        ?>
        <div class="col-sm-5"  style=" border-radius: 20px;" id="todolist">
            <hr>
            <h2 class="display-5" style="color:#0066FF;">ข่าวใหม่</h2><hr>
            <div class="card">

                <div class="row">
                    <?php
                    foreach ($newsUpdate as $newsOut) {
                        $link = "";
                        if ($newsOut->url != "") {
                            $link = $newsOut->url;
                        } else {
                            $link = "http://www.does.up.ac.th/upload/" . $newsOut->file;
                        }
                        echo '<div class="col-sm-2"><img src="./assets/images/Picture2.png" style="height:60px; width:60px;" alt=""></div>';
                        echo '<div class="col-sm-10"><a href="' . $link . '" class="display-7">' . $newsOut->title_th . '</a></div>';
                        echo "<br>";
                    }
                    ?>
                </div>
            </div>
            <br>
            <center><a href="<?php echo url("news"); ?>" class="btn btn-success display-7" style="height:5%;background-color:#6600FF; border-color:transparent; color:white;">ดูทั้งหมด</a></center>
        </div>
<?php $blog->nullBlog('2'); ?>
        <div class="col-sm-5" style=" border-radius: 20px;" id="todolist">
            <hr>
            <h2 class="display-5" style="color:#0066FF;">ข่าวกิจกรรม</h2><hr>
            <div class="card">

                <div class="row">
                    <?php
                    foreach ($newsActivity as $newsOut) {
                        $link = "";
                        if ($newsOut->url != "") {
                            $link = $newsOut->url;
                        } else {
                            $link = "http://www.does.up.ac.th/upload/" . $newsOut->file;
                        }
                        echo '<div class="col-sm-2"><img src="./assets/images/Picture2.png" style="height:60px; width:60px;" alt=""></div>';
                        echo '<div class="col-sm-10"><a href="' . $link . '" class="display-7">' . $newsOut->title_th . '</a></div>';
                        echo "<br>";
                    }
                    ?>

                </div>

            </div>
            <br>
            <center><a href="<?php echo url("news"); ?> " class="btn btn-success display-7" style="height:5%;background-color:#6600FF; border-color:transparent; color:white;">ดูทั้งหมด</a></center>
        </div>
        <?php $blog->blogOff(); ?>
        <?php
     
        $menu->footer();
        $header->getScript();

        ?>


    </body>
</html>
