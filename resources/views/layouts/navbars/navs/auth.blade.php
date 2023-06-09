<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#"><i class="material-icons">person</i>&nbsp;{{ __('jamia.hi') }}&nbsp;&nbsp;{{Auth::user()->name}}.... {{ __('jamia.welc_msg') }}</a></a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <form class="navbar-form">
        <div class="input-group no-border">
        <div>
          <li class="nav-item dropdown" style="margin-top: -39px;">
           <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             {{ Config::get('languages')[App::getLocale()] }}
           </a>
           <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
               @foreach (Config::get('languages') as $lang => $language)
               @if ($lang != App::getLocale())
                <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a>
               @endif
              @endforeach
           </div>
          </li>
        </div>
        </div>
      </form>
      <ul class="navbar-nav">
        
        
        <li class="nav-item dropdown">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="material-icons">person</i>{{ __('jamia.profile') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="material-icons">logout</i>{{ __('jamia.logout') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
