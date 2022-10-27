<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>تسجيل الدخول</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.ico">

  <!-- Font -->
  <link href="@@vars.googleFont" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <!-- bundlecss:vendor [.] -->
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">

  <!-- CSS Front Template -->
  <!-- bundlecss:theme [.] @@vars.version -->
  <link rel="stylesheet" href="./assets/css/theme.min.css">
</head>

<body class="d-flex align-items-center min-h-100">
  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand navbar-light navbar-absolute-top">
    <div class="container-fluid">
      <nav class="navbar-nav-wrap">
        <!-- White Logo -->
        <a class="navbar-brand d-none d-lg-flex" href="./index.html" aria-label="جامعة بابل">
          <img class="navbar-brand-logo" src="./assets/svg/logos/logo2.png" alt="Logo">
        </a>
        <!-- End White Logo -->

        <!-- Default Logo -->
        <a class="navbar-brand d-flex d-lg-none" href="./index.php" aria-label="جامعة بابل">
          <img class="navbar-brand-logo" src="./assets/svg/logos/logo2.png" alt="Logo">
        </a>
        <!-- End Default Logo -->

        <div class="ms-auto">
          <a class="link link-sm link-secondary" href="./index.php">
            <i class="bi-chevron-left small ms-1"></i> الرئسية
          </a>
        </div>
      </nav>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main" class="flex-grow-1">
    <!-- Form -->
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 col-xl-4 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative bg-dark" style="background-image: url(./assets/svg/components/wave-pattern-light.svg);">
          <div class="flex-grow-1 p-5">
            <!-- Blockquote -->
            <figure class="text-center">
<!--              <div class="mb-4">
                <img class="avatar avatar-xl avatar-4x3" src="./assets/svg/brands/mailchimp-white.svg" alt="Logo">
              </div>-->

              <blockquote class="blockquote blockquote-light">“يسعى مركز الوسائط المتعددة والتعليم الالكتروني دائما لتوفير البرامج و التقنيات الحديثة لتسهيل مهمه التعليم الالكتروني”</blockquote>

              <figcaption class="blockquote-footer blockquote-light">
                <div class="mb-3">
                  <img class="avatar avatar-circle" src="./assets/img/160x160/img1.jpg" alt="Image Description">
                </div>
                مركز الوسائط المتعددة و التعليم الالكتروني
                <span class="blockquote-footer-source">تطوير و برمجة</span>
              </figcaption>
            </figure>
            <!-- End Blockquote -->

            <!-- Clients -->
            <div class="position-absolute start-0 end-0 bottom-0 text-center p-5">
              <div class="row justify-content-center">
<!--                <div class="col text-center py-3">
                  <img class="avatar avatar-lg avatar-4x3" src="./assets/svg/brands/fitbit-white.svg" alt="Logo">
                </div>-->
                <!-- End Col -->

<!--                <div class="col text-center py-3">
                  <img class="avatar avatar-lg avatar-4x3" src="./assets/svg/brands/business-insider-white.svg" alt="Logo">
                </div>-->
                <!-- End Col -->

<!--                <div class="col text-center py-3">
                  <img class="avatar avatar-lg avatar-4x3" src="./assets/svg/brands/capsule-white.svg" alt="Logo">
                </div>-->
                <!-- End Col -->
              </div>
              <!-- End Row -->
            </div>
            <!-- End Clients -->
          </div>
        </div>
        <!-- End Col -->

        <div class="col-lg-7 col-xl-8 d-flex justify-content-center align-items-center min-vh-lg-100">
          <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
            <!-- Heading -->
            <div class="text-center mb-5 mb-md-7">
              <h1 class="h2">مرحباً بك, في منصة جامعة بابل</h1>
              <p>انشئ حسابك للتسجيل في الدورات و الورش</p>
            </div>
            <!-- End Heading -->

            <!-- Form -->
            <form class="js-validate needs-validation" novalidate id="addStaffForm">
              <!-- Form -->
              <div class="mb-3">


                <label class="form-label" for="name">
