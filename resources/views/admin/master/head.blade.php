<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{asset('admin/assets/')}}/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Intransitee Admin CMS</title>

    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('logo/Logo2.png')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>
    {{-- <link href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css" rel="stylesheet"/> --}}

    {{-- datatable --}}
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/typeahead-js/typeahead.css')}}" />


    {{-- flatpickr --}}
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/flatpickr/flatpickr.css')}}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('admin/assets/vendor/js/helpers.js')}}"></script>

    <script src="{{asset('admin/assets/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('admin/assets/js/config.js')}}"></script>
  </head>
