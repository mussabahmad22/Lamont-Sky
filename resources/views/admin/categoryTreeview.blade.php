@extends('admin.layouts.main')

@section('main-container')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header font-weight-bold pb-0">
                            <div class="panel-heading">Manage Category TreeView</div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-4 text-center bg-info text-white font-weight-bold pb-0">ADD New Menu</h5>
                                    <form accept="{{ route('menus.store')}}" method="post">
                                        @csrf
                                        @if(count($errors) > 0)
                                        <div class="alert alert-danger  alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">x</button>
                                            @foreach($errors->all() as $error)
                                            {{ $error }}<br>
                                            @endforeach
                                        </div>
                                        @endif
                                        @if ($message = Session::get('success'))
                                        <div class="alert alert-success  alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">x</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" name="title" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Parent</label>
                                                    <select class="form-control" name="parent_id">
                                                        <option selected disabled>Select Parent Menu</option>
                                                        @foreach($allCategories as $key => $value)
                                                        <option value="{{ $key }}">{{ $value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-secondary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="text-center mb-4 bg-dark font-weight-bold pb-0 text-white">Menu List</h5>
                                    <ul id="tree1">
                                        @foreach($categories as $menu)
                                        <li>
                                            {{ $menu->title }}
                                            @if(count($menu->childs))
                                            @include('admin.manageChild',['childs' => $menu->childs])
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('js/treeview.js')}}"></script>

@endsection