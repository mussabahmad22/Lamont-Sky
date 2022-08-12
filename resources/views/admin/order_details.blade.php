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
                            <h5> Customer Information  </h5>
                        </div>
                        <div class="card-header pb-0 px-6">
                            <h7> <strong>Customer Name :-</strong> </h7>   &nbsp;&nbsp;&nbsp;&nbsp;<?= $query2->name ?><br>
                            <h7> <strong>User Name :-</strong> </h7>   &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?= $query2->username ?><br>
                            <h7> <strong>Date Of Birth :-</strong> </h7>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $query2->dob ?><br>
                            <h7> <strong>Address :-</strong> </h7>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $query2->address ?><br>
                            <h7> <strong>Contact Number :-</strong> </h7>   &nbsp;&nbsp;<?= $query2->phone ?><br>
                            <h7> <strong>Customer Email :- </strong></h7>   &nbsp;&nbsp; <?= $query2->email ?> <br>
                            <h7> <strong>Order Date :- </strong></h7>   &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $query2->created_at ?>
                        </div>
                        <br>

                        <div class="card-header pb-0">
                            <h5> Order Details </h5>
                        </div>
                        <!-- BEGIN: Datatable -->
                        <div class="intro-y datatable-wrapper box p-5 mt-1">
                            <table id="myTable" class="table table-report table-report--bordered display w-full">
                                <thead>
                                    <tr>
                                        <th class="border-b-2 whitespace-no-wrap">
                                            Sr.</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Product Name</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Product Price</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Product Quantity</th>

                                        <th class="border-b-2 whitespace-no-wrap">
                                            Total Price</th>
 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $i = 0; ?>
                                    @foreach($query as $que)
                                    <?php $i++; ?>
                                    <tr>
                                        <th scope="row">{{ $i }}</th>
                                        <td>
                                            <?= $que->product_name ?>
                                        </td>
                                    
                                        <td>
                                            <?= $que->price ?> $
                                        </td>
                                        <td>
                                            <?= $que->total_products ?> 
                                        </td>
                                        <td>
                                            <?= $que->total_price ?> $
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

    $(document).on('click', '.deletebtn', function () {
        var query_id = $(this).val();
        $('#deleteModal').modal('show');
        $('#deleting_id').val(query_id);
    });
</script>
@endsection