<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Paystack Payment Gateway</title>
    <style>
      body{
        background-color:bisque;
      }
    </style>
</head>
<body>

<h1 class="text-center text-danger mt-2 mb-2">Add/Make Payment By Paystack</h1>
{{--Success Payment Flash Session Redirect from Callback--}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
{{--Failed Payment--}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="mt-2 mb-2" style="text-align: right;">
    <a href="{{route('display')}}" class="btn btn-info">Manage Payment</a>
</div>
<div class="container">
    {{--email,amount required in Paystack--}}
<form id="paymentForm" autocomplete="off">
<div class="row g-2 mt-2 mb-2">
  <div class="col-md">
    <div class="form-floating">
      <input type="number" class="form-control" id="product_id" name="product_id" value="{{old('product_id')}}" required>
      <label for="product_id">Product Id</label>
    </div>
  </div>
  <div class="col-md">
    <div class="form-floating">
    <input type="text" class="form-control" id="product_name" name="product_name" value="{{old('product_name')}}" required>
      <label for="product_name">Product Name</label>
    </div>
  </div>
</div>

<div class="row g-2 mt-2 mb-2">
  <div class="col-md">
    <div class="form-floating">
      <input type="text" class="form-control" id="user_name" name="user_name" value="{{old('user_name')}}" required>
      <label for="user_name">User Name</label>
    </div>
  </div>
  <div class="col-md">
    <div class="form-floating">
    <input type="number" class="form-control" id="phone" name="phone" value="{{old('phone')}}" required>
      <label for="phone">Phone</label>
    </div>
  </div>
</div>

<div class="row g-2 mt-2 mb-2">
  <div class="col-md">
    <div class="form-floating">
      <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
      <label for="email">Email Address</label>
    </div>
  </div>
  <div class="col-md">
    <div class="form-floating">
    <input type="number" class="form-control" id="quantity" name="quantity" value="{{old('quantity')}}" required>
      <label for="quantity">Quantity</label>
    </div>
  </div>
</div>

<div class="row g-2 mt-2 mb-2">
  <div class="col-md">
    <div class="form-floating">
      <input type="number" class="form-control" id="price" name="price"  value="{{old('price')}}" required>
      <label for="price">Price</label>
    </div>
  </div>
  <div class="col-md">
  <div class="form-floating">
  <select class="form-select" id="currency" name="currency" required>
    <option value="" disabled selected>Select Currency</option>
    <option value="ZAR">ZAR / South Africa</option>
    <option value="NGN" disabled>NGN / Nigeria</option>
    <option value="KES" disabled>KES / Kenya </option>
  </select>
  <label for="currency">Currency</label><span class="text-danger">Right Now Only Accept ZAR</span>
</div>
 </div>
</div>
<div class="row g-2 mt-4 mb-2">
<button type="submit" class="btn btn-success" onclick="payWithPaystack()">Pay via Paystack</button>
</div>
    </form>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script> 
<script>
const paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener("submit", payWithPaystack, false);

function payWithPaystack(e) {
  e.preventDefault();
  let amount = document.getElementById("price").value;
  let quantity = document.getElementById("quantity").value;
   // Calculate total amount
  let totalAmount = amount * quantity * 100; 

  let handler = PaystackPop.setup({
    key:  "{{ env('PAYSTACK_PUBLIC_KEY') }}", // Public Key used inside env
    email: document.getElementById("email").value,
    amount: totalAmount,
    //currency :"KEN",
    currency : document.getElementById("currency").value,
    metadata: {
      "quantity": quantity, //or directly pass 10 //this can receive on response but not store on payment dashboard server
      "product_id": document.getElementById("product_id").value,
      "product_name": document.getElementById("product_name").value,
      "custom_fields": [    //it can be store on dashboard and also receive on response
      {
        "display_name": "User Name",   //that can be display
        "variable_name": "user_name",  //store inside this variable
        "value": document.getElementById("user_name").value        //value of the above variable
      },
      {
        "display_name": "Phone",   
        "variable_name": "phone",
        "value":  document.getElementById("phone").value
      }
    ],
    },
    
    onClose: function(){
      alert('Are You Sure to Cancel Payments');
    },
    callback: function(response){
      //alert(JSON.stringify(response));
      // let message = 'Payment completed ' + response.reference;
      //alert(message);
       window.location.href = "{{ route('callback') }}" + response.redirecturl;
    }
  });

  handler.openIframe();
}
</script>
</body>
</html>