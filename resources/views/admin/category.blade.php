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
                                <button type="button" class="btn btn-Success text-dark mb-0" data-toggle="modal"
                                    data-target="#exampleModal">+ Add
                                    Categories</button>
                            </div>
                            <!-- BEGIN: Datatable -->
                            <div class="intro-y datatable-wrapper box p-5 mt-1">
                                <table id="categorytbl"
                                    class="table table-report  table-report--bordered display w-full">
                                    <thead>
                                        <tr>
                                            <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                Sr.</th>
                                            <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                Category Name</th>

                                            <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                Image</th>


                                            <th class="border-b-2  whitespace-no-wrap whitespace-no-wrap">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  $i = 0; ?>
                                        @foreach($category as $value)
                                        <?php $i++; ?>
                                        <tr>
                                            <th scope="row">{{ $i }}</th>
                                            <td>
                                                {{ $value->category_name }}
                                            </td>
                                            <td>
                                                <img src="{{asset('public/storage/'. $value->img)}}" width="50"
                                                    height="50">
                                            </td>
                                            <td>
                                                <button style="border:none;" type="button" value="{{$value->id}}"
                                                    class="editbtn btn"><a
                                                        class="flex items-center text-theme-1 mr-3 text-info "
                                                        data-toggle="modal" data-target="#myModal1" href=""><img
                                                            src="{{asset('img/edit.svg')}}">
                                                        Edit </a></button>

                                                <button style="border:none;" type="button" value="{{$value->id}}"
                                                    class="deletebtn btn"><a
                                                        class="flex items-center text-theme-1 mr-3  text-danger "
                                                        data-toggle="modal" data-target="#myModal" href=""> <img
                                                            src="{{asset('img/del.svg')}}">
                                                        Delete </a></button>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- //======================Delete Category Modal================================= -->
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Category
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form type="submit" action="{{route('category_delete')}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                            <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                <input type="hidden" name="delete_category_id" id="deleting_id"></input>
                                                <p>Are you sure! want to Delete Category?</p>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="flex items-center text-theme-1 mr-3 btn text-secondary"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit"
                                        class="flex items-center text-theme-1 mr-3 btn text-danger">Delete</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ==============================ADD Category Modal============================================ -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Category*</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form type="submit" action="{{route('addCategory')}}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="intro-y col-span-12 lg:col-span-8 p-5">

                                            <div class="grid grid-cols-12 gap-4 row-gap-5">

                                                <div class="mb-3 ">
                                                    <label class="form-label">Category Name*</label>
                                                    <input type="text" class="form-control" 
                                                        name="category_name" required>
                                                    <span class="text-danger">
                                                        @error('category_name')
                                                        {{'Category Name is required'}}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label ">Category Image*</label><br>
                                                    <input class="form-control" type="file" name="img" accept="image/*"
                                                        required>
                                                    <span class="text-danger">
                                                        @error('img')
                                                        {{ 'Category Image is required' }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="flex items-center text-theme-1 mr-3 btn text-dark" data-dismiss="modal">Close</button>
                                    <button type="submit" class="flex items-center text-theme-1 mr-3 btn text-success">Save</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- ======================== Update Category Modal==================================== -->
                    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabe3" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabe3">Update Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form type="submit" action="{{route('category_update')}}" method="post"  enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="intro-y col-span-12 lg:col-span-8 p-5">
                                            <div class="grid grid-cols-12 gap-4 row-gap-5">
                                                <input type="hidden" name="query_id" id="query_id"></input>
                                                <div class="mb-3 ">
                                                    <label class="form-label">Category Name*</label>
                                                    <input type="text" class="form-control" id="cat_name"
                                                        name="category_name" required>
                                                    <span class="text-danger">
                                                        @error('category_name')
                                                        {{'Category Name is required'}}
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label ">Category Image*</label><br>
                                                    <input class="form-control" type="file" name="img" accept="image/*">
                                                    <span class="text-danger">
                                                        @error('img')
                                                        {{ 'Category Image is required' }}
                                                        @enderror
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="flex items-center text-theme-1 mr-3 btn text-dark" data-dismiss="modal">Close</button>
                                    <button type="submit" class="flex items-center text-theme-1 mr-3 btn text-success">Update</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#categorytbl').DataTable();
    });

    //===================Script For Delete Exercise ====================================
    $(document).on('click', '.deletebtn', function () {
        var query_id = $(this).val();
        $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });
</script>
<script>
    $(document).ready(function () {

        //===================Script For Edit Exercise ====================================
        $(document).on('click', '.editbtn', function () {
            var query_id = $(this).val();
            console.log(query_id);


            $.ajax({
                type: "GET",
                url: "edit_category/" + query_id,
                success: function (response) {
                    console.log(response);
                    $('#query_id').val(query_id);
                    $('#cat_name').val(response.category.category_name);
                }
            });

        });
    });
</script>

@endsection