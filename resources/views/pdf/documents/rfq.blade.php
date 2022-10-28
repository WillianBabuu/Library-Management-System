<!DOCTYPE html>

<html>

<head>

    <title>RFQ Document</title>  

</head>

<style type="text/css"> 

    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .text-right {
        text-align: right;
    }
    .text-bold{
        text-decoration: bold;
    }

    table{

        width: 100%;

        border-collapse: collapse;

    } 

    table td, table th{  

        border:1px solid black;

        text-align: center;

    } 

    table tr, table td{

        padding: 5px;

    } 

</style>

<body>

    <div class="container"> 

    <br/>

        <h2 class="text-center">{{ $company->name }}</h2>
        <h2 class="text-center">{{ $company->country }}</h2>
        <div class="text-center">
            
            {{-- <img src="{{ asset($company->logo) }}" /> --}}
            </div> 
            <h4 class="text-center">RFQ Document</h4>
            <p class="text-right text-bold">Date:.....................</p>
            <p class="text-left text-bold">To:............................</p>
            <p class="text-center text-bold">Doc No. {{ $rfq->doc_no}}</p>
        <table> 
            <tr>  
                <th>s/n</th> 
                <th>Description of Supplies or Services</th>  
                <th>Quantity Required</th>  
                <th>Unit Price</th>  
                <th>Extended Price</th>  
            </tr>  

            @foreach ($rfqItems as $item)
            <tr >  
                <th></th>  
                <th>{{ $item->item_name }}</th> 
                <th>{{ $item->quantity }}</th>  
                <th></th>  
                <th></th>  
            </tr> 
            @endforeach

        </table>  
        <p class="text-left text-bold">Authorized Signature:.....................</p>
        <p class="text-left text-bold">Name of Signatory:............................</p>
        <p class="text-left text-bold">Date & Official Stamp: ...........................</p>

    </div>  

</body>

</html>