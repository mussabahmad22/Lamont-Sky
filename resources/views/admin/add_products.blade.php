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
                            <h5>{{$title}}</h5>
                        </div>
                        <div class="card-body pb-0 px-5">
                            <form type="submit" action="{{$url}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">

                                    <div class="grid grid-cols-12 gap-4 row-gap-5">
                                        <input type="hidden" class="form-control" id="query_id" name="query_id"
                                        value="{{ isset($product->id)?$product->id: ''  }}">
                                        <input type="hidden" class="form-control" id="cat_id" name="cat_id"
                                            value="{{ isset($product->cat_id)?$product->cat_id: $subcat->cat_id }}">
                                        <input type="hidden" class="form-control" id="subcat_id" name="subcat_id"
                                            value="{{ isset($product->subcat_id)?$product->subcat_id: $subcat->id }}">
                                        <div class="mb-3 ">
                                            <label class="form-label">Product Name*</label>
                                            <input type="text" class="form-control" name="product_name"  value="{{ isset($product->product_name)?$product->product_name:'' }}" required>
                                            <span class="text-danger"> 
                                                @error('product_name')
                                                {{'Product Name is required'}}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class="form-label">Upload Multiple Product Images (Atleast
                                                One*)</label>
                                            <input type="file" class="form-control" name="photos[]" multiple />
                                            <span class="text-danger">
                                                @error('photos')
                                                {{'Product Images is required'}}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="mb-3 ">
                                            <label class="form-label">Product Description*</label>
                                            <textarea type="text" class="form-control input-lg" name="desc" required>{{ isset($product->description)?$product->description:'' }}</textarea>
                                            <span class="text-danger">
                                                @error('desc')
                                                {{'Product Description is required'}}
                                                @enderror
                                            </span>
                                        </div> 
                                        <div class="mb-3 ">
                                            <label class="form-label">Product Price*</label>
                                            <input type="number" class="form-control" name="price" value="{{ isset($product->price)?$product->price:'' }}"  required>
                                            <span class="text-danger">
                                                @error('price')
                                                {{'Product Price is required and must be integer'}}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="btn" class="btn btn-dark px-5">{{$text}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection