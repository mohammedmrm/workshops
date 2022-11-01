<?php require_once("top.php"); ?>
<link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
<!-- End Col -->
<div class="col-lg-9">
  <!-- Card -->
  <div class="card">
    <div class="row">
      <div class="card-header col-6">
        <h5 class="card-header-title">النشاطات التي تم اضافتها</h5>
      </div>
    </div>
    <form id="myAddedWorkshopsForm">
      <!-- Table -->
      <div class="table-responsive table-striped">
        <table id="tb-myAddedWorkshopsTable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle">
          <thead class="thead-light">
            <tr>
              <th>اسم الدورة</th>
              <th>الجهة المنظمه</th>
              <th>الشهادة</th>
              <th>تبليغ</th>
              <th>تعديل</th>
              <th>حذف</th>
              <th> شهاده </th>
              <th>اغلاق او تفعيل</th>
            </tr>
          </thead>

          <tbody id="myAddedWorkshopsTable">

          </tbody>
        </table>
      </div>
      <!-- End Table -->

      <!-- Footer -->
      <div class="card-footer border-top">
        <div class="d-flex justify-content-end gap-3">
          <nav aria-label="...">
            <ul class="pagination" id="pagination">

            </ul>
            <input type="hidden" id="p" name="p" value="<?php if (!empty($_GET['p'])) {
                                                          echo $_GET['p'];
                                                        } else {
                                                          echo 1;
                                                        } ?>" />
          </nav>
        </div>
      </div>
    </form>
    <!-- End Footer -->
  </div>
  <!-- End Card -->
</div>
<!-- End Col -->
<!-- Modal -->
<div class="modal fade" id="emailModal" style="position: fixed !important;z-index: 1200;" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <div class="modal-close">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <hr />
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="SendEmailForm">
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label" for="">عنوان التبليغ</label>
                <input type="name" class="form-control" name="sub" id="sub" placeholder="" required="">
                <span class="invalid-feedback text-danger" id="sub_err"></span>
              </div>
              <div class="mb-3">
                <label class="form-label" for="body">نص الرسالة</label>
                <textarea class="form-control" name="body" id="body"></textarea>
                <span class="invalid-feedback text-danger" id="body_err"></span>
              </div>
            </div>
          </div>
          <input type="hidden" value="" name="workshop_id" id="workshop_id">
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <button type="button" class="btn btn-info" onclick="sendEmail()">ارسال</button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- End Body -->
    </div>
  </div>
</div>
<!-- End Modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" style="position: fixed !important;z-index: 1200;" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <div class="modal-close">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <hr />
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="editForm">
          <div class="d-grid gap-4">
            <div class="row">
              <div class="col-sm-6 mb-4 mb-sm-0">
                <label class="form-label" for="name">اسم النشاط</label>
                <input type="text" class="form-control form-control-lg" name="name" id="name">
                <span class="text-danger" id="name_err"></span>
              </div>
              <div class="col-sm-6">
                <label class="form-label" for="sub_office">الاسم الفرعي للجهة المنظمة</label>
                <input type="text" class="form-control form-control-lg" name="sub_office" id="sub_office">
                <span class="text-danger" id="sub_office_err"></span>
              </div>
            </div>
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
              <button type="button" onclick="updateWorkshop()" class="btn btn-primary btn-lg">تحديث</button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Body -->
    </div>
  </div>
