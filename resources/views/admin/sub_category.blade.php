@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h5> Sub-Categories Of "{{ $cat->category_name }}" </h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div style="float: right; margin-right:50px;">
                                <a href="{{route('showsubCategory',['id' =>$cat->id])}}"> <button type="button"
                                        class="btn btn-Success text-dark mb-0">+ Manage
                                        Sub Categories</button></a>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="container">
                                    <div class="row">
                                        @foreach($sub_categories as $cat)
                                        <div class="col-lg-3 col-sm-6 mt-4">
                                            <div class="card bg-dark mb-3">
                                                <div class="card-header font-weight-bold "></div>
                                                <div class="card-body">
                                                    <span
                                                        class="display-7  text-white font-weight-bold px-0">{{$cat->subcategory_name}}</span>
                                                    <i class="ni ni-chart-bar-32  text-white font-weight-bold px-0"></i>
                                                   <a href="{{route('products',['id' =>$cat->id])}}"> <p class="card-text  text-white font-weight-bold px-0" id="users">
                                                        Products <i class="fas fa-arrow-circle-right"></i></p></a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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