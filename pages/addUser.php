<?php require_once("top.php");?>
  <link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Post a Comment -->
          <div class="container content-space-2 bg-dark">
            <!-- Heading -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
              <h2 class="text-white">اضافة مستخدم</h2>
            </div>
            <!-- End Heading -->

            <div class="row justify-content-lg-center">
              <div class="col-lg-11">
                <!-- Card -->
                <div class="card card-lg border shadow-none">
                  <div class="card-body">
                    <form id="addUserForm">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <label class="form-label" for="name">اسم الكامل</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" >
                            <span class="text-danger" id="name_err"></span>
                          </div>
                          <div class="col-sm-6">
                            <label class="form-label" for="email">البريد الالكتروني</label>
                            <input type="text" class="form-control form-control-lg" name="email" id="email" >
                            <span class="text-danger" id="email_err"></span>
                          </div>
                        </div>
                        <!-- End Form -->
                        <div class="row">
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <label class="form-label" for="office">الكلية او المركز</label>
                            <select  class="form-select form-control form-control-lg" name="office" id="office">
                              <option> -- اختر -- </option>
                            </select>
                            <span class="text-danger" id="office_err"></span>
                          </div>
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <input type="datetime" class="form-control form-control-lg" name="password" id="password" >
                            <span class="text-danger" id="password_err"></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <label class="form-label" for="type">نوع الحساب</label>
                            <select  class="form-select form-control form-control-lg" name="type" id="type">
                              <option value="0"> -- اختر -- </option>
                              <option value="2"> مدير موؤسسة</option>
                              <option value="1"> مدير نظام </option>
                            </select>
                            <span class="text-danger" id="type_err"></span>
                          </div>
                        </div>
                        <!-- End Form -->

                        <div class="d-grid">
                          <button type="button" onclick="addUser()" class="btn btn-primary btn-lg">اضافة</button>
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

<script src="datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
function getOffice(elem) {
  $.ajax({
    url: "script/_getOffice.php",
    type: "POST",
    beforeSent: function () {},
    success: function (res) {
      elem.html("");
      elem.append("<option value=''>-- اختر --</option>");
      $.each(res.data, function () {
        elem.append(
          "<option value='" + this.id + "'>" + this.name + "</option>"
        );
      });
      console.log(res);
    },
    error: function (e) {
      elem.append(
        "<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>"
      );
      console.log(e);
    },
  });
}
getOffice($("#office"));

function addUser(){
  $.ajax({
    url:"script/_addUser2.php",
    type:"POST",
    data:$("#addUserForm").serialize(),
    beforeSend:function(){
      $("#addUserForm").addClass('loading');
    },
    success:function(res){
      $("#addUserForm").removeClass('loading');
      console.log(res);
       if(res.success == 1){
         $("#addUserForm input").val("");
         Toast.success('تم الاضافة');
         alert("تم الاضافة");
         $("#name_err").text('');
         $("#password_err").text('');
         $("#email_err").text('');
         $("#type_err").text('');
         $("#office_err").text('');
       }else{
           $("#name_err").text(res.error["name_err"][0]);
           $("#email_err").text(res.error["email_err"][0]);
           $("#password_err").text(res.error["password_err"][0]);
           $("#type_err").text(res.error["type_err"][0]);
           $("#office_err").text(res.error["office_err"][0]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

    },
    error:function(e){
     $("#addUserForm").removeClass('loading');
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
</script>
<?php require_once("bottom.php");?>