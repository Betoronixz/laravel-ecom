@extends('admin.app')
@section('content')
    <div class="mb-3">
        <a href="add_product" class="btn btn-primary"><i class="fa-solid fa-square-plus"></i> Add Product</a>
    </div>
    <table id="myTable" class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $count = 0; ?>
            @foreach ($product as $item)
                <?php $count++; ?>
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->description }}</td>
                    <td><img src="{{ $item->gallery }}" width="100px" alt=""></td>
                    <td>Delete</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
