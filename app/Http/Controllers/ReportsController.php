<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Category;
use App\User;
use App\Cart;
use App\Item;
use App\Sale;
use App\Order;
use App\Expense;
use App\Waybill;
use App\OrderReturn;
use App\SalesHistory;
use App\CompanyBranch;
use Exception;
use Session;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Session::get('branch');
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        if(Session::get('date_today') == ''){
            Session::put('date_today', date('Y-m-d'));
        }
        //
        $c = 1;
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');
        $branch = $request->query('branch');
        $delvr = $request->query('delvr');
        Session::put('branch', 'All Branches');

        if ($branch == 'All Branches') {
            if ($delvr == 'Del. / Not Delivered') {
                $del = ['del' => 'no'];
                // return $delvr;
            } else {
                $del = ['del' => 'no', 'del_status' => $delvr ];
            }
            $exp_del = ['del' => 'no'];
        } else {
            Session::put('branch', $branch);
            if ($delvr == 'Del. / Not Delivered') {
                $del = ['del' => 'no', 'user_bv' => $branch ];
            } else {
                $del = ['del' => 'no', 'del_status' => $delvr, 'user_bv' => $branch ];
            }
            $exp_del = ['del' => 'no', 'branch_id' => $branch ];
            $cash_b1 = 0;
            $cash_b2 = 0;
            $cash_b3 = 0;
            $cheque_b1 = 0;
            $cheque_b2 = 0;
            $cheque_b3 = 0;
            $momo_b1 = 0;
            $momo_b2 = 0;
            $momo_b3 = 0;
            $debt_b1 = 0;
            $debt_b2 = 0;
            $debt_b3 = 0;
        }
        
        $b1_match = ['del' => 'no', 'user_bv' => 1 ];
        $b2_match = ['del' => 'no', 'user_bv' => 2 ];
        $b3_match = ['del' => 'no', 'user_bv' => 3 ];
        $exp_b1_match = ['del' => 'no', 'branch_id' => 1 ];
        $exp_b2_match = ['del' => 'no', 'branch_id' => 2 ];
        $exp_b3_match = ['del' => 'no', 'branch_id' => 3 ];
        // if ($request->filled('date_from')) {
        if (!empty($date_from) && empty($date_to)) {
            # code...
            $sales = Sale::where($del)->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->paginate(10);
            // Get Money Sums
            $cash = Sale::where($del)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            $cheque = Sale::where($del)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            $momo = Sale::where($del)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            $sum_dbt = Sale::where($del)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');

            if ($branch == 1 || $branch == 'All Branches') {
                $cash_b1 = Sale::where($b1_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $cheque_b1 = Sale::where($b1_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $momo_b1 = Sale::where($b1_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $debt_b1 = Sale::where($b1_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            }
            if ($branch == 2 || $branch == 'All Branches') {
                $cash_b2 = Sale::where($b2_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $cheque_b2 = Sale::where($b2_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $momo_b2 = Sale::where($b2_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $debt_b2 = Sale::where($b2_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            }
            if ($branch == 3 || $branch == 'All Branches') {
                $cash_b3 = Sale::where($b3_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $cheque_b3 = Sale::where($b3_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $momo_b3 = Sale::where($b3_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
                $debt_b3 = Sale::where($b3_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            }

            // Get sum Branch 1
            $b1 = Sale::where($b1_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            // Get sum Branch 2
            $b2 = Sale::where($b2_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');
            // Get sum Branch 3
            $b3 = Sale::where($b3_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('tot');

            $expenses = Expense::where('del', 'no')->where('created_at', 'LIKE', '%'.$date_from.'%')->get();

            $exp_b1 = Expense::where($exp_b1_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');

            // Get general profits
            $gp_match = ['del' => 'no'];
            $gen_profits = SalesHistory::where($gp_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('profits');

            $b1_profits = SalesHistory::where($b1_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('profits');
            $b2_profits = SalesHistory::where($b2_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('profits');
            $b3_profits = SalesHistory::where($b3_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('profits');

        }elseif (empty($date_from) && !empty($date_to)) {
            return redirect('/reporting')->with('error', 'Oops..! Provide *Date From* in order to proceed');

        }elseif (!empty($date_from) && !empty($date_to)) {

            $sales = Sale::where($del)->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->paginate(10);
            // Get Money Sums
            $cash = Sale::where($del)->where('pay_mode', 'cash')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            $cheque = Sale::where($del)->where('pay_mode', 'cheque')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            $momo = Sale::where($del)->where('pay_mode', 'Mobile Money')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            $sum_dbt = Sale::where($del)->where('pay_mode', 'Post Payment(Debt)')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');

            if ($branch == 1 || $branch == 'All Branches') {
                $cash_b1 = Sale::where($b1_match)->where('pay_mode', 'cash')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $cheque_b1 = Sale::where($b1_match)->where('pay_mode', 'cheque')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $momo_b1 = Sale::where($b1_match)->where('pay_mode', 'Mobile Money')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $debt_b1 = Sale::where($b1_match)->where('pay_mode', 'Post Payment(Debt)')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            }
            if ($branch == 2 || $branch == 'All Branches') {
                $cash_b2 = Sale::where($b2_match)->where('pay_mode', 'cash')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $cheque_b2 = Sale::where($b2_match)->where('pay_mode', 'cheque')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $momo_b2 = Sale::where($b2_match)->where('pay_mode', 'Mobile Money')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $debt_b2 = Sale::where($b2_match)->where('pay_mode', 'Post Payment(Debt)')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            }
            if ($branch == 3 || $branch == 'All Branches') {
                $cash_b3 = Sale::where($b3_match)->where('pay_mode', 'cash')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $cheque_b3 = Sale::where($b3_match)->where('pay_mode', 'cheque')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $momo_b3 = Sale::where($b3_match)->where('pay_mode', 'Mobile Money')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
                $debt_b3 = Sale::where($b3_match)->where('pay_mode', 'Post Payment(Debt)')->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            }
            // Get sum Branch 1
            $b1 = Sale::where($b1_match)->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            // Get sum Branch 2
            $b2 = Sale::where($b2_match)->whereBetween('created_at', [$date_from, $date_to])->sum('tot');
            // Get sum Branch 3
            $b3 = Sale::where($b3_match)->whereBetween('created_at', [$date_from, $date_to])->sum('tot');

            $expenses = Expense::where($exp_del)->whereBetween('created_at', [$date_from, $date_to])->get();
            
            $exp_b1 = Expense::where($exp_b1_match)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');

            // Get general profits
            $gp_match = ['del' => 'no'];
            $gen_profits = SalesHistory::where($gp_match)->whereBetween('created_at', [$date_from, $date_to])->sum('profits');

            $b1_profits = SalesHistory::where($b1_match)->whereBetween('created_at', [$date_from, $date_to])->sum('profits');
            $b2_profits = SalesHistory::where($b2_match)->whereBetween('created_at', [$date_from, $date_to])->sum('profits');
            $b3_profits = SalesHistory::where($b3_match)->whereBetween('created_at', [$date_from, $date_to])->sum('profits');

        }else{
            
            $sales = Sale::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->orderBy('id', 'desc')->paginate(10);
            // Get Money Sums
            $cash = Sale::where('del', 'no')->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $cheque = Sale::where('del', 'no')->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $momo = Sale::where('del', 'no')->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $sum_dbt = Sale::where('del', 'no')->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

            if ($branch == 1 || $branch == 'All Branches') {
            }
            if ($branch == 2 || $branch == 'All Branches') {
            }
            if ($branch == 3 || $branch == 'All Branches') {
            }
            $cash_b1 = Sale::where($b1_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $cash_b2 = Sale::where($b2_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $cash_b3 = Sale::where($b3_match)->where('pay_mode', 'cash')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

            $cheque_b1 = Sale::where($b1_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $cheque_b2 = Sale::where($b2_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $cheque_b3 = Sale::where($b3_match)->where('pay_mode', 'cheque')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

            $momo_b1 = Sale::where($b1_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $momo_b2 = Sale::where($b2_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $momo_b3 = Sale::where($b3_match)->where('pay_mode', 'Mobile Money')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

            $debt_b1 = Sale::where($b1_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $debt_b2 = Sale::where($b2_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
            $debt_b3 = Sale::where($b3_match)->where('pay_mode', 'Post Payment(Debt)')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

            // Get sum Branch 1
            $b1 = Sale::where($b1_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
            // Get sum Branch 2
            $b2 = Sale::where($b2_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
            // Get sum Branch 3
            $b3 = Sale::where($b3_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
            $expenses = Expense::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->get();

            $exp_b1 = Expense::where($exp_b1_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');


            // Get general profits
            $gp_match = ['del' => 'no'];
            $gen_profits = SalesHistory::where($gp_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('profits');

            $b1_profits = SalesHistory::where($b1_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('profits');
            $b2_profits = SalesHistory::where($b2_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('profits');
            $b3_profits = SalesHistory::where($b3_match)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('profits');

        }

        $gross = $cash + $cheque + $momo + $sum_dbt;
        $net = $gross - $expenses->sum('expense_cost');

            // Set session variables
            Session::put('b1_profits', $b1_profits);
            Session::put('b2_profits', $b2_profits);
            Session::put('b3_profits', $b3_profits);
            Session::put('gen_profits', $gen_profits);
            Session::put('b1', $b1);
            Session::put('b2', $b2);
            Session::put('b3', $b3);
            Session::put('exp_b1', $exp_b1);
            Session::put('exp_b2', $exp_b2);
            Session::put('exp_b3', $exp_b3);
            Session::put('gross', $gross);
            Session::put('net', $net);
            Session::put('sales', $sales);
            Session::put('cash', $cash);
            Session::put('cheque', $cheque);
            Session::put('momo', $momo);
            Session::put('sum_dbt', $sum_dbt);
            // Session::put('cash_b1', $cash);
            // Session::put('cash_b2', $cash);
            // Session::put('cash_b3', $cash);
            // Session::put('cheque_b1', $cheque);
            // Session::put('cheque_b2', $cheque);
            // Session::put('cheque_b3', $cheque);
            Session::put('expenses', $expenses);
            Session::put('date_from', $date_from);
            Session::put('date_to', $date_to);

            $company_branch = CompanyBranch::all();

        $pass = [
            'c' => $c, 
            'b1' => $b1, 
            'b2' => $b2, 
            'b3' => $b3, 
            'exp_b1' => $exp_b1, 
            'exp_b2' => $exp_b2, 
            'exp_b3' => $exp_b3, 
            'cash' => $cash,
            'cheque' => $cheque,
            'momo' => $momo,
            'sum_dbt' => $sum_dbt,
            'cash_b1' => $cash_b1,
            'cash_b2' => $cash_b2,
            'cash_b3' => $cash_b3,
            'cheque_b1' => $cheque_b1,
            'cheque_b2' => $cheque_b2,
            'cheque_b3' => $cheque_b3,
            'momo_b1' => $momo_b1,
            'momo_b2' => $momo_b2,
            'momo_b3' => $momo_b3,
            'debt_b1' => $debt_b1,
            'debt_b2' => $debt_b2,
            'debt_b3' => $debt_b3,
            'sales' => $sales, 
            'branches' => $company_branch, 
            'b1_profits' => $b1_profits,
            'b2_profits' => $b2_profits,
            'b3_profits' => $b3_profits, 
            'gen_profits' => $gen_profits,
            'expenses' => $expenses
        ];
        return view('pages.dash.reportsview')->with($pass);
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Sale::find($id);
        $sales = $order->saleshistory->all();
        $user = User::find($order->user_id);

        $company = Company::find(1);
        $pass = [
            'count' => 1, 
            'count2' => 1,
            'user' => $user,
            'order' => $order,
            'company' => $company,
            'sales' => $sales
        ];

        return view('pages.dash.single_invoice')->with($pass);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        // $sh = SalesHistory::find($id);
        // return $id;

        $SalesHistory = SalesHistory::where('sale_id', $id)->get();
        foreach ($SalesHistory as $sh) {
            # code...
            $OrderReturn = OrderReturn::firstOrCreate([
                'user_id' => $sh->user_id,
                'sale_id' => $sh->sale_id,
                'item_id' => $sh->item_id,
                'user_bv' => $sh->user_bv,
                'item_no' => $sh->item_no,
                'name' => $sh->name,
                'qty' => $sh->qty,
                'cost_price' => $sh->cost_price,
                'unit_price' => $sh->unit_price,
                'profits' => $sh->profits,
                'tot' => $sh->tot,
                'del_status' => $sh->del,
                'order_date' => $sh->created_at,
            ]);

            $new_qty = 'q'.$sh->user_bv;

            // Save to OrderReturn
            $item = Item::find($sh->item_id);
            $item->$new_qty = $item->$new_qty + $sh->qty;
            $item->save();

            // Delete from SalesHistory
            $sh->delete();
            
        }

            // Delete from Sales
            $sales = Sale::find($id);
            $sales->delete();

        // return $SalesHistory;
        return redirect(url()->previous());
        // return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
