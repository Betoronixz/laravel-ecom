@extends('admin.app')
@section('content')
@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
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
                    <td>
                        <div class="btn-gorup">
                            <a href="{{route("admin.edit_product",$item->id)}}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
