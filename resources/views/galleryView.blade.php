<!doctype html>
<?php
//INCLUDE File for use class and new instance;
include_once(app_path() . '/frontend/header.php');
include_once(app_path() . '/frontend/menu.php');
include_once(app_path() . '/frontend/media.php');
include_once(app_path() . '/frontend/custom.php');
include_once(app_path() . '/frontend/blog.php');
include_once(app_path() . '/core_function/core.php');

//NEW Instance class for use;
$header = new header();
$menu = new menu();
$media = new media();
$custom = new custom();
$blog = new blog();
$db = new databaseGet();
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
        <style>

        </style>
        <?php $menu->navbar("black"); ?>
        <?php
        echo '<br><br><br>';

        $id = '';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            echo '<script>window.location = "' . url("gallery") . '"</script>';
        }
        $i = 0;
        $pic =[];

            $dir = public_path() . "\Gallerys\pic" . $id;

            if (isset($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file != "." && $file != "..") {
                            $pic[$i] = url('/Gallerys/pic' . $id . '/' . $file . '');
                            $i++;
                        }
                    }
                    closedir($dh);
                }
            }
            $media->gallery($pic);
   
        $menu->footer();

        $header->getScript();
        ?>

    </body>
</html>
