<?php require_once("top.php");?>
  <link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Post a Comment -->
          <div class="container content-space-2 bg-dark">
            <!-- Heading -->
            <div class="text-center">
              <h2 class="">البحث عن  نشاط</h2>
            </div>
            <!-- End Heading -->

            <div class="row justify-content-lg-center">
              <div class="col-lg-12">
                <!-- Card -->
                <div class="card card-lg border shadow-none">
                  <div class="card-body">
                    <form id="findWorkshopForm">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row">
                          <div class="col-sm-3 mb-4 mb-sm-0">
                            <label class="form-label" for="name">اسم النشاط</label>
                            <input type="text" class="form-control " name="name" id="name" >
                            <span class="text-danger" id="name_err"></span>
                          </div>

                          <div class="col-sm-2 mb-4 mb-sm-0">
                            <label class="form-label" for="cat">التصنيف</label>
                            <select  class="form-control " name="cat" id="cat">
                              <option> -- اختر -- </option>
                            </select>
                            <span class="text-danger" id="cat_err"></span>
                          </div>

                          <div class="col-sm-2 mb-4 mb-sm-0">
                            <label class="form-label" for="office">الجه المنظمة</label>
                            <select  class="form-control " name="office" id="office">
                              <option> -- اختر -- </option>
                            </select>
                            <span class="text-danger" id="cat_err"></span>
                          </div>
                          <div class="col-sm-3 mb-4 mb-sm-0">
                            <label class="form-label" for="date">التاريخ</label>
                            <input type="text" class="form-control " name="date" id="date" >
                            <span class="text-danger" id="date_err"></span>
                          </div>
                          <div class="col-sm-2 mb-4 mb-sm-0">
                            <label class="form-label" for="office">&nbsp;</label>
                            <button type="button" onclick="getWorkshops()" class="form-control btn btn-primary ">بحث</button>
                          </div>
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
            <div class="row"><hr /></div>
            <div class="row" id="workshopsBlock">
            </div>
            <div class="row">
              <div class="card-footer border-top">
                <div class="d-flex justify-content-end gap-3">
                  <nav aria-label="...">
          			<ul class="pagination" id="pagination">
                    </ul>
                  <input type="hidden" id="p" name="p" value="<?php if(!empty($_GET['p'])){ echo $_GET['p'];}else{ echo 1;}?>"/>
          		</nav>
                </div>
              </div>
            </div>
          </div>
          <!-- End Post a Comment -->
        </div>
        <!-- End Col -->

<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
    $('#date').datetimepicker({
        format:"yyyy-mm-dd"
    });
function getCat(elem) {
  $.ajax({
    url: "script/_getCat.php",
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
getCat($("#cat"));
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
function getWorkshops(){
  $.ajax({
    url: "script/_getWorkshops.php",
    type: "POST",
    data:$("#findWorkshopForm").serialize(),
    beforeSend: function () {
      $("#workshopsBlock").addClass("loading");
    },
    success: function (res) {
      console.log(res);
      $("#workshopsBlock").html("");
      $("#pagination").html("");
      $("#workshopsBlock").removeClass("loading");
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
        des = this.des;
        if(this.des == null){
          des = "";
        }
         $("#workshopsBlock").append(
               `<div class="col-lg-4 mb-3 mb-lg-5">
                  <!-- Card -->
                  <a class="card card-bordered card-transition h-100" href="?page=workshop.php&id=`+this.id+`">
                    <div class="card-body">
                      <!-- Media -->
                      <div class="d-block d-sm-flex">
                        <div class="flex-grow-1 ms-sm-4">
                          <h3 class="card-title">`+this.name+`</h3>
                          <p class="card-text text-body">`+this.office +`-`+ this.sub_office+`</p>

                          <div class="d-flex">
                            <div class="flex-grow-1 ms-2">
                              <p class="card-text text-dark small mb-0">عدد المقاعد: `+(this.seat-this.enrolled)+`</p>
                              <p class="card-text text-dark small">
                                <span class="text-muted">`+this.start+`</span><br />
                                
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- End Media -->
                    </div>
                  </a>
                  <!-- End Card -->
                </div>`
         );
      });

    },
    error: function (e) {
      $("#workshopsBlock").removeClass("loading");
      console.log(e);
    },
  });
}
getWorkshops();
</script>
<?php require_once("bottom.php");?>