</div>
<!-- End Modal -->
<input type="hidden" value="<?php echo $_GET['id']; ?>" id="workshop_id">
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
  tinymce.init({
    selector: '#body',
    setup: function(editor) {
      editor.on('change', function() {
        editor.save();
      });
    }
  });

  function getMyAddedWorkshops() {
    $.ajax({
      url: "script/_getMyAddedWorkshop.php",
      type: "POST",
      data: $("#myAddedWorkshopsForm").serialize(),
      beforeSent: function() {
        $("#tb-myAddedWorkshopsTable").addClass("loading");
      },
      success: function(res) {
        $("#tb-myAddedWorkshopsTable").removeClass("loading");
        $("#myAddedWorkshopsTable").html("");
        $("#pagination").html("");
        if (res.success == 1) {
          if (res.pages >= 1) {
            if (res.page > 1) {
              $("#pagination").append(
                '<li class="page-item"><a href="#" onclick="getPage(' + (Number(res.page) - 1) + ')" class="page-link">السابق</a></li>'
              );
            } else {
              $("#pagination").append(
                '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
              );
            }
            if (Number(res.pages) <= 5) {
              i = 1;
            } else {
              i = Number(res.page) - 5;
            }
            if (i <= 0) {
              i = 1;
            }
            for (i; i <= res.pages; i++) {
              if (res.page != i) {
                $("#pagination").append(
                  '<li class="page-item"><a href="#" onclick="getPage(' + (i) + ')" class="page-link">' + i + '</a></li>'
                );
              } else {
                $("#pagination").append(
                  '<li class="page-item active"><span class="page-link">' + i + '</span></li>'
                );
              }
              if (i == Number(res.page) + 5) {
                break;
              }
            }
            if (res.page < res.pages) {
              $("#pagination").append(
                '<li class="page-item"><a href="#" onclick="getPage(' + (Number(res.page) + 1) + ')" class="page-link">التالي</a></li>'
              );
            } else {
              $("#pagination").append(
                '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
              );
            }
          }
          $.each(res.data, function() {
            if (this.loc == 1) {
              lock = `<button  type="button" class="text-body btn-link btn" onclick="unlock(` + this.id + `)"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi-unlock fs-2"></i>
                      </button>`;
            } else {
              lock = `<button  type="button" class="text-body btn-link btn" onclick="loc(` + this.id + `)"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi-lock fs-2"></i>
                      </button>`;
            }
            $("#myAddedWorkshopsTable").append(
              `<tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                          <a href="?page=workshop.php&id=${this.id}"><h6 class="text-hover-primary mb-0 text-link">` + this.name + `</h6></a>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p>${this.office}</p>
                    </td>
                    <td>
                       <a href="?page=addedWorkshop.php&id=${this.id}" class="btn btn-info">الشهادات</a>
                    </td>
                    <td>
                       <button  type="button" class="btn btn-primary" onclick="emailWorkshop(` + this.id + `)"  data-bs-toggle="modal" data-bs-target="#emailModal">
                        تبليغ
                      </button>
                    </td>
                    <td>
                      <button  type="button" class="text-body btn-link btn" onclick="editWorkshop(` + this.id + `)" data-bs-toggle="modal" data-bs-target="#editModal">
                        <i class="bi-pen fs-2"></i>
                      </button>
                    </td>
                    <td>
                       <button  type="button" class="text-body btn-link btn" onclick="deleteWorkshop(` + this.id + `)"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi-trash fs-2"></i>
                      </button>
                    </td>                 
                    <td>
                    <a href="cerView.php?workshop=${this.id }" target="_blank">
                       <button  type="button" class="text-body btn-link btn" onclick="viewCer(` + this.id + `)"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi bi-file-earmark-pdf fs-2"></i>
                       </button>
                    </a>
                    </td>
                    <td>${lock}
                    </td>
                  </tr>`
            );
          });
        }
        console.log(res);
      },
      error: function(e) {
        $("#tb-myAddedWorkshopsTable").removeClass("loading");
        console.log(e);
      },
    });
  }
  getMyAddedWorkshops();

  function getPage(page) {
    $("#p").val(page);
    getMyAddedWorkshops();
  }

  function deleteWorkshop(id) {
    if (confirm("هل انت متاكد من الحذف")) {
      $.ajax({
        url: "script/_deleteWorkshop.php",
        type: "POST",
        data: {
          id: id
        },
        beforeSend: function() {
          $("#tb-myAddedWorkshopsTable").addClass("loading")
        },
        success: function(res) {
          $("#tb-myAddedWorkshopsTable").removeClass("loading");
          if (res.success == 1) {
            Toast.success('تم الحذف');
            alert('تم الحذف');
            getMyAddedWorkshops();
          } else {
            Toast.warning(res.msg);
            alert(res.msg);
          }
          console.log(res)
        },
        error: function(e) {
          $("#tb-myAddedWorkshopsTable").removeClass("loading");
          console.log(e);
        }
      });
    }
  }

  function emailWorkshop(id) {
    $("#workshop_id").val(id);
  }

  function sendEmail() {
    $.ajax({
      url: "script/_sendEmails.php",
      type: "POST",
      data: $("#SendEmailForm").serialize(),
      beforeSend: function() {
        $("#SendEmailForm").addClass("loading");
      },
      success: function(res) {
        console.log(res);
        $("#SendEmailForm").removeClass("loading");
        if (res.success == 1) {
          Toast.success('تم الارسال');
          alert('تم الارسال');
          $("#sub_err").text("");
          $("#body_err").text("");
          $("#sub").val("");
          $("#body").val("");
        } else {
          $("#sub_err").text(res.error["sub_err"][0]);
          $("#body_err").text(res.error["body_err"][0]);
          Toast.warning(res.msg);
          alert('خطأ');
        }
        console.log(res);
      },
      error: function(e) {
        $("#SendEmailForm").removeClass("loading");
        console.log(e);
      }
    });
  }

  function loc(id) {
    if (confirm("هل انت متاكد من اغلاق التسجيل")) {
      $.ajax({
        url: "script/_lock.php",
        type: "POST",
        data: {
          id: id
        },
        beforeSend: function() {
          $("#myAddedWorkshopsForm").addClass("loading");
        },
        success: function(res) {
          $("#myAddedWorkshopsForm").removeClass("loading");
          Toast.success(" تم ");
          console.log(res);
          getMyAddedWorkshops();
        },
        error: function(e) {
          $("#myAddedWorkshopsForm").removeClass("loading");
          Toast.warning(" حدث خطأ حاول مره اخرئ ");
          console.log(e);
        }
      });
    }
  }

  function unlock(id) {
    if (confirm("هل انت متاكد من فتح التسجيل")) {
      $.ajax({
        url: "script/_unlock.php",
        type: "POST",
        data: {
          id: id
        },
        beforeSend: function() {
          $("#myAddedWorkshopsTable").addClass("loading");
        },
        success: function(res) {
          $("#myAddedWorkshopsTable").removeClass("loading");
          Toast.success("تم");
          console.log(res);
          getMyAddedWorkshops();
        },
        error: function(e) {
          $("#myAddedWorkshopsTable").removeClass("loading");
          Toast.warning(" حدث خطأ حاول مره اخرئ ");
          console.log(e);
        }
      });
    }
  }
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

  function editWorkshop(id) {
    $("#workshop_id").val(id);
    $.ajax({
      url: "script/_getWorkshop.php",
      type: "POST",
      data: {
        id: id
      },
      beforeSent: function() {},
      success: function(res) {
        if (res.success == 1) {
          $.each(res.data, function() {
            $("#name").val(this.name);
            $("#sub_office").val(this.sub_office);
            $("#cat").val(this.category_id);
            $("#with").val(this.with_office);
            $("#seat").val(this.seat);
            $("#desc").val(this.des);
            $("#url").val(this.link);
            $("#start").val(this.start_date);
            $("#end").val(this.end_date);

            $("#space").val(this.space);
            $("#paddingTop").val(this.paddingTop);
            $("#textSize").val(this.textSize);

            $("#name1").val(this.name1);
            $("#name2").val(this.name2);
            $("#job1").val(this.job1);
            $("#job2").val(this.job2);
            var editor = tinymce.get('desc'); //the id of your textarea
            editor.setContent(this.des);
          });
        }
        console.log(res);
      },
      error: function(e) {
        console.log(e);
      },
    });
  }

  function updateWorkshop() {
    var myform = document.getElementById('editForm');
    var fd = new FormData(myform);
    fd.append("id", $("#workshop_id").val())
    $.ajax({
      url: "script/_updateWorkshop.php",
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
        $("#url_err").text('');
        $("#start_err").text('');
        $("#end_err").text('');
        if (res.success == 1) {
          Toast.success('تم التحديث');
          alert("تم التحديث");
        } else {
          $("#name_err").text(res.error["name_err"]);
          $("#sub_office_err").text(res.error["sub_office_err"]);
          $("#cat_err").text(res.error["cat_err"]);
          $("#with_err").text(res.error["with_err"]);
          $("#des_err").text(res.error["des_err"]);
          $("#url_err").text(res.error["url_err"]);
          $("#start_err").text(res.error["start_err"]);
          $("#end_err").text(res.error["end_err"]);
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