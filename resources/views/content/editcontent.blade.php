@extends('layouts.navbar')

@section('content')
<div class="main-content">
  <?php
//INCLUDE File for use class and new instance;
  include_once(app_path() . '../frontend/header.php');
  include_once(app_path() . '../frontend/menu.php');
  include_once(app_path() . '../frontend/media.php');
  include_once(app_path() . '../frontend/custom.php');
  include_once(app_path() . '../frontend/blog.php');
  include_once(app_path() . '../core_function/core.php');
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

    <h2>แก้ไขข่าวสาร
    </h2>
    <hr>

    <form method="post" action="{{ url('ucontent')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <?php foreach ($newsshow as $new) {
            {
                ?>
                <div class="form-group">
                    <label for="group">หมวดหมู่ :</label>
                    <select class="form-control" id="group" name="group">
                    <?php
                    }
                    $newc = DB::table('news_cat')->pluck('id', 'name_th');
                    foreach ($newc as $name => $title) {
                        echo '<option value="' . $title . '">' . $name . '</option>';
                    }
                }
                ?>

            </select>
        </div>
        <input type="hidden" name="nid" value="{{$new->nid}}">
        <input type="hidden" name="create_user" value="{{ Auth::user()->name }}">
        <input type="hidden" name="create_date" value="<?php date_default_timezone_set("Asia/Bangkok");
                echo date("Y-m-d H:i:s"); ?>">
    <!--    <div class="form-group">
        <label for="year">ปีการศึกษา:</label>
            <input type="text" class="form-control" id="year" name="year" value="{{$new->year}}" >
        </div> -->
        <div class="form-group">
            <label for="order">ลำดับ:</label>
            <input type="number" class="form-control" id="order" name="order" value="{{$new->orders}}">
        </div>
        <div class="form-group">
            <label for="title_th">หัวข้อภาษาไทย:</label>
            <input type="text" class="form-control" id="title_th" name="title_th" value="{{$new->title_th}}">
        </div>
        <div class="form-group">
            <label for="title_en">หัวข้อภาษาอังกฤษ:</label>
            <input type="text" class="form-control" id="title_en" name="title_en" value="{{$new->title_en}}">
        </div>
        <div class="form-group">
            <label for="title_en">อัพโหลดรูปภาพ: {{ $new->img }}</label><br>
            <?php
            $img = url("/assets/images/Picture2.png");
            if($new->img != null){$img = asset($new->img);} ?>
            <img src="{{$img}}" style="width:100px;height:100px;">
            <input class="btn btn-default" type="file" name="img" value="{{$new->img}}">
            <input class="btn btn-default" type="hidden" name="img" value="{{$new->img}}">
        </div>
        <div class="form-group">
            <label for="type">ประเภทข่าว:</label>
            <select class="form-control" id="sel" name="type" value="{{$new->type}}">
                <option selected="selected" value="text">ข้อความ</option>
                <option value="file">FILE</option>
                <option value="url">URL</option>
            </select>
        </div>

        <div class="panel-group type_t" id="accordion">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">ข้อความภาษาไทย
                            <i class="fas fa-minus pull-right"></i></a>
                    </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <textarea id="editor1" name="text_th" rows="10" cols="80">
          {{$new->text_th}}
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">ข้อความภาษาอังกฤษ
                            <i class="fas fa-minus pull-right"></i></a>
                    </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        <textarea id="editor2" name="text_en" rows="10" cols="80" >
          {{$new->text_en}}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group type_u">
            <label>URL</label>
            <input name="url" type="text" class="form-control" placeholder="Enter ..." value="{{$new->url}}">
        </div>
        <div class="form-group type_f">
            <label>File: {{$new->file}}</label>
            <input class="btn btn-default" type="file" name="file">
        </div>
        <div class="form-group col-md-4">
            <button type="submit" class="btn btn-success" style="margin-left:38px">บันทึก</button>
        </div>
</div>
</form>

</div>

<script src="{{asset('vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    $(".textarea").wysihtml5();
</script>
<script type="text/javascript">

    $("select ")
            .change(function () {
                var str = "";
                $("#sel  option:selected").each(function () {
                    str = $(this).text();
                });
                //$( "div #sweet" ).text( str );

                if (str == "ข้อความ") {
                    $('.type_t').show();
                    $('.type_f').hide();
                    $('.type_u').hide();
                } else if (str == "FILE") {
                    $('.type_t').hide();
                    $('.type_f').show();
                    $('.type_u').hide();
                } else if (str == "URL") {
                    $('.type_t').hide();
                    $('.type_f').hide();
                    $('.type_u').show();
                }
                delete str;
            })
            .change();
</script>
@endsection
