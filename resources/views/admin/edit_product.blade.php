@extends('admin.app')
@section('content')
@if(Session::has('message'))
<p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
    <div class="container mt-4">
        <h2>Edit Product</h2>

        <form action="{{route('admin.update_product',$data->id)}}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" class="form-control" id="price" value="{{$data->price}}" name="price" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{$data->description}}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" >
            </div>
    
            @if ($data->gallery)
            <img src="{{ asset('uploads/products/' . $data->gallery) }}" alt="Product Image">
            @endif

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
