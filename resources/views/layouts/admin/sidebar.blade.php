<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="{{ route('home') }}" class="app-brand-link">
        <span class="app-brand-logo demo">
          <img src="{{asset('assets/img/group 7.png')}}" alt="">
       </span>
         </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboards -->
      <li class="menu-item">
        <a
          href="{{ route('home') }}"

          class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Email">dasboard</div>

        </a>
      </li>


      <!-- Apps -->


      <!-- Pages -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-table"></i>
          <div data-i18n="Account Settings">table</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('ruangan.index') }}" class="menu-link">
              <div data-i18n="Account">ruangan</div>
            </a>
          </li>
          <li class="menu-item">
              <a href="{{ route('kategori.index') }}" class="menu-link">
                <div data-i18n="Connections">kategori</div>
              </a>
            </li>
          <li class="menu-item">
            <a href="{{ route('merk.index') }}" class="menu-link">
              <div data-i18n="Connections">merk</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('kondisi.index') }}" class="menu-link">
              <div data-i18n="Connections">kondisi</div>
            </a>
          </li>
          <li class="menu-item">
              <a href="{{ route('barang.index') }}" class="menu-link">
                <div data-i18n="Notifications">barang</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('detail_ruangan.index') }}" class="menu-link">
                <div data-i18n="Notifications">detail ruangan</div>
              </a>
            </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-desktop"></i>
          <div data-i18n="Authentications">peminjaman</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('pm_barang.index') }}" class="menu-link" >
              <div data-i18n="Basic">peminjaman barang</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('pm_ruangan.index') }}" class="menu-link" >
              <div data-i18n="Basic">peminjaman ruangan</div>
            </a>
          </li>

        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-wrench"></i>
          <div data-i18n="Misc">maintenance</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('m_barang.index') }}" class="menu-link">
              <div data-i18n="Error">maintenance barang</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('m_ruangan.index') }}" class="menu-link">
              <div data-i18n="Under Maintenance"> Maintenance ruangan</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-book"></i>
          <div data-i18n="User interface">laporan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('l_barang.index') }}" class="menu-link">
              <div data-i18n="Accordion">laporan peminjaman barang</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('l_ruangan.index') }}" class="menu-link">
              <div data-i18n="Alerts">laporan peminjaman ruangan</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('lm_barang.index') }}" class="menu-link">
              <div data-i18n="Badges">laporan maintenance barang</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('lm_ruangan.index') }}" class="menu-link">
              <div data-i18n="Buttons">laporan maintenance ruangan</div>
            </a>
          </li>



        </ul>
      </li>
      <!-- Components -->



    </ul>
  </aside>
