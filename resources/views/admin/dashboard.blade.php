@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <!-- <div class="container-fluid">
      <h4 class="display-7 text-white font-weight-bold px-0">
        Dashboard
      </h4> -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <!-- <h6>Authors table</h6> -->
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-dark mb-3">
                        <div class="card-header font-weight-bold ">Total Categories</div>
                        <div class="card-body">
                          <span class="display-2  text-white font-weight-bold px-0">{{ $categories }}</span>
                          <i class="ni ni-app  text-white font-weight-bold px-0"></i>
                          <!-- <p class="card-text  text-white font-weight-bold px-0" id="users"> Manage Categories <i
                              class="fas fa-arrow-circle-right"></i></p> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-dark mb-3">
                        <div class="card-header font-weight-bold ">Total Sub-Categories</div>
                        <div class="card-body">
                          <span class="display-2  text-white font-weight-bold px-0">{{ $subcat }}</span>
                          <i class="ni  ni-chart-bar-32  text-white font-weight-bold px-0"></i>
                          <!-- <p class="card-text  text-white font-weight-bold px-0" id="users">Manage Sub-Category <i
                              class="fas fa-arrow-circle-right"></i></p> -->
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-4">
                      <div class="card  bg-dark mb-3">
                        <div class="card-header font-weight-bold ">Total Products</div>
                        <div class="card-body">
                          <span class="display-2  text-white font-weight-bold px-0">{{ $products }}</span>
                          <i class="ni fas fa-chart-pie text-white font-weight-bold px-0"></i>
                          <!-- <p class="card-text  text-white font-weight-bold px-0" id="users"> Manage Products <i
                              class="fas fa-arrow-circle-right"></i></p> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection