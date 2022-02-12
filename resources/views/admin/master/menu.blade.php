<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link"></a>
    <img src="{{asset('logo/Logo2.png')}}" width="50" class="mt-2" height="auto" alt="">
    <span class="app-brand-text demo menu-text fw-bold ms-2" style="font-size: 24px">intransitee</span>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
        <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
      </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
    <li class="menu-header small text-uppercase"><span class="menu-header-text">Operational Apps</span></li>
      <li class="menu-item @if (Request::segment(1) == "dashboard") active @else '' @endif">
        <a href="javascript:void(0);" onclick="gotoDasboard()" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Dashboards">Dashboards</div>
        </a>
      </li>

      <li class="menu-item @if (Request::segment(1) == "clients") active @else '' @endif">
        <a href="javascript:void(0);" onclick="gotoClient()" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-user"></i>
          <div data-i18n="Client">Client</div>
        </a>
      </li>

      <li class="menu-item @if (Request::segment(1) == "orders") active @else '' @endif">
        <a href="javascript:void(0);" onclick="gotoOrder()" class="menu-link">
          <i class="menu-icon tf-icons bx bx-send"></i>
          <div data-i18n="Order">Order</div>
        </a>
      </li>

    </ul>
  </aside>

<script type="text/javascript">

    function gotoClient() {
        window.location.href = '{{ route('client.client') }}';
    }

    function gotoDasboard() {
        window.location.href = '{{ route('dashboard') }}';
    }

    function gotoOrder() {
        window.location.href = '{{ route('order.order') }}';
    }

</script>

