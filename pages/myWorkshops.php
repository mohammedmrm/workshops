<?php require_once("top.php"); ?>
<link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
<!-- End Col -->
<div class="col-lg-9">
  <!-- Card -->
  <div class="card">
    <div class="row">
      <div class="card-header col-6">
        <h5 class="card-header-title">النشاطات المشترك بها</h5>
      </div>
      <div class="card-header col-6">
        <select class="form-control form-select" id="title">
          <option value=''>-- اختر لقب عند تحميل شهادة المشاركة--</option>
          <option value='السيد'>السيد</option>
          <option value='السيدة'>السيدة</option>
          <option value='الانسة'>الانسة</option>
          <option value='م.م'>م.م</option>
          <option value='م'>م</option>
          <option value='أ.م.د'>أ.م.د</option>
          <option value='أ.د'>أ.د</option>
        </select>
      </div>
    </div>
    <form id="UsersForm">
      <!-- Table -->
      <div class="table-responsive table-striped">
        <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
          <thead class="thead-light">
            <tr>
              <th>اسم الدورة</th>
              <th>الرابط</th>
              <th>الجهة المنظمه</th>
              <th>الشهادة</th>
              <th style="width: 5%;"></th>
            </tr>
          </thead>

          <tbody id="usersTable">

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
<input type="hidden" value="<?php echo $_GET['id']; ?>" id="workshop_id">
<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
  function getMyWorkshops() {
    $.ajax({
      url: "script/_getMyWorkshop.php",
      type: "POST",
      data: $("#UsersForm").serialize(),
      beforeSent: function() {
        $("#usersTable").addClass("loading");
      },
      success: function(res) {
        $("#usersTable").removeClass("loading");
        $("#usersTable").html("");
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
            if (this.download_cer == 1) {
              cert = `<button type="button"  class="text-body btn-link btn" onclick="downloadCer(` + this.id + `)"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi bi-card-heading fs-2 btn-link"></i>
                       </button>`

            } else {
              cert = "غير مفعلة";
            }
            $("#usersTable").append(
              `<tr>
                    <td>
                      <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                          <h6 class="text-hover-primary mb-0">` + this.name + `</h6>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p><a href="` + this.link + `">رابط النشاط</a></p>
                    </td>
                    <td>
                      <p>` + this.office + `</p>
                    </td>
                    <td>
                       ` + cert + `
                    </td>
                  </tr>`
            );
          });
        }
        console.log(res);
      },
      error: function(e) {
        $("#usersTable").removeClass("loading");
        console.log(e);
      },
    });
  }
  getMyWorkshops();

  function getPage(page) {
    $("#p").val(page);
    getMyWorkshops();
  }

  function downloadCer(id) {
    window.open("cer.php?workshop=" + id + "&title=" + $("#title").val());
  }
</script>
<?php require_once("bottom.php"); ?>