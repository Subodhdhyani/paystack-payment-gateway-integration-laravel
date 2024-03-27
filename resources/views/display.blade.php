<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Payment Display</title>
    <style>
      body{
        background-color:bisque;
      }
    </style>
</head>
<body>
    <h1 class="text-center mt-2 mb-2 text-success">All Payment</h1>
<div class="mt-2 mb-2" style="text-align: right;">
    <a href="{{route('welcome')}}" class="btn btn-info">Go TO Payment Page</a>
</div>

    {{--Refund Payment Flash Session Redirect from Refund controller--}}
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
   <div class="container">
   <table class="table  table-striped table-bordered">
             <thead>
                 <tr>
                   <th scope="col">Id</th>
                   <th scope="col" class="d-none d-sm-table-cell">Receipt No</th>
                   <th scope="col">Product Name</th>
                   <th scope="col">Quantity</th>
                   <th scope="col">Total Amount</th>
                   <th scope="col">Phone</th>
                   <th scope="col">Operation</th>
                </tr>
             </thead> <tbody>
             @foreach($data as $record)
             
                 <tr>
                   <td>{{$record->id}}</td>
                   <td class="d-none d-sm-table-cell">{{$record->receipt_no}}</td>
                   <td>{{$record->product_name}}</td>
                   <td>{{$record->quantity}}</td>
                   <td>{{$record->amount}}</td>
                   <td>{{$record->phone}}</td>
                   <td>
                    <a href="{{route('refund',$record->payment_id)}}" class="btn btn-success">Refund</a>
                   </td>
                  
                </tr>
   
              @endforeach
             </tbody>
         </table>
   </div> 
</body>
</html>