<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" /> -->
  <title>APIK</title>
  <link href="{{ Utility::loadAsset('assets/css/style.css') }}" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ Utility::loadAsset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
  <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" />
  <link rel="stylesheet" href="https://www.jqueryscript.net/demo/Year-Picker-Text-Input/yearpicker.css" />
  <link rel="stylesheet" href="{{ Utility::loadAsset('assets/css/datepicker.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <style>
    .offset-x {
      margin-left: 3.33333333%;
      margin-top: 1%;
    }

    .select2-container {
      width: 100% !important;
    }
  </style>
  <style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0 !important;
    }

    .dataTables_wrapper .dataTables_filter {
      margin-right: 0.8em !important
    }

    table.dataTable {
      width: 100% !important;
    }

    .input-disabled {
      background-color: #e9ecef;
      opacity: 1;
    }

    .input-disabled:focus {
      color: #212529;
      background-color: #e9ecef;
      opacity: 1;
      border-color: #ced4da;
      outline: 0;
      box-shadow: 0 0 0 0.25rem transparent;
    }

    .circle-tab-container {
      display: flex;
      align-items: center;
    }

    .circle-tab-container-box {
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    .circle-tab {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      text-align: center;
      padding-top: 8px;
      margin-right: 10px;
      font-weight: bold;
      border: 2px solid #ccc;
      background-color: #fff;
      color: #000;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .circle-tab,
    .step-label {
      display: block;
      text-align: center;
      font-size: 12px;
    }

    .circle-tab.active {
      background-color: #007bff;
      color: #fff;
      border-color: #007bff;
    }

    .line {
      flex: 1;
      border-top: 2px solid #ccc;
    }

    .btn-draf {
      --bs-btn-color: #000;
      --bs-btn-bg: white;
      --bs-btn-border-color: #000;
      --bs-btn-hover-color: #000;
      --bs-btn-hover-bg: white;
      --bs-btn-hover-border-color: white;
      --bs-btn-focus-shadow-rgb: 130, 138, 145;
      --bs-btn-active-color: #000;
      --bs-btn-active-bg: white;
      --bs-btn-active-border-color: #000;
      --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
      --bs-btn-disabled-color: #fff;
      --bs-btn-disabled-bg: white;
      --bs-btn-disabled-border-color: white;
    }

    .mode{
      font-size: 12px !important;
    }
  </style>
</head>

<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <!-- <a href="{{route('dashboard.index')}}" class="logo d-flex align-items-center">
        <x-img path="{{ Utility::loadAsset('assets/img/logo.webp') }}" islazy="true"></x-img>
        <span class="d-none d-lg-block">SIPAKSI</span>
      </a> -->
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        @if(Utility::hasMultiLevel())
        <li class="nav-item pe-3">
          <a class="nav-link nav-mode d-flex align-items-center pe-0" href="#">
            <span class="ps-2">{{Utility::getLevel()}}</span>
          </a>
        </li>
        @endif
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <x-img path="{{ Utility::loadAsset('assets/img/logo.webp') }}" alt='Profile' class="rounded-circle" :islazy="true"></x-img>
            <span class="d-none d-md-block dropdown-toggle ps-2">
              {{Utility::getName()}}
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Utility::getName()}}</h6>
              @if (Utility::isAlterMode())
                <span class="badge badge-sm bg-primary mode">Mode</span>
              @endif
              <span>{{Utility::getLevel()}}</span>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('account.index')}}">
                <i class="bi bi-gear"></i>
                <span>Account</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('auth.logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      @if(Session::get('level')=="guest")
      <x-sidebar-item-menu title="Dashboard" icon="bi bi-menu-button-wide" link="{{route('penilaian.index')}}" :active="Utility::stateMenu(['penilaian'],request())" />
      @else
      <x-sidebar-item-menu title="Dashboard" icon="bi bi-menu-button-wide" link="{{route('dashboard.index')}}" :active="Utility::stateMenu(['dashboard'],request())" />
      @endif
      
      @if(Session::get('level')=="admin")
      <x-sidebar-item-menu title="User" icon="bi bi-menu-button-wide" link="{{route('user.index')}}" :active="Utility::stateMenu(['user'],request())" />
      <x-sidebar-item-menu title="Matriks" icon="bi bi-menu-button-wide" link="{{route('matriks.index')}}" :active="Utility::stateMenu(['matriks'],request())" />
      @endif

      @if(Session::get('level')=="admin" || Session::get('level')=="prodi")
      <x-sidebar-item-menu title="LED" icon="bi bi-menu-button-wide" link="{{route('penilaian.index')}}" :active="Utility::stateMenu(['penilaian'],request())" />
      <x-sidebar-item-menu title="Dokumen Induk" icon="bi bi-menu-button-wide" link="{{route('dokumenInduk.index')}}" :active="Utility::stateMenu(['dokumenInduk'],request())" />
      @endif
    </ul>
  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    @yield('page-title')
    <section class="section dashboard">
      @yield('content')
    </section>
  </main>

  @if(Utility::hasMultiLevel())
  <div class="modal fade" id="modalChangeMode" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Peran Sebagai</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            @foreach (Utility::getLevels() as $level)
            <div class="col-6">
              <a href="{{route('changeMode',['mode'=>$level,'url'=>request()->route()->getName()])}}" class="btn btn-primary d-md-block" id="mode{{ucfirst($level)}}">{{ucfirst($level)}}</a>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
  <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
  <!-- <script src="{{ Utility::loadAsset('assets/js/main.js') }}"></script> -->
   <script>
    /**
    * Template Name: NiceAdmin
    * Updated: Mar 09 2023 with Bootstrap v5.2.3
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    */
    (function() {
      "use strict";

      /**
       * Easy selector helper function
       */
      const select = (el, all = false) => {
        el = el.trim()
        if (all) {
          return [...document.querySelectorAll(el)]
        } else {
          return document.querySelector(el)
        }
      }

      /**
       * Easy event listener function
       */
      const on = (type, el, listener, all = false) => {
        if (all) {
          select(el, all).forEach(e => e.addEventListener(type, listener))
        } else {
          select(el, all).addEventListener(type, listener)
        }
      }

      /**
       * Easy on scroll event listener 
       */
      const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
      }

      /**
       * Sidebar toggle
       */
      if (select('.toggle-sidebar-btn')) {
        on('click', '.toggle-sidebar-btn', function(e) {
          select('body').classList.toggle('toggle-sidebar')
        })
      }

      /**
       * Search bar toggle
       */
      if (select('.search-bar-toggle')) {
        on('click', '.search-bar-toggle', function(e) {
          select('.search-bar').classList.toggle('search-bar-show')
        })
      }

      /**
       * Navbar links active state on scroll
       */
      let navbarlinks = select('#navbar .scrollto', true)
      const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
          if (!navbarlink.hash) return
          let section = select(navbarlink.hash)
          if (!section) return
          if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
            navbarlink.classList.add('active')
          } else {
            navbarlink.classList.remove('active')
          }
        })
      }
      window.addEventListener('load', navbarlinksActive)
      onscroll(document, navbarlinksActive)

      /**
       * Toggle .header-scrolled class to #header when page is scrolled
       */
      let selectHeader = select('#header')
      if (selectHeader) {
        const headerScrolled = () => {
          if (window.scrollY > 100) {
            selectHeader.classList.add('header-scrolled')
          } else {
            selectHeader.classList.remove('header-scrolled')
          }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
      }

      /**
       * Back to top button
       */
      let backtotop = select('.back-to-top')
      if (backtotop) {
        const toggleBacktotop = () => {
          if (window.scrollY > 100) {
            backtotop.classList.add('active')
          } else {
            backtotop.classList.remove('active')
          }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
      }

      /**
       * Initiate tooltips
       */
      // var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      // var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      //   return new bootstrap.Tooltip(tooltipTriggerEl)
      // })

      /**
       * Initiate quill editors
       */
      if (select('.quill-editor-default')) {
        new Quill('.quill-editor-default', {
          theme: 'snow'
        });
      }

      if (select('.quill-editor-bubble')) {
        new Quill('.quill-editor-bubble', {
          theme: 'bubble'
        });
      }

      if (select('.quill-editor-full')) {
        new Quill(".quill-editor-full", {
          modules: {
            toolbar: [
              [{
                font: []
              }, {
                size: []
              }],
              ["bold", "italic", "underline", "strike"],
              [{
                  color: []
                },
                {
                  background: []
                }
              ],
              [{
                  script: "super"
                },
                {
                  script: "sub"
                }
              ],
              [{
                  list: "ordered"
                },
                {
                  list: "bullet"
                },
                {
                  indent: "-1"
                },
                {
                  indent: "+1"
                }
              ],
              ["direction", {
                align: []
              }],
              ["link", "image", "video"],
              ["clean"]
            ]
          },
          theme: "snow"
        });
      }

      /**
       * Initiate TinyMCE Editor
       */
      const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

      /**
       * Initiate Bootstrap validation check
       */
      var needsValidation = document.querySelectorAll('.needs-validation')

      Array.prototype.slice.call(needsValidation)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })

      /**
       * Initiate Datatables
       */
      const datatables = select('.datatable', true)
      datatables.forEach(datatable => {
        new simpleDatatables.DataTable(datatable);
      })

      /**
       * Autoresize echart charts
       */
      const mainContainer = select('#main');
      if (mainContainer) {
        setTimeout(() => {
          new ResizeObserver(function() {
            select('.echart', true).forEach(getEchart => {
              echarts.getInstanceByDom(getEchart).resize();
            })
          }).observe(mainContainer);
        }, 200);
      }

    })();
   </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://www.jqueryscript.net/demo/Year-Picker-Text-Input/yearpicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  @stack('scripts')
  <script>
    @if(Utility::hasMultiLevel())
    let modalChangeMode = new bootstrap.Modal(document.getElementById('modalChangeMode'));
    let btnDosen = document.getElementById('modeDosen');
    let btnReviewer = document.getElementById('modeReviewer');
    let btnChangeMode = $('.nav-mode');

    btnChangeMode.on('click', function(e) {
      e.preventDefault();
      modalChangeMode.show();
    });
    @endif

    $(".yearpicker").yearpicker();
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlidht: true,
      orientation: 'top'
    }).on('show', function(e) {
      // Mengatur posisi popover Datepicker ke center (middle).
      var $input = $(e.currentTarget);
      var $datepicker = $input.data('datepicker').picker;
      var $parent = $input.parent();
      var top = ($parent.offset().top - $datepicker.outerHeight()) + $parent.outerHeight();
      $datepicker.css({
        top: top,
        left: $parent.offset().left
      });
    });

    $('.datepicker-bottom').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlidht: true,
      orientation: 'bottom'
    }).on('show', function(e) {
      // Mengatur posisi popover Datepicker ke center (middle).
      var $input = $(e.currentTarget);
      var $datepicker = $input.data('datepicker').picker;
      var $parent = $input.parent();
      var bottom = ($parent.offset().bottom - $datepicker.outerHeight()) + $parent.outerHeight();
      $datepicker.css({
        bottom: bottom,
        left: $parent.offset().left
      });
    });
  </script>
</body>

</html>