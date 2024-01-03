@extends('master')
@section('content')
<div class="container mt-5">
  <a class="btn btn-primary" href="ordernow">Order Now</a>
</div>
<table class="table mt-5 mx=-auto container">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Product Name</th>
        <th scope="col">Price</th>
        <th scope="col">Image</th>
      </tr>
    </thead>
    <tbody>
        <?php $count= 0 ?>
        @foreach ($data as $item)
        <?php $count++?>
        <tr>
            <th scope="row">{{$count}}</th> 
            <td>{{$item->name}}</td>
            <td>{{$item->price}}</td>
            <td><img src="{{$item->gallery}}" alt="" width="100px" srcset=""></td>
          </tr>
        @endforeach
      
    </tbody>
  </table>
@endsection