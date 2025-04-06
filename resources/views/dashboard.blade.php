@extends('layout.main')
@section('main', 'Dashboard')


@section('content')
<h2>Dashboard</h2>
<div class="row">
    <div class="col-12 col-xl-12 grid-margin stretch-card">
      <div class="row w-100 flex-grow">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <p class="card-title">Website Audience Metrics</p>
              <p class="text-muted">25% more traffic than previous week</p>
              <div class="row mb-3">
                <div class="col-md-7">
                  <div class="d-flex justify-content-between traffic-status">
                    <div class="item">
                      <p class="mb-">Users</p>
                      <h5 class="font-weight-bold mb-0">93,956</h5>
                      <div class="color-border"></div>
                    </div>
                    <div class="item">
                      <p class="mb-">Bounce Rate</p>
                      <h5 class="font-weight-bold mb-0">58,605</h5>
                      <div class="color-border"></div>
                    </div>
                    <div class="item">
                      <p class="mb-">Page Views</p>
                      <h5 class="font-weight-bold mb-0">78,254</h5>
                      <div class="color-border"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-5">
                  <ul class="nav nav-pills nav-pills-custom justify-content-md-end" id="pills-tab-custom"
                    role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="pills-home-tab-custom" data-toggle="pill"
                        href="#pills-health" role="tab" aria-controls="pills-home" aria-selected="true">
                        Day
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-profile-tab-custom" data-toggle="pill" href="#pills-career"
                        role="tab" aria-controls="pills-profile" aria-selected="false">
                        Week
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="pills-contact-tab-custom" data-toggle="pill" href="#pills-music"
                        role="tab" aria-controls="pills-contact" aria-selected="false">
                        Month
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
              <canvas id="audience-chart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Area chart</h4>
          <canvas id="areaChart"></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Doughnut chart</h4>
          <canvas id="doughnutChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../../js/chart.js"></script>
  <!-- End custom js for this page-->

@endsection
