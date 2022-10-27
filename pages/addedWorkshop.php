<?php require_once("top.php");?>
<style>
.k {
  padding-top: 20px;
}

</style>
 <script src="./assets/js/dataTable.js" ></script>
  <link rel="stylesheet" href="./assets/css/dataTable.css">
  <link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Card -->
          <div class="card">
            <div class="card-header">
              <h5 class="card-header-title">المستخدمون</h5>
            </div>
            <form id="UsersForm">
                <!-- Card -->
                <div class="card card-lg border shadow-none bg-dark">
                  <div class="card-body">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
                          <div class="col-sm-3 mb-4 mb-sm-0">
                            <label class="form-label text-white" for="name">الاسم</label>
                            <input type="text" class="form-control " name="name" id="name" >
                            <span class="text-danger" id="name_err"></span>
                          </div>
                          <div class="col-sm-2 mb-4 mb-sm-0">
                            <label class="form-label" for="office">&nbsp;</label>
                            <button type="button" onclick="getUsers()" class="form-control btn btn-primary ">بحث</button>
                          </div>
                        </div>



                      </div>

                  </div>
                </div>
                <!-- End Card -->
            <!-- Table --> <br /><hr />
            <div class="table-responsive">
              <table id="table" class="table table-borderless table-thead-bordered  table-align-middle card-table">
                <thead class="thead-light">
                  <tr>
                    <th><input  id="allselector" type="checkbox"><span></span></th>
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th style="width: 5%;"></th>
                  </tr>
                </thead>

                <tbody id="usersTable">

                </tbody>
              </table>
            </div>
                <div class="card card-lg border shadow-none bg-dark">
                  <div class="card-body">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <button type="button" onclick="cerOn()" class="form-control btn btn-primary ">تفعيل الشهادة لكل المحدد</button>
                          </div>
                          <div class="col-sm-6 mb-4 mb-sm-0">
                            <button type="button" onclick="cerOff()" class="form-control btn btn-danger ">الغاء تفعيل الشهادة للمحدد</button>
                          </div>
                        </div>



                      </div>

                  </div>
                </div>
            <!-- End Table -->
            <input type="hidden" id="id" name="id" value="<?php if(!empty($_GET['id'])){ echo $_GET['id'];}else{ echo 0;}?>"/>
            <!-- Footer -->
            <div class="card-footer border-top">
              <div class="d-flex justify-content-end gap-3">
                <nav aria-label="...">
        			<ul class="pagination" id="pagination">

        			</ul>
                <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
        		</nav>
              </div>
            </div>
            </form>
            <!-- End Footer -->
          </div>
<!-- End Card -->
        </div>
        <!-- End Col -->
        <input type="hidden" value="<?php echo $_GET['id'];?>" id="workshop_id">
<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
function getUsers() {
  $.ajax({
    url: "script/_getWorkshopUsers.php",
    type: "POST",
    data:$("#UsersForm").serialize(),
    beforeSent: function () {
      $("#usersTable").addClass("loading");
    },
    success: function (res) {
      $("#usersTable").removeClass("loading");
      $("#table").DataTable().destroy();
      $("#usersTable").html("");
      $("#pagination").html("");
      if(res.success == 1){
          if(res.pages >= 1){
             if(res.page > 1){
                 $("#pagination").append(
                  '<li class="page-item"><a href="#" onclick="getPage('+(Number(res.page)-1)+')" class="page-link">السابق</a></li>'
                 );
             }else{
                 $("#pagination").append(
                  '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
                 );
             }
             if(Number(res.pages) <= 5){
               i = 1;
             }else{
               i =  Number(res.page) - 5;
             }
             if(i <=0 ){
               i=1;
             }
             for(i; i <= res.pages; i++){
               if(res.page != i){
                 $("#pagination").append(
                  '<li class="page-item"><a href="#" onclick="getPage('+(i)+')" class="page-link">'+i+'</a></li>'
                 );
               }else{
                 $("#pagination").append(
                  '<li class="page-item active"><span class="page-link">'+i+'</span></li>'
                 );
               }
               if(i == Number(res.page) + 5 ){
                 break;
               }
             }
             if(res.page < res.pages){
                 $("#pagination").append(
                  '<li class="page-item"><a href="#" onclick="getPage('+(Number(res.page)+1)+')" class="page-link">التالي</a></li>'
                 );
             }else{
                 $("#pagination").append(
                  '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
                 );
             }
           }
        $.each(res.data, function () {
          if(this.download_cer == 1){
            active = "مفعل";
          }else{
             active = "غير مفعل";
          }

          $("#usersTable").append(
                  `<tr>
                    <td class=""><input type="checkbox" value="`+this.id+`" name="ids[]" rowid="`+this.id+`"><span></span></td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                          <h6 class="text-hover-primary mb-0">`+this.name+`</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                          <h6 class="text-hover-primary mb-0">`+this.email+`</h6>
                        </div>
                      </div>
                    </td>
                    <td>`+active+`</td>
                  </tr>`
          );
        });
      }
      $('#table').DataTable({
         "bFilter": false,
      });
      console.log(res);
    },
    error: function (e) {
      $("#usersTable").removeClass("loading");
      console.log(e);
    },
  });
}
function cerOn(){
   $.ajax({
     url:"script/_cerOn.php",
     type:"POST",
     data:$("#UsersForm").serialize(),
     beforeSend:function(){
        $("#usersTable").addClass("loading");
     },
     success:function(res){
       $("#usersTable").removeClass("loading");
       Toast.success(" تم ");
       console.log(res);
       getUsers();
     },
     error:function(e){
       $("#usersTable").removeClass("loading");
       Toast.warning(" حدث خطأ حاول مره اخرئ ");
        console.log(e);
     }
   });
}
function cerOff(){
   $.ajax({
     url:"script/_cerOff.php",
     type:"POST",
     data:$("#UsersForm").serialize(),
     beforeSend:function(){
        $("#usersTable").addClass("loading");
     },
     success:function(res){
       $("#usersTable").removeClass("loading");
       Toast.success(" تم ");
       console.log(res);
       getUsers();
     },
     error:function(e){
       $("#usersTable").removeClass("loading");
       Toast.warning(" حدث خطأ حاول مره اخرئ ");
        console.log(e);
     }
   });
}
$(document).ready(function(){
  getUsers();
$("#allselector").change(function() {
    var ischecked= $(this).is(':checked');
    if(!ischecked){
      $('input[name="ids\[\]"]').attr('checked', false);;
    }else{
      $('input[name="ids\[\]"]').attr('checked', true);;
    }
});
});

function getPage(page){
    $("#p").val(page);
    getUsers();
}

</script>
<?php require_once("bottom.php");?>