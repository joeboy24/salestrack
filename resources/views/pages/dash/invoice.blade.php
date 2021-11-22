
<html>

<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<link href="/maindir/css/inv_style.css" rel="stylesheet">
	<link href="/maindir/css/responsive.css" rel="stylesheet">
    <link href="/maindir/css/bootstrap2.min.css" rel="stylesheet">
    <link href="/maindir/css/font-awesome.min.css" rel="stylesheet">
</head>

<body style="background: #eee">

    <section id="invoice">
        <div class="invoiceContent">

            <div class="invHeaderTop">
                <h1>ROYAL JOYAM</h1>
                <h4>Ventures</h4>
                <P class="locInfo">{{$company->address}}</P>
                <P class="contactInfo">{{$company->contact}}, {{$company->email}}</P>
            </div>

            <div style="height: 50px">
            </div>
            
            <!--div class="invHeaderMid">
                <div class="row">
                    <div class="col-sm-4 delAdd">
                        <p>John Doe Fullname</p>
                        <p>Any Streetno. 172</p>
                        <p>Some City, Box 123</p>
                        <p>Canada</p>
                    </div>
                    <div class="col-sm-4 delAdd2">
                        <h4>Ship-to Address</h4>
                        <p>John Doe Fullname</p>
                        <p>Any Streetno. 172</p>
                        <p>Some City, Box 123</p>
                        <p>Canada</p>
                        <h2>INVOICE</h2>
                    </div>
                    <div class="col-sm-4">
                    
                    </div>
                </div>
            </div-->

            <div class="invCenter">
                <table class="invCenterTbl">
                    <tbody>
                        <tr>
                            <td class="col-sm-3">Net Total :<br><br></td>
                            <td class="col-sm-3"><b>GhC {{number_format(Session::get('net'))}}.00</b><br><br></td>
                            
                        </tr>
                        <tr>
                            <td class="col-sm-3">Date From :</td>
                            <td class="col-sm-3">{{date("d-m-Y", strtotime(Session::get('date_from')))}}</td>
                            <td class="col-sm-2"><b>Tot. Quantity :</b></td>
                            <td class="col-sm-4">{{$sales->sum('qty')}}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3">Date To :</td>
                            @if(Session::get('date_to') == '')
                                <td class="col-sm-3"> - </td>
                            @else
                                <td class="col-sm-3">{{date("d-m-Y", strtotime(Session::get('date_to')))}}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="col-sm-3"></td>
                            <td class="col-sm-3"></td>
                            <td class="col-sm-2">Sales Person :</td>
                            <td class="col-sm-4">Royal Joham V... {{$company->contact}}</td>
                        </tr>
                        <tr>
                            <td class="col-sm-3">Payment Methods :</td>
                            <td class="col-sm-3">Cash/Cheque/Momo..</td>
                            <td class="col-sm-2">Report Date :</td>
                            <td class="col-sm-4">{{date('d-m-Y')}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="invBottom">
                <table class="invBottomTbl">
                    <thead>
                        <th>#</th>
                        <th>Order No. / Description</th>
                        <th class="pr">Total(GhC)</th>
                        <th class="pr">Status</th>
                        <th class="pr">Date</th>
                    </thead>
                    <tbody>
                        @if(count($sales) > 0)
                            @foreach ($sales as $sale)
                              <tr>
                                <td class="col-sm-1">{{$count++}}</td>
                                <td class="col-sm-6"><h4>{{$sale->order_no}}</h4><p>Paid by {{$sale->buy_name}} &nbsp;&nbsp;&nbsp; Tel: {{$sale->buy_contact}}<br>
                                    Pay Mode: {{$sale->pay_mode}} &nbsp;&nbsp; Qty.: {{$sale->qty}}</p></td>
                                <td class="col-sm-1 pr">{{number_format($sale->tot)}}.00</td>
                                <td class="col-sm-2 pr">{{$sale->del_status}}</td>
                                <td class="col-sm-2 pr">{{$sale->created_at}}</td>
                              </tr>
                            @endforeach
                        @else
                            <p>No records to print out</p>
                        @endif
                        <!--tr>
                            <td class="col-sm-1">2</td>
                            <td class="col-sm-6"><h4>U231755321-0732    Paypal</h4><br><p>Visa card transaction</td>
                            <td class="col-sm-1 pr">3</td>
                            <td class="col-sm-2 pr">72.00</td>
                            <td class="col-sm-2 pr">216.00</td>
                        </tr>
                        <tr>
                            <td class="col-sm-1">3</td>
                            <td class="col-sm-6"><h4>M921765327-0137    Alesis</h4><br><p>V61 USB-MIDI Keyboard Controller (Black)</p></td>
                            <td class="col-sm-1 pr">1</td>
                            <td class="col-sm-2 pr">108.40</td>
                            <td class="col-sm-2 pr">108.40</td>
                        </tr-->
                        
                        <tr>
                            <td class="col-sm-1"></td>
                            <td class="col-sm-6"><h4>Expenditure</h4>
                                <br>Branch 1: {{substr(Session::get('branch_A'), 0,17)}}...
                                <br>Branch 2: {{substr(Session::get('branch_B'), 0,17)}}...
                                <br>Branch 3: {{substr(Session::get('branch_C'), 0,17)}}...
                                <br>Total:
                            </td>
                            <td class="col-sm-1 pr"><br>
                                <br>{{Session::get('exp_b1')}}
                                <br>{{Session::get('exp_b2')}}
                                <br>{{Session::get('exp_b3')}}
                                <br>{{Session::get('expenses')->sum('expense_cost')}}</td>
                            <td class="col-sm-2 pr"> - </td>
                            <td class="col-sm-2 pr"> - </td>
                        </tr>

                        <tr>
                            <td class="col-sm-1"></td>
                            <td class="col-sm-6"><h4>Profits</h4>
                                <br>Branch 1: {{substr(Session::get('branch_A'), 0,17)}}...
                                <br>Branch 2: {{substr(Session::get('branch_B'), 0,17)}}...
                                <br>Branch 3: {{substr(Session::get('branch_C'), 0,17)}}...
                                <br>Total:
                            </td>
                            <td class="col-sm-1 pr">
                                <br>{{Session::get('b1_profits')}}
                                <br>{{Session::get('b2_profits')}}
                                <br>{{Session::get('b3_profits')}}
                                <br>{{Session::get('gen_profits')}}</td>
                            <td class="col-sm-2 pr"> - </td>
                            <td class="col-sm-2 pr"> - </td>
                        </tr>

                        <tr>
                            <td class="col-sm-1"></td>
                            <td class="col-sm-6"></td>
                            <td class="col-sm-1 pr"></td>
                            <td class="col-sm-2 pr">VAT</td>
                            <td class="col-sm-2 pr">0.00</td>
                        </tr>
                        <tr class="invTot">
                            <td class="col-sm-1">Gross <h4>Total</h4><br></td>
                            <td class="col-sm-6"></td>
                            <td class="col-sm-1 pr"><h4>GhC&nbsp;{{Session::get('gross')}}</h4></td>
                            <td class="col-sm-2 pr"><h4></h4></td>
                            <td class="col-sm-2 pr"></td>
                        </tr>
                        <tr class="invTot">
                            <td class="col-sm-1">Net Total</td>
                            <td class="col-sm-6"></td>
                            <td class="col-sm-1 pr">GhC&nbsp;{{Session::get('net')}}</td>
                            <td class="col-sm-2 pr"><h4></h4></td>
                            <td class="col-sm-2 pr"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</body>

</html>