<p style="color:red">
الاسم الكامل ( يجب ان يكون الاسم باللغة العربية وكما تحب ان يظهر في الشهادة )
</p>
</label>


                <input type="name" class="form-control form-control-lg" name="name" id="name" placeholder="" aria-label="مثال: محمد ابراهيم احمد" required>
                <span class="text-danger" id="name_err"></span>
              </div>
              <!-- End Form -->
              <!-- Form -->
              <div class="mb-3">
                <label class="form-label" for="email">البريد الالكتروني</label>
                <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="email@site.com" aria-label="email@site.com" required>
                <span class="text-danger" id="email_err"></span>
              </div>
              <!-- End Form -->

              <!-- Form -->
              <div class="mb-3">
                <label class="form-label" for="password">كلمة المرور</label>

                <div class="input-group input-group-merge" data-hs-validation-validate-class>
                  <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="password" placeholder="8+ رمز مطلوب" aria-label="8+ رمز مطلوب" required
                          data-hs-toggle-password-options='{
                             "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                             "defaultClass": "bi-eye-slash",
                             "showClass": "bi-eye",
                             "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                           }'>
                  <a class="js-toggle-password-target-1 input-group-append input-group-text" href="javascript:;">
                    <i class="js-toggle-passowrd-show-icon-1 bi-eye"></i>
                  </a>
                </div>

                <span class="text-danger" id="password_err"></span>
              </div>
              <!-- End Form -->

              <!-- Check -->
              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="signupHeroFormPrivacyCheck" name="signupFormPrivacyCheck" required>
                <label class="form-check-label small" for="signupHeroFormPrivacyCheck"> من خلال الضغط على تسجيل انت توافق علي <a href=./page-privacy.html>سياسة الخصوصية</a></label>
                <span class="invalid-feedback">سياسة الخصوصية.</span>
              </div>
              <!-- End Check -->

              <div class="d-grid mb-3">
                <button type="button" onclick="addUser()" class="btn btn-primary btn-lg">تسجيل</button>
              </div>

              <div class="text-center">
                <p>لديك حساب بالفعل؟ <a class="link" href="?page=login.php">سجل الدخول من هنا</a></p>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Form -->
  </main>
  <!-- ========== END MAIN CONTENT ========== -->

  <!-- JS Global Compulsory @@deleteLine:build -->
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <!-- bundlejs:vendor [.] -->
  <script src="./assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
 <script>
function addUser(){
  var myform = document.getElementById('addStaffForm');
  var fd = new FormData(myform);
  $.ajax({
    url:"script/_addUser.php",
    type:"POST",
    data:fd,
    processData: false,  // tell jQuery not to process the data
    contentType: false,
   	cache: false,
    beforeSend:function(){
      $("#addStaffForm").addClass('loading');
    },
    success:function(res){
      $("#addStaffForm").removeClass('loading');
      console.log(res);
       if(res.success == 1){
         $("#addStaffForm input").val("");
         Toast.success('تم الاضافة');
         $("#name_err").text('');
         $("#password_err").text('');
         $("#email_err").text('');
         $("#addStaffForm").html("<h1>تم التسجيل بنجاح. يرجى تاكيد البريد الالكتروني.</h1>.ان  لم تحصل على البريد الالكتروني في البريد الوارد يرجى تدقيق الرسائل البريد العشوائي (spam)")
       }else{
           $("#name_err").text(res.error["name_err"]);
           $("#email_err").text(res.error["email_err"]);
           $("#password_err").text(res.error["password_err"]);
           Toast.warning("هناك بعض المدخلات غير صالحة",'خطأ');
       }

    },
    error:function(e){
     $("#addStaffForm").removeClass('loading');
     console.log(e);
     Toast.error('خطأ');
    }
  });
}
  </script>
</body>
</html>
