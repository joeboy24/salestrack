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
                        <div class="card card-stats">
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
                        <div class="card card-stats mygray">
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
                        <form class="salesForm" action="{{action('DashController@debts')}}" method="GET">
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
                            
                            <button type="submit" class="btn btn-info"></i> &nbsp; Load Data</button>
                            <a href="/debts"><button type="button" class="btn btn-success" name="store_action" value="empty_cart"><i class="fa fa-refresh"></i></button></a>
                            {{-- <a href="/expensereportprinting"><button type="button" class="btn black" name="store_action" value="empty_cart"><i class="fa fa-print"></i></button></a> --}}
                            
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
                                      
                                      <button type="submit" data-toggle="modal" data-target="#edit_order{{ $sale->id }}" title="Edit Order" class="print_black">&nbsp;<i class="fa fa-pencil"></i>&nbsp;</button>
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
                        <p>No. of Records : <b style="color: #000000">{{$sales->total()}}</b> &nbsp;&nbsp;&nbsp; Total Amount : <b style="color: #000000">GhC {{ number_format(session('debts')->sum('tot'), 2) }}</b></p>
                        {{-- {{ $sales->links() }} --}}
                        {{ $sales->appends(['date_from' => request()->query('date_from'), 'date_to' => request()->query('date_to'), 'branch' => request()->query('branch')])->links() }}

                        <div style="height: 30px">
                        </div>
      

                    @else
                      <p>No Records Found</p>
                    @endif

                  </div>
                </div>
            </div>

          </div>
        </div>
  </div>


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