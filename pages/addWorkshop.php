<?php require_once("top.php"); ?>
<link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
<!-- End Col -->
<div class="col-lg-9">
  <!-- Post a Comment -->
  <div class="container content-space-2 bg-dark">
    <!-- Heading -->
    <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
      <h2 class="text-white">اضافة نشاط</h2>
    </div>
    <!-- End Heading -->
    <div class="row justify-content-lg-center">
      <div class="col-lg-12">
        <!-- Card -->
        <div class="card card-lg border shadow-none">
          <div class="card-body">
            <form id="addWorkshopForm">
              <div class="d-grid gap-4">
                <!-- Form -->
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="name">اسم النشاط</label>
                    <input type="text" class="form-control form-control-lg" name="name" id="name">
                    <span class="text-danger" id="name_err"></span>
                  </div>

                  <div class="col-sm-6">
                    <label class="form-label" for="sub_office">الاسم الفرعي للجهة المنظمة</label>
                    <input type="text" class="form-control form-control-lg" name="sub_office" id="sub_office">
                    <span class="text-danger" id="-"></span>
                  </div>
                </div>
                <!-- End Form -->
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="cat">التصنيف</label>
                    <select class="form-control form-control-lg" name="cat" id="cat">
                      <option> -- اختر -- </option>
                    </select>
                    <span class="text-danger" id="cat_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="seat">العدد</label>
                    <input type="number" max="1000" class="form-control form-control-lg" name="seat" id="seat">
                    <span class="text-danger" id="seat_err"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="start">تاريخ و وقت بدأ النشاط</label>
                    <input type="datetime" class="form-control form-control-lg" name="start" id="start">
                    <span class="text-danger" id="start_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="end">تاريخ و وقت انتهاء النشاط</label>
                    <input type="datetime" class="form-control form-control-lg" name="end" id="end">
                    <span class="text-danger" id="end_err"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label class="form-label" for="url">رابط النشاط</label>
                    <input type="url" class="form-control form-control-lg" name="url" id="url" placeholder="" aria-label="">
                    <span class="text-danger" id="url_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="url">بالتعاون مع</label>
                    <select class="form-control form-control-lg" name="with" id="with">
                      <option> -- اختر -- </option>
                    </select>
                    <span class="text-danger" id="with_err"></span>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-6">
                    <label class="form-label" for="url">توقيع المدرب الاول</label>
                    <input type="file" class="form-control form-control-lg" name="sig1" id="sig1" />
                    <span class=" text-danger" id="sig1_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="url">توقيع المدرب الثاني</label>
                    <input type="file" class="form-control form-control-lg" name="sig2" id="sig2" />
                    <span class="text-danger" id="sig2_err"></span>
                  </div>

                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label class="form-label" for="url">اسم المدرب الاول</label>
                    <input type="text" class="form-control form-control-lg" name="name1" id="name1" />
                    <span class=" text-danger" id="name1_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="url">اسم المدرب الثاني</label>
                    <input type="text" class="form-control form-control-lg" name="name2" id="name2" />
                    <span class="text-danger" id="name2_err"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <label class="form-label" for="url">المسمى الوظيفي 1</label>
                    <input type="text" class="form-control form-control-lg" name="job1" id="job1" />
                    <span class=" text-danger" id="job1_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="url">المسمى الوظيفي 2</label>
                    <input type="text" class="form-control form-control-lg" name="job2" id="job2" />
                    <span class="text-danger" id="job2_err"></span>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-4">
                    <label class="form-label" for="url">المسافه العليا</label>
                    <input type="number" class="form-control form-control-lg" name="paddingTop" id="paddingTop" />
                    <span class=" text-danger" id="paddingTop_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="url">المسافه بين النص والاسماء</label>
                    <input type="number" class="form-control form-control-lg" name="textSize" id="textSize" />
                    <span class="text-danger" id="textSize_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="url">المسافه بين الاسماء</label>
                    <input type="number" min="0" max="80" class="form-control form-control-lg" name="space" id="space" />
                    <span class="text-danger" id="space_err"></span>
                  </div>
                </div>
                <hr>
                <div class="col-sm-6">
                  <label class="form-label" for="url"> خلفيه الشهاده </label>
                  <input type="file" class="form-control form-control-lg" name="cer_bg" id="cer_bg" />
                  <span class=" text-danger" id="cer_bg_err"></span>
                </div>
                <span class="d-block">
                  <label class="form-label" for="desc">وصف</label>
                  <textarea class="form-control form-control-lg" id="desc" name="desc" placeholder="اضف بعض الوصف" rows="5"></textarea>
                  <span class="text-danger" id="des_err"></span>
                </span>
                <div class="d-grid">
                  <button type="button" onclick="addWorkshop()" class="btn btn-primary btn-lg">اضافة</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Card -->
      </div>
      <!-- End Col -->
    </div>
    <!-- End Row -->
  </div>
  <!-- End Post a Comment -->
