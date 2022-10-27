<?php require_once("top.php");?>
  <link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
        <!-- End Col -->
        <div class="col-lg-9">
          <!-- Card -->
          <div class="card" id="workshopDetails">
            <div class="card-header">
              <h5 class="card-header-title">تفاصيل النشاط</h5>
            </div>
                <!-- Card -->
                <div class="card card-lg border shadow-none bg-dark">
                  <div class="card-body">
                    <form id="UsersForm">
                      <div class="d-grid gap-4">
                        <!-- Form -->
                        <div class="row" id="enrollment">

                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- End Card -->
            <!-- Table -->
                   <h1 id="name"></h1>
                   <h3 id="office" class="text-muted"></h3>
                   <p id="des"></p>
                   <span id="date"></span>
                   <a id="link"></a>
            <!-- End Table -->

            <!-- Footer -->
            <div class="card-footer border-top">
              <div class="d-flex justify-content-end gap-3">
              </div>
            </div>
            <!-- End Footer -->
          </div>
<!-- End Card -->
        </div>
        <!-- End Col -->
        <input type="hidden" value="<?php echo $_GET['id'];?>" id="workshop_id">
<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
function getWorkshop(id) {
  $.ajax({
    url: "script/_getWorkshop.php",
    type: "POST",
    data:{id:id},
    beforeSent: function () {},
    success: function (res) {
      if(res.success == 1){
        $.each(res.data,function(){
          console.log(this);
          if(this.loc == 0){
             enroll =  `<div class="col-sm-3 mb-4 mb-sm-0">
                          <button type="button" onclick="enrollment(`+this.id+`)" class="form-control btn btn-primary ">تسجيل</button>
                        </div>`;
          }else{
             enroll =  `<div class="col-sm-3 mb-4 mb-sm-0 text-white">
                         <h3 class="text-white">التسجيل مغلق</h3>
                        </div>`;
          }
          $("#name").html('&nbsp;&nbsp;'+this.name);
          $("#des").html("&nbsp;&nbsp;"+this.des);
          $("#office").html('<br /> &nbsp;يقيمها <b>'+this.office + "</b> بالتعاون مع "+ this.with_name);
          $("#link").html('<br />&nbsp;&nbsp;رابط النشاط: <a href="'+this.link+'">'+this.link+'</a>');
          $("#date").html('<br />&nbsp;&nbsp; تبدأ بتاريخ : '+this.start_date +' وتنتهي بتاريخ: '+this.end_date);
          $("#enrollment").html(
              `<div class="col-sm-9 mb-4 mb-sm-0">
                   <h3 class="text-white"> عدد المقاعد المتبقية : `+(this.seat-this.enrolled)+`</h3>
               </div>
               `+enroll
          )
        });
      }
      console.log(res);
    },
    error: function (e) {
      console.log(e);
    },
  });
}
getWorkshop($("#workshop_id").val());
function enrollment(id){
  $.ajax({
    url: "script/_enroll.php",
    type: "POST",
    data:{id:id},
    beforeSend: function () {
      $("#workshopDetails").addClass("loading");
    },
    success: function (res) {
      console.log(res);
      $("#workshopDetails").removeClass("loading");
      alert(res.msg);
    },
    error: function (e) {
      $("#workshopDetails").removeClass("loading");
      console.log(e);
      alert("حدث خطأ");
    },
  });
}

</script>
<?php require_once("bottom.php");?>