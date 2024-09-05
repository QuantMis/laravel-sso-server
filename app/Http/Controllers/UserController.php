<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function getAllUser(Request $request)
    {
        if ($request->ajax()) {

            $users = User::query();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void()" class="bg-amber-500 py-2 px-3">Edit</a> <a href="javascript:void()" class="bg-red-500 py-2 px-3">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
