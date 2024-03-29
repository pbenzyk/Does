<?php $__env->startSection('content'); ?>
<div class="main-content">
    <?php
    //INCLUDE File for use class and new instance;
    include_once(app_path() . '/frontend/header.php');
    include_once(app_path() . '/frontend/menu.php');
    include_once(app_path() . '/frontend/media.php');
    include_once(app_path() . '/frontend/custom.php');
    include_once(app_path() . '/frontend/blog.php');
    include_once(app_path() . '/core_function/core.php');
    include_once(app_path() . '/backend/MediaManager.php');
    include_once(app_path() . '/backend/Dialog.php');
    //NEW Instance class for use;
    $header = new header();
    $menu = new menu();
    $media = new media();
    $custom = new custom();
    $blog = new blog();
    $db = new databaseGet();
    $media_manage = new MediaManager();
    $dialog = new Dialog();
    ?>
    <?php
            $message = "0";
            $alid = "0";
            if(isset($_GET['mes'])){$message = $_GET['mes'];};
            if(isset($_GET['al'])){$alid = $_GET['al'];};
    ?>
    <h2><span class="glyphicon glyphicon-user"></span> จัดการผู้ใช้
        <div class="btn-group pull-right">
            <a data-toggle="modal" data-target="#makeAl"  class="btn btn-success"><i class="fas fa-user-plus"></i> เพิ่มผู้ใช้</a>
        </div>
    </h2>

    <hr>
    <form action="<?php echo e(url('/user')); ?>" method="get">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="ค้นหาจาก ชื่อหมวดหมู่">
            <div class="input-group-btn">
                <input type="submit" value="ค้นหา" class="form-control" >
            </div>
        </div>
    </form>
    <table id="example" class="display table table-striped" cellspacing="0">
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('name','ชื่อผู้ใช้'));?></th>
                <th><?php echo \Kyslik\ColumnSortable\SortableLink::render(array ('create_user','ผู้สร้าง'));?></th>
                <th>วันที่สร้าง</th>
                <th>ลบ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($users as $user) {
              $id = $user->id;
              ?>
              <tr>
                <td><?php echo $i++ ;?></td>
                <td><?php echo $user->name ;?> </td>
                <td><?php echo $user->create_user;?></td>
                <td><?php echo $db->convertDate($user->created_at);?></td>
                <td><a data-toggle="modal" data-target="#deleteuser"  data-id="<?php echo e($user->id); ?>" data-name="<?php echo e($user->name); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ลบ</a>
                     </td>
                </tr>
                <?php
            }
            ?>

        </tbody>
    </table>
</div>

<div class="modal fade" id="makeAl" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">เพิ่มผู้ใช้</h4>
            </div>
            <form action="<?php echo e(action('UserController@store')); ?>" method="post">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                  <div class="form-group">
                    <label for="nameuser">ชื่อผู้ใช้:</label>
                    <input type="text" class="form-control" placeholder="ชื่อผู้ใช้" id="nameuser" name="nameuser" required>
                  </div>
                  <div class="form-group">
                    <label for="g_name_en">ผู้สร้าง: <?php echo e(Auth::user()->name); ?></label>
                    <input type="hidden"  value="<?php echo e(Auth::user()->name); ?>" placeholder="create_user" id="create_user" name="create_user" required/>
                  </div>
                  <div class="form-group">
                    <label for="g_name_en">วันที่สร้าง: <?php echo e(date("Y-m-d h:m:s")); ?></label>
                    <input type="hidden"  value="<?php echo e(date("Y-m-d h:m:s")); ?>" placeholder="create_date" id="create_date" name="create_date" required/>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary"  value="Create">บันทึก</button>
                </div>
            </form>
        </div>
      </div>
      </div>

        <div class="modal fade" id="deleteuser" role="dialog" data-keyboard="false" >
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title text-center ">ต้องการลบหมวดหมู่</h2>
                    </div>
                    <div class="modal-body text-center ">
                        <div class="text-center" style="font-size:6em; ">
                            <i style="color:crimson;" class="fas fa-trash-alt faa-shake animated"></i>
                        </div>
                        <div class="form-group text-left">
                            <label for="name">ชื่อ</label>
                            <input type="text" id="name"  class="form-control" disabled/>
                        </div>

                        <a id="delx" style="font-size:18px;" class="btn btn-success btn-lg" ><i class="fas fa-check-circle"></i> ตกลง</a>
                        <button type="button" style="font-size:18px;" class="btn btn-warning btn-lg" data-dismiss="modal"><i class="fas fa-times-circle"></i> ยกเลิก</button>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if($message!="0"){
            if($message == "errorDB"){
                $dialog->customMessageDefault("deleteMessage","เกิดข้อผิดพลาด","fas fa-exclamation-triangle","red","จากการลบข้อมูลในฐานข้อมูล",url('user'));
            }
            else if($message == "errorFile"){
                $dialog->customMessageDefault("deleteMessage","เกิดข้อผิดพลาด","fas fa-exclamation-triangle","red","จากการลบไฟล์ในโฮส",url('user'));
            }
            else if($message == "fileDelOK"){
                $dialog->customMessageDefault("deleteMessage","ลบข้อมูลสำเร็จ","fas fa-check-circle","#66FF33","",url('user'));
            }
            else if($message == "updateGContentOK"){
                $dialog->customMessageDefault("ui","อัพเดทข้อมูลสำเร็จ","fas fa-check-circle","#66FF33","",url('user'));
            }
            else if($message == "updateGContentError"){
                $dialog->customMessageDefault("updateMessage","เกิดข้อผิดพลาด","fas fa-exclamation-triangle","red","จากการอัพเดทข้อมูลลงฐานข้อมูล",url('user'));
            }
            else if($message == "addUserOK"){
                $dialog->customMessageDefault("addUserOK","เพิ่มผู้ใช้่สำเร็จ","fas fa-check-circle","#66FF33","จากการอัพเดทข้อมูลลงฐานข้อมูล",url('user'));
            }
            else if($message == "addUserError"){
                $dialog->customMessageDefault("addUserError","เกิดข้อผิดพลาดในการเพิ่มผู้ใช้","fa-exclamation-triangle","red","จากการอัพเดทข้อมูลลงฐานข้อมูล",url('user'));
            }
        }
        ?>

<script>

    $('#deleteuser').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var sent1 = button.data('name') // Extract info from data-* attributes
      var sent2 = button.data('id')
      var modal = $(this)
      var delink = "<?php echo action('UserController@destroy'); ?>?id="
      var deletew = document.getElementById('delx')
      deletew.href = delink+sent2
      modal.find('.modal-body #name').val(sent1)
      modal.find('.modal-body #id').val(sent2)

    })
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var sent1 = button.data('name') // Extract info from data-* attributes
        var sent2 = button.data('id')
        var modal = $(this)

        modal.find('.modal-body #g_name_th').val(sent1)
        modal.find('.modal-body #gid').val(sent2)
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.navbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>