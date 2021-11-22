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
                        <div class="card card-stats mygray">
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
                        <form class="salesForm" action="{{action('DashController@expensereport')}}" method="GET">
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
                            <a href="/expensereport"><button type="button" class="btn btn-success" name="store_action" value="empty_cart"><i class="fa fa-refresh"></i></button></a>
                            <a href="/expensereportprinting"><button type="button" class="btn black" name="store_action" value="empty_cart"><i class="fa fa-print"></i></button></a>
                            
                          </div>

                        </form>
                    </div>

                </div>

                <div class="card">
                  <div id="printarea1" class="card-body">
              
                    @if (count($expenses) > 0)
                    {{-- {{ $expenses->paginate(4) }} --}}
                        <table class="table mt">
                          <thead class=" text-secondary hideMe">
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Cost(GhC)</th>
                            <th class="pr">Date/Time</th>
                            <th class="ryt">Action</th>
                          </thead>
                          <tbody id="tb">

                            @foreach ($expenses as $expense)
                                <tr><td>{{$i++}}</td>
                                  <td>{{$expense->title}}<br><b style="color: rgb(6, 163, 224)">{{session('branch_'.$expense->branch_id)}}</b></td>
                                  <td>{{$expense->desc}}</td>
                                  <td>{{$expense->expense_cost}}</td>
                                  <td>{{$expense->created_at}}</td>
                                  <td class="ryt">
                                    <form action="{{ action('ItemsController@destroy', $expense->id) }}" method="POST">

                                      <input type="hidden" name="_method" value="DELETE">
                                      {!! csrf_field() !!}
                                      <button type="submit" name="del_action" value="expense_del" rel="tooltip" title="Delete Record" class="close2" onclick="return confirm('NOTE: Deleting this record will credit main account with GhC {{$expense->expense_cost}}');"><i class="fa fa-close"></i></button>
                                  
                                    </form>
                                  </td>
                                </tr>
                            @endforeach

                            <tr>
                              <td></td>
                              <td>
                                  <br>Branch 1: {{substr(Session::get('branch_A'), 0,17)}}...
                                  <br>Branch 2: {{substr(Session::get('branch_B'), 0,17)}}...
                                  <br>Branch 3: {{substr(Session::get('branch_C'), 0,17)}}...
                                  <br>Total:
                              </td>
                              <td>
                                  <br>{{Session::get('exp_b1')}}
                                  <br>{{Session::get('exp_b2')}}
                                  <br>{{Session::get('exp_b3')}}
                                  <br>{{Session::get('expenses')->sum('expense_cost')}}</td>
                              <td> - </td>
                              <td> - </td>
                              <td></td>
                            </tr>
                            
                            <tr>
                              <td></td><td><b>No. of Records : {{$expenses->total()}}</b></td><td><b>Total</b></td><td><b>{{ session('expenses')->sum('expense_cost') }}</b></td><td></td><td></td>
                            </tr>

                            {{-- @foreach ($items as $item)

                              @if ($item->del == 'no')
                                
                                @if ($c%2==0)
                                  <tr class="rowColour"><td>{{$c++}}</td>
                                @else
                                  <tr><td>{{$c++}}</td>
                                @endif
                                  <td>{{$item->item_no}}</td>
                                  <td>{{$item->name}}<br>{{$item->desc}}</td>
                                  <td>{{$item->cat}}</td>
                                  <td>Qty: {{$item->q1}}<br>GhC {{$item->b1}}</td>
                                  <td>Qty: {{$item->q2}}<br>GhC {{$item->b2}}</td>
                                  <td>Qty: {{$item->q3}}<br>GhC {{$item->b3}}</td>
                                  <td>{{$item->created_at}}<br><p style="color: #0071ce; margin: 0">{{$item->updated_at}}</p></td>
                                  <td class="ryt">
                                    
                                    <form action="{{ action('ItemsController@update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                      <input type="hidden" name="_method" value="PUT">
                                      {!! csrf_field() !!}

                                      <button type="submit" name="store_action" value="del_item" rel="tooltip" title="Delete Item" class="close2" onclick="return confirm('Are you sure you want to delete selected item?');"><i class="fa fa-close"></i></button>
                                      <button type="button" data-toggle="modal" data-target="#edit_{{ $item->id }}" title="Edit Record" class="print_black">&nbsp;<i class="fa fa-pencil">&nbsp;</i></button>
                                      

                                      <div class="modal fade" id="edit_{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modtop" role="document">
                                          <div class="modal-content">
                                              
                                              <div class="card card-profile">
                                                <div class="card-avatar">
                                                  <a href="#pablo">
                                                  <img class="img" src="/storage/rjv_items/{{$item->thumb_img}}" />
                                                  </a>
                                                </div>
                                                <div class="card-body">
                                                  <h4 class="card-category text-gray">Item N0: {{$item->item_no}}</h4>
                                                  <h6 class="card-title">Created by: {{$item->user_id}}</h6>




                                                  <table class="user_view_tbl">
                                                    <tbody>

                                                      <tr class="tbl_tr"><td class="tl">Item Name</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="text" class="form-control" name="name" placeholder="Item Name" value="{{$item->name}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Description</td><td class="tr">
                                                        <div class="form-group">
                                                          <textarea type="text" class="form-control" rows="4" name="desc" placeholder="Description" required>{{$item->desc}}</textarea>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Category</td><td class="tr">
                                                        <div class="form-group">
                                                          <select name="cat" class="form-control" id="cat">
                                                            <option selected>{{$item->cat}}</option>
                                                            @if(count($cats) > 0)
                                                            @foreach ($cats as $cat)
                                                              @if($cat->del != 'yes')
                                                                <option>{{$cat->name}}</option>
                                                              @endif
                                                            @endforeach
                                                          @endif
                                                          </select>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Brand</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="text" class="form-control" name="brand" placeholder="Brand" value="{{$item->brand}}"/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Barcode</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type='text' class="form-control" placeholder="Barcode" name="barcode" value="{{$item->barcode}}"/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl"><b>Gen. Quantity</b></td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="qty" placeholder="Quantity" value="{{$item->qty}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 1 Qty.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="q1" placeholder="Quantity" value="{{$item->q1}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 2 Qty.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="q2" placeholder="Quantity" value="{{$item->q2}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 3 Qty.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="q3" placeholder="Quantity" value="{{$item->q3}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl"><b>Cost Price</b></td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="text" class="form-control" name="price" placeholder="Price" value="{{$item->price}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 1 Price.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="b1" placeholder="Price" value="{{$item->b1}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 2 Price.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="b2" placeholder="Price" value="{{$item->b2}}" required/>
                                                        </div>
                                                      </td></tr>

                                                      <tr class="tbl_tr"><td class="tl">Branch 3 Price.</td><td class="tr">
                                                        <div class="form-group">
                                                          <input type="number" class="form-control" name="b3" placeholder="Price" value="{{$item->b3}}" required/>
                                                        </div>
                                                      </td></tr>

                                                    </tbody>
                                                  </table>

                                                </div>
                                              </div>
                                              
                                              <div class="modal-footer">
                                                <button type="submit" class="btn btn-info" name="store_action" value="update_item"><i class="fa fa-save"></i> &nbsp; Update Record</button>
                                              </div>

                                          </div>
                                    
                                        </div>
                                      </div>

                                    </form>                  
                                    
                                  </td>
                                </tr>
                              
                              @endif

                            @endforeach --}}

                          </tbody>
                        </table>
                        {{-- {{ $expenses->links() }} --}}
                        {{ $expenses->appends(['date_from' => request()->query('date_from'), 'date_to' => request()->query('date_to'), 'branch' => request()->query('branch')])->links() }}

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