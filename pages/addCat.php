<?php require_once("top.php");?>
  <link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Post a Comment -->
          <div class="container content-space-2 bg-dark">
            <!-- Heading -->
            <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
              <h2 class="text-white">اضافة تصنيف</h2>
            </div>
            <!-- End Heading -->

            <div class="row justify-content-lg-center">
              <div class="col-lg-11">
                <!-- Card -->
                <div class="card card-lg border shadow-none">
                  <div class="card-body">
                    <form id="addCatForm">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <label class="form-label" for="name">اسم التصنيف</label>
                            <input type="text" class="form-control form-control-lg" name="name" id="name" >
                          </div>
                        </div>

                        <div class="d-grid">
                          <button type="button" onclick="addCat()" class="btn btn-primary btn-lg">اضافة</button>
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
<script>

function addCat(){
  $.ajax({
    url:"script/_addCat.php",
    type:"POST",
    data:$("#addCatForm").serialize(),
    beforeSend:function(){

    },
    success:function(res){
       console.log(res);
       if(res.success == 1){
         Toast.success('تم الاضافة');
         alert("تم الاضافة");
       }else{
           $("#name_err").text(res.error["name_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

    },
    error:function(e){
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
</script>
<?php require_once("bottom.php");?>