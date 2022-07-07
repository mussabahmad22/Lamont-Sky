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
                            <h5> Categories</h5>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div style="float: right; margin-right:50px;">
                                <a href="{{route('category')}}"> <button type="button"
                                        class="btn btn-Success text- mb-dark">+ Manage
                                        Categories</button></a>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="container">
                                    <div class="row">
                                        @foreach($categories as $cat)
                                        <div class="col-lg-3 col-sm-6 mt-4">
                                            <div class="card bg-dark mb-3">
                                                <div class="card-header display-7 font-weight-bold ">{{$cat->category_name}}</div>
                                                <div class="card-body">
                                                    <span
                                                        class="display-7  text-white font-weight-bold px-0"></span>
                                                    <!-- <i class="ni ni-app  text-white font-weight-bold px-0"></i> -->
                                                  
                                                   <a href="{{route('subcategory',['id' =>$cat->id])}}"> <p class="card-text  text-white font-weight-bold px-0" id="users">
                                                        Sub Categories <i class="fas fa-arrow-circle-right"></i></p></a>
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