<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('jamia.jami') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="/home">
          <i class="material-icons">dashboard</i>
            <p>{{ __('jamia.dashboard') }}</p>
        </a>
      </li>
  
      {{-- <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Laravel Examples') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">`
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li> --}}
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}" >
        <a class="nav-link" href="/user/list">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.user') }}</p>
        </a>
      </li>
      @if(Auth::user()->userpermission(3))
      <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }}" >
        <a class="nav-link" href="/roles">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.role') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(2))
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}" >
        <a class="nav-link" href="/user/list">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.user') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(1))
      <li class="nav-item{{ $activePage == 'directors' ? ' active' : '' }}" >
        <a class="nav-link" href="/directors">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.director') }}</p>
        </a>
      </li>
      @endif
      <li class="nav-item{{ $activePage == 'news' ? ' active' : '' }}" >
        <a class="nav-link" href="/news">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.news_details') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'offer' ? ' active' : '' }}" >
        <a class="nav-link" href="/offers">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.offer') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'branch' ? ' active' : '' }}" >
        <a class="nav-link" href="/branch_category">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.branch') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'branches' ? ' active' : '' }}" >
        <a class="nav-link" href="/branches">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.brch') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'discardReport' ? ' active' : '' }}" >
        <a class="nav-link" href="/discard_report">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.discard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'offerCat' ? ' active' : '' }}" >
        <a class="nav-link" href="/offer_category">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.offer_cat') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'couponoffer' ? ' active' : '' }}" >
        <a class="nav-link" href="/coupon_offer">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.coupon_offer') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'complaint' ? ' active' : '' }}" >
        <a class="nav-link" href="/complaints">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.complaint') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'gallery' ? ' active' : '' }}" >
        <a class="nav-link" href="/galleries">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.gallery') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'medias' ? ' active' : '' }}" >
        <a class="nav-link" href="/medias">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.social') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
