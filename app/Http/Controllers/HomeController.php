<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $calendar = $request->input('calendar', date('Y-m-d'));

        $records = Todo::whereRaw('userid=? AND DATE(planed_at)=?',[Auth::id(),$calendar])->orderByRaw('planed_at ASC')->get();
        
        return view('view.todo',['records' => $records,
                                 'calendar' => $calendar]);
    }

    public function addTodo(Request $request)
    {

        $content = $request->content;
        $datetime = $request->datetime;
        Todo::insert(['userid' => Auth::id(),
                      'content' => $content,
                      'planed_at' => $datetime]);
        
        $calendar = substr($datetime,0,10);
        return redirect('home?calendar='.$calendar);
    }

    public function finishTodo(Request $request)
    {
        $todoId = $request->id;

        Todo::where('id',$todoId)->update(['finished_at' => date('Y-m-d H:i:s')]);

        return redirect('home');
    }

    public function check(Request $request)
    {
        if(isset($_POST['del'])){
            $delIds = $request->checks;
            foreach ($delIds as $id){
                Todo::where('id',$id)->delete();
            }
        }
        else if(isset($_POST['fin'])){
            $finIds = $request->checks;
            foreach($finIds as $id){
                Todo::where('id',$id)->update(['finished_at' => date('Y-m-d H:i:s')]);
            }
        }
        
        $calendar = $request->calendar;

        return redirect('home?calendar='.$calendar);
    }

    public function updateTodo(Request $request)
    {
        $todoId = $request->todoId;
        $content = $request->content;
        $pa = $request->pa;
        $fa = $request->fa;

        if(empty($pa)){
            Todo::where('id',$todoId)->update(['userid' => Auth::id(),
                                        'content' => $content,
                                        'finished_at' => $fa]);
        }else{
            Todo::where('id',$todoId)->update(['userid' => Auth::id(),
                                        'content' => $content,
                                        'planed_at' => $pa]);
        }

        $calendar = $request->calendar;
        return redirect('home?calendar='.$calendar);
    }
}
