<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload JSON File</title>
    <!-- Add Bootstrap CSS (you may need to adjust the path) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{URL::to('/')}}">Home</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{URL::to('/transactions')}}">Transactions</a>
                </li>
            </ul>
        </div>
    </nav>
<div class="container">
    <h1>Transaction Data</h1>
    <table id="transactions-table" class="display">
        <thead>
            <tr>
                <th>User Email</th>
                <th>Paid Amount</th>
                <th>Currency</th>
                <th>Status Code</th>
                <th>Payment Date</th>
                <!-- Add more table headers as needed -->
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->email }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->currency }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>{{ $transaction->paymentDate }}</td>
                    <!-- Add more table data columns as needed -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include DataTables.js and initialize it -->
<link rel="stylesheet" href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.1/sl-1.7.0/datatables.min.css"/> 
<script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.1/sl-1.7.0/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactions-table').DataTable();
    });
</script>
