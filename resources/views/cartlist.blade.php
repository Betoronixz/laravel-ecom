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
        <th scope="col">Image</th>
        <th scope="col">Price</th>
        <th scope="col">Quantity</th>
        <th scope="col">Total</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
        <?php $count= $totalprice =0; ?>
        @foreach ($data as $item)
        <?php $count++;?>
        <tr>
            <th scope="row">{{$count}}</th> 
            <td>{{$item->name}}</td>
            <td><img src="{{ asset('uploads/products/' . $item->gallery) }}" alt="" width="100px" srcset=""></td>
            <td>{{$item->price}}</td>
            <td>
              <form action="/edit-cart" method="POST">
                @csrf
                <input type="number" min="1" name="qty" value="{{$item->qty}}">
                <input type="hidden" name="id" value="{{$item->cart_id}}">
              
            </td>
            <td>{{$item->price *$item->qty}}</td>
            <?php
            $totalprice +=$item->price *$item->qty;
            ?>
            <td>
              <div class="btn-gorup">
                <button class="btn btn-info" type="submit"><i class="fa-solid fa-check"></i></button>
              </form>
                <a href="/delete_cart/{{$item->cart_id}}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
            </div>
            </td>
          </tr>
          
        @endforeach
        <tr>
          <td colspan="5" class="text-center"><b>Toatl Price</b></td>
          <td><b>{{$totalprice}}</b></td>
        </tr>
      
    </tbody>
  </table>
@endsection