</div>
<!-- End Col -->

<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="https://cdn.tiny.cloud/1/pvklsv3hypcbxogpd3kqnmoqe4tjsqe670h65x2gu6vqevos/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#desc',
    setup: function(editor) {
      editor.on('change', function() {
        editor.save();
      });
    }
  });
  $('#start').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
  });
  $('#end').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn: 1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1
  });

  function getCat(elem) {
    $.ajax({
      url: "script/_getCat.php",
      type: "POST",
      beforeSent: function() {},
      success: function(res) {
        elem.html("");
        elem.append("<option value=''>-- اختر --</option>");
        $.each(res.data, function() {
          elem.append(
            "<option value='" + this.id + "'>" + this.name + "</option>"
          );
        });
        console.log(res);
      },
      error: function(e) {
        elem.append(
          "<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>"
        );
        console.log(e);
      },
    });
  }
  getCat($("#cat"));

  function getOffice(elem) {
    $.ajax({
      url: "script/_getOffice.php",
      type: "POST",
      beforeSent: function() {},
      success: function(res) {
        elem.html("");
        elem.append("<option value=''>-- اختر --</option>");
        $.each(res.data, function() {
          elem.append(
            "<option value='" + this.id + "'>" + this.name + "</option>"
          );
        });
        console.log(res);
      },
      error: function(e) {
        elem.append(
          "<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>"
        );
        console.log(e);
      },
    });
  }
  getOffice($("#with"));

  function addWorkshop() {
    var myform = document.getElementById('addWorkshopForm');
    var fd = new FormData(myform);
    $.ajax({
      url: "script/_addWorkshop.php",
      type: "POST",
      data: fd,
      processData: false, // tell jQuery not to process the data
      contentType: false,
      cache: false,
      beforeSend: function() {
        $("#addWorkshopForm").addClass('loading');
      },
      success: function(res) {
        $("#addWorkshopForm").removeClass('loading');
        console.log(res);
        $("#name_err").text('');
        $("#sub_office_err").text('');
        $("#des_err").text('');
        $("#cat_err").text('');
        $("#with_err").text('');
        $("#url_err").text('');
        $("#start_err").text('');
        $("#end_err").text('');

        $("#sig1_err").text('');
        $("#sig2_err").text('');
        $("#name1_err").text('');
        $("#name2_err").text('');
        $("#job1_err").text('');
        $("#job2_err").text('');
        $("#cer_bg_err").text('');
        $("#space_err").text('');
        $("#paddingTop_err").text('');
        $("#textSize_err").text('');
        if (res.success == 1) {
          $("#addWorkshopForm input").val("");
          Toast.success('تم الاضافة');
          alert("تم الاضافة");
        } else {
          $("#name_err").text(res.error["name_err"]);
          $("#sub_office_err").text(res.error["sub_office_err"]);
          $("#cat_err").text(res.error["cat_err"]);
          $("#with_err").text(res.error["with_err"]);
          $("#des_err").text(res.error["des_err"]);
          $("#url_err").text(res.error["url_err"]);
          $("#start_err").text(res.error["start_err"]);
          $("#end_err").text(res.error["end_err"]);

          $("#sig1_err").text(res.error["sig1_err"]);
          $("#sig2_err").text(res.error["sig2_err"]);
          $("#name1_err").text(res.error["name1_err"]);
          $("#name2_err").text(res.error["name2_err"]);
          $("#job1_err").text(res.error["job1_err"]);
          $("#job2_err").text(res.error["job2_err"]);
          $("#cer_bg_err").text(res.error["cer_bg_err"]);

          $("#space_err").text(res.error["space_err"]);
          $("#paddingTop_err").text(res.error["paddingTop_err"]);
          $("#textSize_err").text(res.error["textSize_err"]);

          Toast.warning("هناك بعض المدخلات غير صالحة", 'خطأ');
        }

      },
      error: function(e) {
        $("#addWorkshopForm").removeClass('loading');
        console.log(e);
        Toast.error('خطأ');
      }
    });
  }
</script>
<?php require_once("bottom.php"); ?>