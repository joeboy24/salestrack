<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Fee;
use App\Book;
use App\Course;
use App\Member;
// use App\Stage;
use App\Gallery;
use App\Teacher;
use App\Student;
use App\Company;
// use App\Payable;
use App\Expense;
use App\Feereport;
use App\CompanyBranch;
use DB;
use Session;

class PagesController extends Controller
{


    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'try']]);
    }



    public function index(){

        if (Session::has('sales')){}else{
            // Set session variables
            
            Session::put('b1', '');
            Session::put('b2', '');
            Session::put('b3', '');
            Session::put('gross', '');
            Session::put('net', '');
            Session::put('sales', '');
            Session::put('cash', '');
            Session::put('cheque', '');
            Session::put('momo', '');
            Session::put('sum_dbt', '');
            Session::put('expenses', '');
            Session::put('date_today', date('Y-m-d'));
        }
        return view('pages.index')->with('title');
    }

    public function dashuser(){

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $c = 1; $i = 1; $o = 1;
        $users = User::orderBy('id', 'DESC')->get();
        $teachers = Teacher::orderBy('id', 'DESC')->get();
        $stages = Stage::All();
        $courses = Course::All();

        $pass = [
            'c' => $c,
            'i' => $c,
            'o' => $c,
            't' => $c,
            'users' => $users,
            'stages' => $stages,
            'teachers' => $teachers,
            'courses' => $courses
        ];
        //return view('pages.dash.postsview')->with($pass);
        return view('pages.dash.dashuser')->with($pass);
    }

    public function expenses(){
        
        $match = ['del' => 'no'];
        $expenses = Expense::where('user_id', auth()->user()->id)->where('del', 'no')->where('created_at', 'LIKE', '%'.date('Y-m-d').'%')->orderBy('id', 'DESC')->paginate(20);
        $branches = CompanyBranch::all();

        $pass = [
            'i' => 1,
            'branches' => $branches,
            'expenses' => $expenses
        ];

        return view('pages.dash.expenses')->with($pass);
    }

    public function dashboard(){

        $user = User::all();
        $users = count($user);

        $pass = [
            'users' => $users
        ];

        //$count = App\Flight::where('active', 1)->count();

        return view('pages.dash.dashboard')->with($pass);
    }

    public function configurations(){

        return 'working';

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $r = 1;
        $p = 1;
        // $payables = Payable::All();
        // $stages = Stage::All();
        $company = Company::All();
        $results = Company::find(1);
        $company_branch = CompanyBranch::All();

        $pass = [
            'r' => $r,
            'p' => $p,
            // 'stages' => $stages,
            'results' => $results,
            'company' => $company,
            'company_branch' => $company_branch,
            // 'payables' => $payables
        ];

        // if (count($results) > 0){
            return view('pages.dash.configuration')->with($pass);
        // }else{
        //     return view('pages.dash.configuration');
        // }
        
    }

    public function studentsrecycler(){

        if(auth()->user()->status != 'Administrator'){
            return redirect('/dashboard'); 
        }

        $c = 1;
        $i = 1;
        $stages = Stage::All();
        $payables = Payable::All();
        $allStudents = Student::where('del', 'yes')->get();
        $students = Student::where('del', 'yes')->orderBy('id', 'desc')->paginate(10);
        $std_pop = count($allStudents);

        $pass = [
            'i' => $i,
            'c' => $c,
            'stages' => $stages,
            'std_pop' => $std_pop,
            'payables' => $payables,
            'students' => $students
        ];
        return view('pages.dash.studentsrecycler')->with($pass);
    }

    public function try(){

        // $users = User::all();
        // $books = Book::all();

        // $pass = [
        //     'books' => $books,
        //     'users' => $users
        // ];

        //$count = App\Flight::where('active', 1)->count();

        return 1234;
    }

}

