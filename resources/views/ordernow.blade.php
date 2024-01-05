@extends('master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Order Page</h2>
                    </div>
                    <div class="card-body">
                        <form id="orderForm"  method="post">
                            @csrf   
                            <div class="mb-3">
                                <label for="product_name" class="form-label"> Name:</label>
                                <input type="text" class="form-control"  name="product_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Mobile Number:</label>
                                <input type="tel" class="form-control"  name="mobile" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Shipping Address:</label>
                                <textarea class="form-control" id="shipping_address" name="shipping_address" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Amount:</label>
                                <input type="tel" class="form-control"  name="amount" value="{{$data}}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Payment Method:</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="online">Online</option>
                                    <option value="cod">COD</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            var paymentMethod = document.getElementById('payment_method').value;
            
            if (paymentMethod === 'online') {
                // Set the form action to the 'session' route
                this.action = "{{ route('session') }}";
            } else {
                // Set the form action to the default 'placeorder' route
                this.action = "{{ route('placeorder') }}";
            }
        });
    </script>
@endsection
