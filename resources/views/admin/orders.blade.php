@extends('admin.app')
@section('content')
@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
   
    <table id="myTable" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Product Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; ?>
            @foreach ($data as $item)
                <?php $count++; ?>
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $item->user_name }}</td>
                    <td>{{ Str::ucfirst($item->product_name) }}</td> {{-- Adjust this based on your actual data --}}
                    <td>{{ $item->mobile }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ Str::ucfirst($item->status) }}</td>
                    <td>{{ Str::upper($item->paymnet_method) }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
@endsection
