@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('')])

@section('content')
<img src="{{ asset('images') }}/logojami.png" width="150" height="150"><div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h1 class="text-white text-center">{{ __('jamia.welcome') }}</h1>

      </div>
  </div>
</div></img>
@endsection
