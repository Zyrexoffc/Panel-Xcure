@extends('layouts.admin')
<?php 
    // Define extension information.
    $EXTENSION_ID = "darkenate";
    $EXTENSION_NAME = stripslashes("Darkenate");
    $EXTENSION_VERSION = "v2.0.3";
    $EXTENSION_DESCRIPTION = stripslashes("A dark theme inspired by bloom.host's colors and the Recolor theme");
    $EXTENSION_ICON = "/assets/extensions/darkenate/icon.jpg";
    $EXTENSION_WEBSITE = "https://github.com/blueprint-community/extension-darkenate";
    $EXTENSION_WEBICON = "bi bi-github";
?>
@include('blueprint.admin.template')

@section('title')
    {{ $EXTENSION_NAME }}
@endsection

@section('content-header')
    @yield('extension.header')
@endsection

@section('content')
    @yield('extension.config')
    @yield('extension.description')<div class="row">
  <div class="col-xs-3">

    <!-- Overview -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class='bx bx-command' style='margin-right:5px;'></i>Overview</h3>
      </div>
      <div class="box-body">
        <p>You are currently running version <code>v2.0.3</code>.</p>
      </div>
    </div>

  </div>
</div>
@endsection
