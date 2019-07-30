<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Logger;


class LogController extends Controller
{
    public function index(Request $request) {

        $filter = $request->get('filter', false);
        $order = $request->get('order', 'created_at');
        $sort = $request->get('sort', 'desc');

        if ($filter) {
            if ($request->get('filter') === 'logs') {
                $logger = Logger::orderBy($order, $sort)->paginate(10);
            }
        } else {
            $logger = Logger::orderBy($order, $sort)->paginate(10);

        }
//        $logger = Logger::paginate(10);
        return view('admin.logs.index', compact('logger', 'filter', 'order', 'sort'));

    }

    public function createLog($desc, $model) {

        $log = new Logger();
        $log->description = $desc;
        $log->username = Auth::user()->name;
        $log->model = $model;
        $log->save();

    }

    public function destroy() {

        Logger::truncate();
//        $logg->delete();

        return redirect(route('admin.logs.index'))->with('status', ['type' => 'success', 'message' => __('Logs deleted successfully')]);

    }

    public function search(Request $request) {


        $logger = Logger::where('username', 'like', "%{$request->search}%")
        ->orWhere('model', 'like', "%{$request->search}%")
        ->orWhere('description', 'like', "%{$request->search}%")
        ->paginate(20);

        $filter = $request->get('filter', false);
        $order = $request->get('order', 'created_at');
        $sort = $request->get('sort', 'desc');

    
    return view('admin.logs.index', compact('logger', 'filter', 'order', 'sort'));

    }
}
