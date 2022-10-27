<?php require_once("top.php");?>
  <link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Post a Comment -->
          <div class="container content-space-2 bg-dark">
            <!-- Heading -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
              <h2 class="text-white">الملف الشخصي</h2>
            </div>
            <!-- End Heading -->

            <div class="row justify-content-lg-center">
              <div class="col-lg-11">
                <!-- Card -->
                <div class="card card-lg border shadow-none">
                  <div class="card-body">
                    <form id="editUserForm">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
<!--                          <div class="col-sm-12 mb-4 mb-sm-0">
                            <label class="form-label" for="name">اسم الكامل</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" >
                            <span class="text-danger" id="name_err"></span>
                          </div>-->
                          <div class="col-sm-12">
                            <label class="form-label" for="email">البريد الالكتروني</label>
                            <input type="text" class="form-control form-control-lg" name="email" id="email" >
                            <span class="text-danger" id="email_err"></span>
                          </div>
                        </div>
                        <!-- End Form -->
                        <div class="row">
                          <div class="col-sm-12 mb-4 mb-sm-0">
                            <label class="form-label" for="password">كلمة المرور</label>
                            <input type="datetime" class="form-control form-control-lg" name="password" id="password" >
                            <span class="text-danger" id="password_err"></span>
                          </div>
                        </div>
                        <!-- End Form -->

                        <div class="d-grid">
                          <button type="button" onclick="updateUser()" class="btn btn-primary btn-lg">حفظ</button>
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
function editUser(){
 $.ajax({
    url:"script/_getMyUser.php",
    beforeSend:function(){
      $("#editUserForm").addClass('loading');
    },
    success:function(res){
       $("#editUserForm").removeClass('loading');
      if(res.success == 1){
        $.each(res.data,function(){
          $('#name').val(this.name);
          $('#email').val(this.email);
        });
      }
      console.log(res);
    },
    error:function(e){
      $("#editUserForm").removeClass('loading');
      console.log(e);
    }
  });
}
function updateUser(){
    $(".text-danger").text("");
    $.ajax({
       url:"script/_updateMyUser.php",
       type:"POST",
       data:$("#editUserForm").serialize(),
       beforeSend:function(){
        $("#editUserForm").addClass('loading');
       },
       success:function(res){
         $("#editUserForm").removeClass('loading');
         console.log(res);
       if(res.success == 1){
          Toast.success('تم التحديث');
          alert("تم التحديث بنجاح");
       }else{
           $("#name_err").text(res.error["name_err"]);
           $("#email_err").text(res.error["email_err"]);
           $("#password_err").text(res.error["password_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }
       },
       error:function(e){
        $("#editUserForm").removeClass('loading');
        Toast.error('خطأ');
        console.log(e);
       }
    })
}
editUser();
</script>
<?php require_once("bottom.php");?>