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
use App\ItemAudit;
use App\SalesPayment;
use App\SalesHistory;
use App\CompanyBranch;
use Exception;
use Session;

class DashController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    } 

    //
    public function say(){
        return 775757;
    }
    
    public function dashboard(){
        $b1 = CompanyBranch::where('tag', 1)->first();
        $b2 = CompanyBranch::where('tag', 2)->first();
        $b3 = CompanyBranch::where('tag', 3)->first();

        Session::put('branch_A', $b1->name);
        Session::put('branch_B', $b2->name);
        Session::put('branch_C', $b3->name);

        Session::put('branch_1', $b1->name);
        Session::put('branch_2', $b2->name);
        Session::put('branch_3', $b3->name);

        if(Session::get('date_today') == ''){
            Session::put('date_today', date('Y-m-d'));
        }
        return view('pages.dash.dashboard');
    }

    public function configurations(){

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $items = Item::all();
        $company = Company::all();
        $branches = CompanyBranch::all();
        $pass = [
            'items' => $items,
            'company' => $company,
            'branches' => $branches
        ];
        return view('pages.dash.configuration')->with($pass);
    }

    public function dashuser(){

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $i = 1;
        $r = 1;
        $items = Item::all();
        $users = User::all();
        $cat = Category::all();
        $branches = CompanyBranch::all();

        $pass = [
            'i' => $i,
            'r' => $r,
            'items' => $items,
            'users' => $users,
            'branches' => $branches,
            'category' => $cat
        ];

        return view('pages.dash.dashuser')->with($pass);
    }

    public function sales(){

        // return Session::get('date_today');
        // $sale_id = Sale::latest()->limit(1)->get();
        // foreach ($sale_id as $sid) {
        //     # code...
        //     $new_sid = $sid->id;
        // }
        // return $new_sid;

        if(Session::get('date_today') == ''){
            Session::put('date_today', date('Y-m-d'));
        }

        if(auth()->user()->status == 'Administrator'){
            $uid_hold = 'no';
            $field = "del";
        }else{
            $uid_hold = auth()->user()->id;
            $field = "user_id";
        }

        $items = Item::all();

        $uidMatch = [
            $field => $uid_hold
        ];
        $sales = Sale::where($uidMatch)->orderBy('id', 'desc')->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->paginate(10);
        $sales2 = Sale::where($uidMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->get();
        // return $sales;
        $debts = SalesPayment::where($uidMatch)->where('updated_at', 'LIKE', '%'.Session::get('date_today').'%')->get();
        // 2021-05-12 18:50:28
        $cashMatch = [
            'pay_mode' => 'Cash',
            $field => $uid_hold
        ];
        $cash = Sale::where($cashMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
        $chequeMatch = [
            'pay_mode' => 'Cheque',
            $field => $uid_hold
        ];
        $cheque = Sale::where($chequeMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
        $momoMatch = [
            'pay_mode' => 'Mobile Money',
            $field => $uid_hold
        ];
        $momo = Sale::where($momoMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
        $debtMatch = [
            'pay_mode' => 'Post Payment(Debt)',
            $field => $uid_hold
        ];
        $sum_dbt = Sale::where($debtMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->sum('tot');
        // $profits = SalesHistory::where($field, $uid_hold)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->get();

        // Select for both where and %like%
        $expenses = Expense::where('user_id', auth()->user()->id)->where('created_at', 'LIKE', '%'.date('Y-m-d').'%');

        // br

        //$sales2 = Sale::where($match);
        $sum_ex_dbt = $sales2->sum('tot') - $sum_dbt;
        $sum_inc_dbt = $sum_ex_dbt + $debts->sum('amt_paid');
        $debts_paid = $debts->sum('amt_paid');
        // $sum_ex_dbt = $sales->sum('tot') - ($sum_dbt + $cheque);
        // End select both
        $uidMatch = [
            $field => $uid_hold
        ];
        $carts = Cart::where($uidMatch)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->get();

        $pass = [
            'i' => 1,
            'c' => 1,
            'j' => 1,
            'items' => $items,
            'sales' => $sales,
            'expenses' => $expenses,
            'cash' => $cash,
            'cheque' => $cheque,
            'momo' => $momo,
            'sum_dbt' => $sum_dbt,
            'sum_dbt' => $sum_dbt,
            'debts_paid' => $debts_paid,
            'sum_inc_dbt' => $sum_inc_dbt,
            'carts' => $carts
        ];
        return view('pages.dash.sales')->with($pass);
    }

    public function waybill(){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        return view('pages.dash.waybill');
    }

    public function stockview(){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        return view('pages.dash.stockview');
    }

    public function waybillview(Request $request){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        $c = 1;
        $match = ['del' => 'no'];
        $waybillsearch = $request->query('waybillsearch');
        if(!empty($waybillsearch)){
            $waybills = Waybill::where($match)->where('comp_name', 'like', '%'.$waybillsearch.'%')->orderBy('id', 'desc')->paginate(10);
            if(count($waybills) < 1){
                $waybills = Waybill::where($match)->where('drv_name', 'like', '%'.$waybillsearch.'%')->orderBy('id', 'desc')->paginate(10);
        
            }
        }else{
            $waybills = Waybill::where($match)->orderBy('id', 'desc')->paginate(10);
        }
        $pass = [
            'c' => $c,
            'waybills' => $waybills
        ];
        return view('pages.dash.waybillview')->with($pass);
    }

    public function empty_cart(){
        // try {
            //code...
            
            $uid = auth()->user()->id;
            $ubv = auth()->user()->bv;
            $carts = Cart::where('user_id', $uid)->get();
            $q = 'q'.$ubv;
            if(count($carts) > 0){
                foreach ($carts as $cart) {
                    # code...

                    $item = Item::find($cart->item_id);
                    $oq = $item->qty;
                    $obq = $item->$q;
                    // return $obq;
                    $item->qty = $oq + $cart->qty;
                    $item->$q = $obq + $cart->qty;
                    $item->save();

                    // Empty specific user/branch cart
                    $cart_del = Cart::find($cart->id);
                    $cart_del->delete();
                }
            }
            return redirect('/sales')->with('success', 'Cart Emptied..');

        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return redirect('/sales')->with('error', 'Oops..! Unhandled Error.. ');
        // }
    }

    public function reporting2(){
        $c = 1;

        // Get sum Branch 1
        $b1_match = ['del' => 'no', 'user_bv' => 1 ];
        $b1 = Sale::where($b1_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
        // Get sum Branch 2
        $b2_match = ['del' => 'no', 'user_bv' => 2 ];
        $b2 = Sale::where($b2_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');
        // Get sum Branch 3
        $b3_match = ['del' => 'no', 'user_bv' => 3 ];
        $b3 = Sale::where($b3_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('tot');

        // ->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')

        $expenses = Expense::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->get();

        $pass = [
            'b1' => $b1, 
            'b2' => $b2, 
            'b3' => $b3, 
            'expenses' => $expenses
        ];
        return view('pages.dash.reportsview')->with($pass);
    }

    public function reportprinting(){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        // return url()->previous();
        $company = Company::find(1);
        $pass = [
            'count' => 1,
            'company' => $company,
            'sales' => Session::get('sales')
        ];
        // return Session::get('sales');
        return view('pages.dash.invoice')->with($pass);
    }

    public function stockreportprinting(){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        // // return url()->previous();
        // $items = Item::all();
        $company = Company::find(1);
        $pass = [
            'count' => 1,
            'company' => $company,
            'items' => Session::get('items')
        ];
        // return Session::get('sales');
        return view('pages.dash.stockinvoice')->with($pass);
    }

    public function expensereportprinting(){
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        // return url()->previous();
        $company = Company::find(1);
        $pass = [
            'count' => 1,
            'company' => $company,
            'expenses' => Session::get('expenses')
        ];
        // return Session::get('sales');
        return view('pages.dash.expenseinvoice')->with($pass);
    }

    public function genstockbal(){
        // return Session::get('genstockbal');
        
        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        // return url()->previous();
        $company = Company::find(1);
        $pass = [
            'count' => 1,
            'company' => $company,
            'genstockbal' => Session::get('genstockbal')
        ];
        // return Session::get('sales');
        return view('pages.dash.genstockbal')->with($pass);
    }

    public function changedate(Request $request){
        $date_today = $request->query('date_today');
        if(empty($date_today)){
            return redirect(url()->previous())->with('error', 'Select date to change to..!');
        }
        Session::put('date_today', $date_today);
        return redirect(url()->previous())->with('success', 'Date changed to '.$date_today);
    }

    public function deliverer(Request $request){
        $sale_id = $request->query('deliverer');
        $delTxt = $request->query('deliverer_text');
        // return url()->previous();
        $sale = Sale::find($sale_id);
        $sale->del_status = $delTxt;
        $sale->save();
        return redirect('/sales')->with('success', 'Delivery status changed to *'.$delTxt.'*');
    }

    public function stockbal(Request $request){

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        //
        $c = 1;
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');
        
        if (!empty($date_from) && empty($date_to)) {
            // return 12345;
            # code...
            $nonedit = 'true';
            $items = ItemAudit::where('del', 'no')->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->paginate(10);
            $items_send = ItemAudit::where('del', 'no')->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->get();
            $saleshistory_send = SalesHistory::where('del', 'no')->where('created_at', 'LIKE', '%'.$date_from.'%')->get();
        }elseif (empty($date_from) && !empty($date_to)) {
            $nonedit = 'true';
            return redirect(url()->previous())->with('error', 'Oops..! Provide *Date From* in order to proceed');
        }elseif (!empty($date_from) && !empty($date_to)) {
            $nonedit = 'true';
            $items = ItemAudit::where('del', 'no')->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->paginate(10);
            $items_send = ItemAudit::where('del', 'no')->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->get();
            $saleshistory_send = SalesHistory::select('item_no', 'name', 'qty', 'cost_price', 'unit_price', 'tot', 'profits')->where('del', 'no')->whereBetween('created_at', [$date_from, $date_to])->distinct('name')->get();
        }else{
            $nonedit = 'false';
            $items = Item::where('del', 'no')->paginate(10);
            $items_send = Item::where('del', 'no')->get();
            $saleshistory_send = SalesHistory::where('del', 'no')->where('created_at', 'LIKE', '%'.Session::get('date_today').'%')->get();
            // $items = ItemAudit::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->orderBy('id', 'desc')->paginate(10);
        }

        Session::put('items', $items_send);
        Session::put('genstockbal', $saleshistory_send);

        Session::put('date_from', $date_from);
        Session::put('date_to', $date_to);

        $cats = Category::All();
        $company = Company::find(1);
        $pass = [
            'c' => 1,
            'y' => 1,
            'cats' => $cats,
            'items' => $items,
            'company' => $company,
            'nonedit' => $nonedit,
            'sales' => 3
        ];
        // $dist_category = Item::select('cat')->where($match)->where('img_count', '>', 1)->distinct()->get();
        return view('pages.dash.stockbalances')->with($pass);
    }

    public function expensereport(Request $request){

        // return 1234567;

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }
        $exp_b1 = 0;
        $exp_b2 = 0;
        $exp_b3 = 0;

        $branch = $request->input('branch');
        if($branch == 'All Branches'){
            $match = ['del' => 'no'];
        }else{
            $match = ['del' => 'no', 'branch_id' => $branch];
        }

        $exp_b1_match = ['del' => 'no', 'branch_id' => 1 ];
        $exp_b2_match = ['del' => 'no', 'branch_id' => 2 ];
        $exp_b3_match = ['del' => 'no', 'branch_id' => 3 ];
        
        $c = 1;
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');
        
        if (!empty($date_from) && empty($date_to)) {
            // return 12345;
            # code...
            $expenses = Expense::where($match)->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->paginate(10);
            $expenses_send = Expense::where($match)->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->get();

            $exp_b1 = Expense::where($exp_b1_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->where('created_at', 'LIKE', '%'.$date_from.'%')->sum('expense_cost');
        }elseif (empty($date_from) && !empty($date_to)) {
            return redirect(url()->previous())->with('error', 'Oops..! Provide *Date From* in order to proceed');
        }elseif (!empty($date_from) && !empty($date_to)) {
            // $expenses = Expense::where('user_id', auth()->user()->bv)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%');
            $expenses = Expense::where($match)->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->paginate(10);
            $expenses_send = Expense::where($match)->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->get();

            $exp_b1 = Expense::where($exp_b1_match)->where('branch_id', 1)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->where('branch_id', 2)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->where('branch_id', 3)->whereBetween('created_at', [$date_from, $date_to])->sum('expense_cost');
        }else{
            $expenses = Expense::where('del', 'no')->orderBy('id', 'desc')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->paginate(10);
            $expenses_send = Expense::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->orderBy('id', 'desc')->get();
            // $items = ItemAudit::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->orderBy('id', 'desc')->paginate(10);

            $exp_b1 = Expense::where($exp_b1_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');
            $exp_b2 = Expense::where($exp_b2_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');
            $exp_b3 = Expense::where($exp_b3_match)->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->sum('expense_cost');
        }

        Session::put('expenses', $expenses_send);
        $branches = CompanyBranch::all();

        Session::put('date_from', $date_from);
        Session::put('date_to', $date_to);
        Session::put('exp_b1', $exp_b1);
        Session::put('exp_b2', $exp_b2);
        Session::put('exp_b3', $exp_b3);

        $cats = Category::All();
        $company = Company::find(1);
        $pass = [
            'i' => 1,
            'y' => 1,
            'cats' => $cats,
            'expenses' => $expenses,
            'branches' => $branches,
            'company' => $company,
            'sales' => 3
        ];
        return view('pages.dash.expensereport')->with($pass);
    }

    public function debts(Request $request){

        // return 1234567;

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $branch = $request->input('branch');
        if($branch == 'All Branches'){
            $match = ['del' => 'no', 'pay_mode' => 'Post Payment(Debt)'];
        }else{
            $match = ['del' => 'no', 'user_bv' => $branch, 'pay_mode' => 'Post Payment(Debt)'];
        }
        
        $c = 1;
        $date_from = $request->query('date_from');
        $date_to = $request->query('date_to');
        
        if (!empty($date_from) && empty($date_to)) {
            // return 12345;
            # code...
            $sales = Sale::where($match)->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->paginate(10);
            $sales_send = Sale::where($match)->where('created_at', 'LIKE', '%'.$date_from.'%')->orderBy('id', 'desc')->get();
        }elseif (empty($date_from) && !empty($date_to)) {
            return redirect(url()->previous())->with('error', 'Oops..! Provide *Date From* in order to proceed');
        }elseif (!empty($date_from) && !empty($date_to)) {
            // $expenses = Expense::where('user_id', auth()->user()->bv)->where('created_at', 'LIKE', '%'.Session::get('date_today').'%');
            $sales = Sale::where($match)->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->paginate(10);
            $sales_send = Sale::where($match)->whereBetween('created_at', [$date_from, $date_to])->orderBy('id', 'desc')->get();
        }else{
            $match = ['del' => 'no', 'pay_mode' => 'Post Payment(Debt)'];
            $sales = Sale::where($match)->orderBy('id', 'desc')->paginate(10);
            $sales_send = Sale::where($match)->orderBy('id', 'desc')->get();
            // $items = ItemAudit::where('del', 'no')->where('created_at', 'LIKE', '%'.date("Y-m-d").'%')->orderBy('id', 'desc')->paginate(10);
        }

        Session::put('debts', $sales_send);
        $branches = CompanyBranch::all();

        Session::put('date_from', $date_from);
        Session::put('date_to', $date_to);

        $cats = Category::All();
        $company = Company::find(1);
        $pass = [
            'i' => 1,
            'c' => 1,
            'cats' => $cats,
            'sales' => $sales,
            'branches' => $branches,
            'company' => $company
        ];
        return view('pages.dash.debts')->with($pass);
    }

}
