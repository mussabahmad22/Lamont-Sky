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
                            <h5> Customer Orders List </h5>
                        </div>
                        <!-- BEGIN: Datatable -->
                        <div class="intro-y datatable-wrapper box p-5 mt-1">
                            <table id="myTable" class="table table-report table-report--bordered display w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 whitespace-no-wrap">
                                            Sr.</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            User Name</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Order Description</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Total Product Quantity</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Total Price</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Status</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Order Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $i = 0; ?>
                                    @foreach($query as $que)
                                    <?php $i++; ?>
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>
                                            <?= $que->name ?>
                                        </td>
                                        <td>
                                            <?= $que->order_desc ?>
                                        </td>
                                        <td>
                                            <?= $que->total_items ?>
                                        </td>
                                        <td>
                                            <?= $que->total_price ?> $
                                        </td>
                                        <td>
                                            <select name="status" onchange="changeStatus({{$que->id}},this.value)"
                                                class=" border-0 " id="" class="category" aria-label value="">
                                                <option value="0" name="status_value" <?php echo ( $que->status ==
                                                    0)?'selected' : ""; ?> >Pending</option>

                                                <option value="1" <?php echo ( $que->status == 1) ? 'selected' : "" ; ?>
                                                    >Approved
                                                </option>

                                                <option value="2" <?php echo ( $que->status == 2) ? 'selected' : "" ; ?>
                                                    >Cancel
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <a class="flex items-center text-theme-1 mr-3  text-primary"
                                                href="{{route('order_details',['id' => $que->id])}}">
                                                <i class="fa fa-eye" aria-hidden="true"></i> view </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });

    function changeStatus(id, val) {
        console.log(id);
        console.log(val);
        $.ajax({
            url: "{{route('status')}}",
            data: {
                id: id,
                val: val
            },
            success: function (result) {
                swal({
                    title: "Status Changed",
                    text: "You have Successfully Change this Status",
                    icon: "success",
                    button: "OK",
                });
            }
        });
    }

    $(document).on('click', '.deletebtn', function () {
        var query_id = $(this).val();
        $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });


</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection