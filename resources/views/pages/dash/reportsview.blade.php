@extends('layouts.dashlay')

@section('sidebar-wrapper')
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/dashboard">
          <i class="material-icons">dashboard</i> 
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/config">
          <i class="fa fa-cogs"></i>
          <p>Configuration</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/dashuser">
          <i class="fa fa-edit"></i>
          <p>Registry</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/waybill">
          <i class="fa fa-group"></i>
          <p>Waybill</p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/sales">
          <i class="fa fa-euro"></i>
          <p>Sales</p>
        </a>
      </li>
      <li class="nav-item active2">
        <a class="nav-link" href="/reporting">
          <i class="fa fa-table"></i>
          <p>Reports</p>
        </a>
      </li>
      <!--li class="nav-item ">
        <a class="nav-link" href="#">
          <i class="fa fa-table"></i>
          <p>Null</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="#">
          <i class="material-icons">library_books</i>
          <p>Null</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="#">
          <i class="fa fa-envelope"></i>
          <p>Messaging</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="#">
          <i class="material-icons">bubble_chart</i>
          <p>Help</p>
        </a>
      </li-->
      <li class="nav-item active-pro ">
        <a class="nav-link" href="#">
          <i class="material-icons">unarchive</i>
          <p>Upgrade to PRO</p>
        </a>
      </li>
    </ul>
  </div>  
@endsection

@section('content')

  <!-- End Navbar -->
  <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-11">

              @include('inc.messages')

                <div class="form-group row mb-0 hideMe">
                    <div class="col-md-5 offset-md-0 myTrim">
                      <div class="input-group no-border">
                        

                        <form action="{{action('FeesController@store')}}" method="POST">
                          {!! csrf_field() !!}
                        </form>

                      </div>
                    </div>
                </div>

                <div class="container-fluid hideMe">

                  <div class="row">
        
                    <div class="col-lg-3 col-md-6 col-sm-6">
                      <a href="/reporting" class="myA">
                        <div class="card card-stats mygray">
                          <div style="height: 20px">
                          </div>
                          <div class="card-footer">
                            <h4 class='config2'><i class="fa fa-folder-open"></i> Sales</h4>
                            <div class="stats">General sales report</div>
                          </div>
                        </div>
                      </a>
                    </div>
        
                    <div class="col-lg-3 col-md-6 col-sm-6">
                      <a href="/stockbal" class="myA">
                        <div class="card card-stats">
                          <div style="height: 20px">
                          </div>
                          <div class="card-footer">
                          <h4 class='config2'><i class="fa fa-folder-open"></i> Stock</h4>
                            <div class="stats">General stock balances</div>
                          </div>
                        </div>
                      </a>
                    </div>
  
                    <div class="col-lg-3 col-md-6 col-sm-6">
                      <a href="/expensereport" class="myA">
                        <div class="card card-stats">
                          <div style="height: 20px">
                          </div>
                          <div class="card-footer">
                          <h4 class='config2'><i class="fa fa-folder-open"></i> Expenses</h4>
                            <div class="stats">General expenses report</div>
                          </div>
                        </div>
                      </a>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                      <a href="/debts" class="myA">
                        <div class="card card-stats">
                          <div style="height: 20px">
                          </div>
                          <div class="card-footer">
                          <h4 class='config2'><i class="fa fa-folder-open"></i> Debts</h4>
                            <div class="stats">Debts (Post Payments)</div>
                          </div>
                        </div>
                      </a>
                    </div>
        
                  </div>
  
                </div>

                <div class="col-md-12 offset-md-0">

                    <div class="form-group row mb-0 searchRef">
                        <form class="salesForm" action="{{action('ReportsController@index')}}" method="GET">
                          @csrf
                          <div class="dropdown">

                            <input type="date" class="sref" name="date_from" placeholder="yyyy-mm-dd"/>
                            <input type="text" class="sref" name="" placeholder=" From - To " style="width:70px; border:none; padding:0" readonly/>
                            <input type="date" class="sref" name="date_to" placeholder="yyyy-mm-dd"/>

                            <select name="branch" class="sref" required>
                              <option>All Branches</option>
                              @if (count($branches) > 0)
                                @foreach ($branches as $branch)
                                  <option value="{{ $branch->tag }}">{{ $branch->name }}</option> 
                                @endforeach
                              @endif
                            </select>

                            <select name="delvr" class="sref" required>
                              <option selected>Del. / Not Delivered</option>
                              <option>Delivered</option>
                              <option>Not Delivered</option>
                            </select>
                            
                            <button type="submit" class="btn btn-info"></i> &nbsp; Load Data</button>
                            <a href="/reporting"><button type="button" class="btn btn-success" name="store_action" value="empty_cart"><i class="fa fa-refresh"></i></button></a>
                            <a href="/reportprinting"><button type="button" class="btn black" name="store_action" value="empty_cart"><i class="fa fa-print"></i></button></a>
                            
                          </div>

                        </form>
                    </div>

                </div>

                <div class="card">
                  <div id="printarea1" class="card-body">
              
                    @if (count($sales) > 0)
                        <table class="table mt">
                          <thead class=" text-secondary hideMe">
                            <th>#</th>
                            <th>Order No.</th>
                            <th>User</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Pay Mode</th>
                            <th>Buyer's Name</th>
                            <th>Status</th>
                            <th>Date/Time Created</th>
                            <th class="ryt">Actions</th>
                          </thead>
                          <tbody id="tb">

                            @foreach ($sales as $sale)

                              @if ($sale->del == 'no')
                                
                                @if ($c%2==0)
                                  @if ($sale->del_status == 'Not Delivered')
                                    @if ($sale->pay_mode == 'Post Payment(Debt)' && $sale->paid != 'Paid')
                                      <tr class="debt_alert">
                                    @else
                                    <tr class="not_delivered">
                                    @endif
                                  @else
                                    @if ($sale->pay_mode == 'Post Payment(Debt)' && $sale->paid != 'Paid')
                                      <tr class="debt_alert">
                                    @else
                                      <tr class="rowColour">
                                    @endif
                                  @endif
                                @else
                                  @if ($sale->del_status == 'Not Delivered')
                                    @if ($sale->pay_mode == 'Post Payment(Debt)' && $sale->paid != 'Paid')
                                      <tr class="debt_alert">
                                    @else
                                    <tr class="not_delivered">
                                    @endif
                                  @else
                                    @if ($sale->pay_mode == 'Post Payment(Debt)' && $sale->paid != 'Paid')
                                      <tr class="debt_alert">
                                    @else
                                      <tr>
                                    @endif
                                  @endif
                                @endif
                                  <td>{{$c++}}</td>
                                  <td>{{$sale->order_no}}</td>
                                  <td>{{$sale->user->name}}<br>{{$sale->user->status}}</td>
                                  <td>{{$sale->qty}}</td>
                                  <td>GhC {{number_format($sale->tot, 2)}}</td>
                                  <td>{{$sale->pay_mode}}<br>
                                    @if($sale->pay_mode == 'Post Payment(Debt)' && $sale->paid == 'Paid')
                                      <b>{{$sale->paid}}</b>
                                      &nbsp; <i class="fa fa-check" style="color: rgb(0, 163, 0)"></i>
                                    @endif
                                  </td>  
                                  <td>{{$sale->buy_name}}<br>{{$sale->buy_contact}}</td>
                                  <td>{{$sale->del_status}}</td>
                                  <td>{{$sale->created_at}}<br><p style="color: #0071ce; margin: 0">{{$sale->updated_at}}</p></td>  

                                    <td>
                                      <a href="/reporting/{{$sale->id}}"><button type="button" title="Print Order" class="print_black"><i class="fa fa-print"></i></button></a>
                                      {{-- <button type="submit" data-toggle="modal" data-target="#edit_order{{ $sale->id }}" title="Edit Order" class="print_black">&nbsp;<i class="fa fa-pencil"></i>&nbsp;</button> --}}
                                      
                                      <button type="submit" data-toggle="modal" data-target="#edit_order{{ $sale->id }}" title="Edit Order" class="print_black">&nbsp;<i class="fa fa-pencil"></i>&nbsp;</button>
                                      <a href="/reporting/{{$sale->id}}/edit"><button type="button" title="Return Order" class="print_black" onclick="return confirm('Returning order will permanently delete record. Are you sure you want to return selected item?')"><i class="fa fa-mail-reply"></i></button></a>
                                      
                                      <div class="modal fade" id="edit_order{{ $sale->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        
                                        <div class="modal-dialog modtop" role="document">
                                          <div id="printarea" class="modal-content">
                                            <div class="modal-header">
                                              <h6 class="modal-title" id="exampleModalLabel"><i class="fa fa-save"></i>&nbsp;&nbsp; Edit {{ $sale->buy_name }}'s order details</h6>
                                            </div>
                                              <div class="card card-profile">
                                                <div class="card-avatar">
                                                  <a href="#">
                                                  {{-- <img class="img" src="/storage/members_imgs/{{$fee->student->photo}}" /> --}}
                                                  </a>
                                                </div>
                                                <div class="card-body">
                                                  <h6 class="card-category text-gray"></h6>
                                                  <div style="height: 30px">
                                                  </div>
                                    
                                                  <form action="{{ action('ItemsController@update', $sale->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf
                    
                                                    <div class="my_panel">

                                                      <div class="input_div">
                                                          <p>Buyer's Name: </p>
                                                          <input type="text" class="sref2" name="buy_name" placeholder="Buyer's Name" value="{{ $sale->buy_name }}" required/>
                                                      </div>
                          
                                                      <div class="input_div">
                                                          <p>Contact: </p>
                                                          <input type="number" class="sref2" name="buy_contact" placeholder="Contact" min="0" value="{{ $sale->buy_contact }}" required/>
                                                      </div>
                          
                                                      <div class="input_div">
                                                          <select name="pay_mode">
                                                            <option selected>{{ $sale->pay_mode }}</option>
                                                            <option>Cash</option>
                                                            <option>Cheque</option>
                                                            <option>Mobile Money</option>
                                                            <option>Post Payment(Debt)</option>
                                                          </select> 
                                                      </div>

                                                      <div class="input_div">
                                                        <button type="submit" class="btn btn-info pull-left" name="store_action" value="update_sales"><i class="fa fa-save"></i> &nbsp; Update</button>
                                                      </div>

                                                    </div>

                                                  </form>
                                    
                                                </div>
                                              </div>
                                          </div>
                                    
                                        </div>
                                      </div>
                                    </td> 

                                </tr>
                              
                              @endif

                            @endforeach
 
                          </tbody>
                        </table>
                        <p>No. of Records : <b style="color: #000000">{{$sales->total()}}</b> &nbsp;&nbsp;&nbsp; Total Amount : <b style="color: #000000">GhC {{ number_format($cash + $cheque + $momo + $sum_dbt, 2) }}</b></p>
                        {{-- {{ $sales->links() }} --}}
                        {{ $sales->appends(['date_from' => request()->query('date_from'), 'date_to' => request()->query('date_to'), 'branch' => request()->query('branch')])->links() }}

                        <div style="height: 30px">
                        </div>
      

                    @else
                      <p>No Records Found</p>
                    @endif
                    
                  </div>
                </div>

                <form action="{{url('/changedate')}}" method="GET">
                  <div class="form-group row mb-0 searchRef">
                    <input class="sref" id="item_no" name="date_today" type="date" style="height: 37px; margin: 5px" placeholder="yyyy-mm-dd"/>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-calendar"></i> &nbsp; Change Today's Date</button>
                  </div>
                </form>
               
              <div class="container-fluid hideMe">

                <div class="row">
      
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <a data-toggle="modal" data-target="#totbreakdownModal" class="myA">
                      <div class="card card-stats">
                        <button class="btn salesBtn seablue"><i class="fa fa-warning salesI"></i></button>
                        <h4 class='config2'>GhC {{number_format($b1, 2)}}</h4>
                        
                        <div class="card-footer">
                          <div class="stats">Branch 1: {{substr(session('branch_A'), 0,12)}}...
                            @if (session('branch') == 1 || session('branch') == 'All Branches') 
                              <br>Profits: GhC&nbsp;{{number_format($b1_profits, 2)}}<br>Expenses: GhC&nbsp;{{number_format($exp_b1, 2)}}
                            @endif
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
      
                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="#" class="myA">
                      <div class="card card-stats">
                        <button class="btn salesBtn seablue"><i class="fa fa-warning salesI"></i></button>
                        <h4 class='config2'>GhC {{number_format($b2, 2)}}</h4>
                        
                        <div class="card-footer">
                          <div class="stats">Branch 2: {{substr(session('branch_B'), 0,12)}}...
                            @if (session('branch') == 2 || session('branch') == 'All Branches') 
                              <br>Profits: GhC&nbsp;{{number_format($b2_profits, 2)}}<br>Expenses: GhC&nbsp;{{number_format($exp_b2, 2)}}
                            @endif
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>

                  <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="#" class="myA">
                      <div class="card card-stats">
                        <button class="btn salesBtn seablue"><i class="fa fa-warning salesI"></i></button>
                        <h4 class='config2'>GhC {{number_format($b3, 2)}}</h4>
                        
                        <div class="card-footer">
                          <div class="stats">Branch 3: {{session('branch')}}{{substr(session('branch_C'), 0,12)}}...
                            @if (session('branch') == 3 || session('branch') == 'All Branches')
                              <br>Profits: GhC&nbsp;{{number_format($b3_profits, 2)}}<br>Expenses: GhC&nbsp;{{number_format($exp_b3, 2)}}
                            @endif
                            </div>
                        </div>
                      </div>
                    </a>
                  </div>
      
                  {{-- @if (session('branch') != 1 || session('branch') != 2 || session('branch') != 3) --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                      <a href="/expenses" class="myA">
                        <div class="card card-stats">
                          <button class="btn salesBtn pink"><i class="fa fa-money salesI"></i></button>
                          <h4 class='config2'>GhC {{number_format($expenses->sum('expense_cost'), 2)}}</h4>
                          
                          <div class="card-footer">
                            <div class="stats">Expenditure Report<br>All Branches</div>
                          </div>
                        </div>
                      </a>
                    </div>
                  {{-- @endif --}}
      
                </div>

              </div>

            </div>


          </div>
        </div>
  </div>



  <div class="modal fade" id="totbreakdownModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Total Amount(GhC) Breakdown</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="overflow-x: auto">

          <table class="breakdown">
            <tr><td class="tt">Payment Mode(GhC)</td><td>Branch 1</td><td>Branch 2</td><td>Branch 3</td><td>Total</td></tr>
            <tr><td class="tt">Cash</td><td><b class="pr">{{$cash_b1}}</b></td><td><b class="pr">{{$cash_b2}}</b></td><td><b class="pr">{{$cash_b3}}</b></td><td><b class="pr">{{number_format($cash, 2)}}</b></td></tr>
            <tr><td class="tt">Cheque</td><td><b class="pr">{{$cheque_b1}}</b></td><td><b class="pr">{{$cheque_b2}}</b></td><td><b class="pr">{{$cheque_b3}}</b></td><td><b class="pr">{{number_format($cheque, 2)}}</b></td></tr>
            <tr><td class="tt">Mobile Money</td><td><b class="pr">{{$momo_b1}}</b></td><td><b class="pr">{{$momo_b2}}</b></td><td><b class="pr">{{$momo_b3}}</b></td><td><b class="pr">{{number_format($momo, 2)}}</b></td></tr>
            <tr><td class="tt">Post Payment(Debt)</td><td><b class="pr">{{$debt_b1}}</b></td><td><b class="pr">{{$debt_b2}}</b></td><td><b class="pr">{{$debt_b3}}</b></td><td><b class="pr">{{number_format($sum_dbt, 2)}}</b></td></tr>
            <tr><td class="tt">Expenditure</td><td><b class="tt">{{$exp_b1}}</b></td><td><b class="tt">{{$exp_b2}}</b></td><td><b class="tt">{{$exp_b3}}</b></td><td><b class="pr">{{number_format($expenses->sum('expense_cost'), 2)}}</b></td></tr>
            <tr><td class="tt">Profits</td><td class="tt">{{$b1_profits}}</td><td class="tt">{{$b2_profits}}</td><td class="tt">{{$b3_profits}}</td><td><b class="pr">{{number_format($gen_profits, 2)}}</b></td></tr>
            <tr><td class="pr">Total</td><td><b class="pr">{{number_format($cash_b1 + $cheque_b1 + $momo_b1 + $debt_b1 - $exp_b1, 2)}}</b></td>
              <td><b class="pr">{{number_format($cash_b2 + $cheque_b2 + $momo_b2 + $debt_b2 - $exp_b2, 2)}}</b></td>
              <td><b class="pr">{{number_format($cash_b3 + $cheque_b3 + $momo_b3 + $debt_b3 - $exp_b3, 2)}}</b></td>
              <td><b class="pr">{{number_format($cash + $cheque + $momo + $sum_dbt - $expenses->sum('expense_cost'), 2)}}</b></td>
            </tr>
          </table>

        </div>
      </div>
    </div>
  </div>
  
{{-- 
  <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Record Order Details Here</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          
            <form action="{{action('ItemsController@store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="" placeholder="Reference No/Id" type="text" class="form-control" name="ref" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="company_name" placeholder="From: Company Name" type="text" class="form-control" name="company_name" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="contact" placeholder="From: Company's Contact" type="text" class="form-control" name="contact" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                    <textarea name="desc" class="form-control" rows="3" placeholder="Description"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="tot" placeholder="Total Amt. GhC" type="number" class="form-control" name="tot" required autofocus>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="upfiles">Upload Receipt: &nbsp; </label>
                    <input type="file" name="repfile" required>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-info" name="store_action" value="add_order"><i class="fa fa-save"></i> &nbsp; Submit</button>
                    </div>
                </div>
            </form>

        </div>
      </div>
    </div>
  </div> --}}


@endsection

@section('footer')

<script type="text/javascript">
  $('#search').on('keyup',function(){
      $value=$(this).val();
      $.ajax({
          type : 'get',
          url : '{{URL::to('/searchfee')}}',
          data:{'search':$value},
          success:function(data){
          $('#tb').html(data);
          }
      });
  })
</script>
<script type="text/javascript">
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

@endsection