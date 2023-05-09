 <style>
      .circle {
        border-radius: 50%;
        width: 10px;
        height: 5px;
        padding: 5px;
        background: #fff;
        border: 1px solid #000;
        color: #000;
        text-align: center;
        font: 12px Arial, sans-serif;
        border-color: red;
        color: white;
      }
    </style><div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://ebaakw.com/" class="simple-text logo-normal">
     <img src="{{ asset('images') }}/logojami.png" width="100" height="100" > {{ __('jamia.jami') }}
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
      @if(Auth::user()->userpermission(14)) 
      <li class="nav-item{{ $activePage == 'products' ? ' active' : '' }}" >
        <a class="nav-link" href="/products">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.product') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(2))  
      <li class="nav-item{{ $activePage == 'family_card' ? ' active' : '' }}" >
        <a class="nav-link" href="/family_card">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.user') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(18))
      <li class="nav-item{{ $activePage == 'profit' ? ' active' : '' }}" >
        <a class="nav-link" href="/customer_profit">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.profit') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(14))
      <li class="nav-item{{ $activePage == 'user' ? ' active' : '' }}" >
        <a class="nav-link" href="/user/list">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.emp') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(3))
      <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }}" >
        <a class="nav-link" href="/roles">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.role') }}</p>
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
      @if(Auth::user()->userpermission(4))
      <li class="nav-item{{ $activePage == 'news' ? ' active' : '' }}" >
        <a class="nav-link" href="/news">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.news_details') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(5))
      <li class="nav-item{{ $activePage == 'offer' ? ' active' : '' }}" >
        <a class="nav-link" href="/offers">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.offer') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(6))
      <li class="nav-item{{ $activePage == 'branch' ? ' active' : '' }}" >
        <a class="nav-link" href="/branch_category">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.branch') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(7))
      <li class="nav-item{{ $activePage == 'branches' ? ' active' : '' }}" >
        <a class="nav-link" href="/branches">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.brch') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(8))
      <li class="nav-item{{ $activePage == 'discardReport' ? ' active' : '' }}" >
        <a class="nav-link" href="/discard_report">
          <i class="material-icons">content_paste</i>
            <p style="display: inline;">{{ __('jamia.discard') }}</p>
            @if($discardCount > 0)<span class="notification circle" style="background: red;margin-left: 17px;">{{$discardCount}}</span>@endif
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(9))
      <li class="nav-item{{ $activePage == 'offerCat' ? ' active' : '' }}" >
        <a class="nav-link" href="/offer_category">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.offer_cat') }} </p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(10))
      <li class="nav-item{{ $activePage == 'couponoffer' ? ' active' : '' }}" >
        <a class="nav-link" href="/coupon_offer">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.coupon_offer') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(11))
      <li class="nav-item{{ $activePage == 'complaint' ? ' active' : '' }}" >
        <a class="nav-link" href="/complaints">
          <i class="material-icons">content_paste</i>
            <p style="display: inline;">{{ __('jamia.complaint') }} </p>
            @if($complaintCount > 0)<span class="notification circle" style="background: red;margin-left: 17px; display: inline;">{{$complaintCount}}</span>@endif
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(12))
      <li class="nav-item{{ $activePage == 'gallery' ? ' active' : '' }}" >
        <a class="nav-link" href="/galleries">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.gallery') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(13))
      <li class="nav-item{{ $activePage == 'medias' ? ' active' : '' }}" >
        <a class="nav-link" href="/medias">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.social') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(15))
      <li class="nav-item{{ $activePage == 'notification' ? ' active' : '' }}" >
        <a class="nav-link" href="/notifications">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.notification') }}</p>
        </a>
      </li>
      @endif
      @if(Auth::user()->userpermission(16))
      <li class="nav-item{{ $activePage == 'slideshows' ? ' active' : '' }}" >
        <a class="nav-link" href="/slideshows">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.slideshows') }}</p>
        </a>
      </li> 
      @endif
      @if(Auth::user()->userpermission(17))
      <li class="nav-item{{ $activePage == 'informations' ? ' active' : '' }}" >
        <a class="nav-link" href="/informations">
          <i class="material-icons">content_paste</i>
            <p>{{ __('jamia.information') }}</p>
        </a>
      </li>
      @endif
      
    </ul>
  </div>
</div>
