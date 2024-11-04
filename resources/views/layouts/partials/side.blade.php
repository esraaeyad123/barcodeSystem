<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-end me-2 rotate-caret bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute start-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" >
        <img src="" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="me-1 text-sm text-dark"> الدعوات</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse px-0 w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" href="{{ route('barcodes.create') }}">
                <i class="material-symbols-rounded opacity-10">dashboard</i>
                <span class="nav-link-text me-1">انشاء الأكواد</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('barcodes.index') }}">
            <i class="material-symbols-rounded opacity-10">table_view</i>
            <span class="nav-link-text me-1">الاكواد</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('barcodes.scan') }}">
            <i class="material-symbols-rounded opacity-10">receipt_long</i>
            <span class="nav-link-text me-1">مسح الأكواد </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-10">login</i>
            <span class="nav-link-text me-1">تسجيل الدخول</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="{{ route('showBarcodes') }}">
            <i class="material-symbols-rounded opacity-10">assignment</i>
            <span class="nav-link-text me-1">الدعوات</span>
          </a>
        </li>
      </ul>
    </div>

  </aside>
