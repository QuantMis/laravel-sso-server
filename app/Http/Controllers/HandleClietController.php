<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Laravel\Passport\Http\Rules\RedirectRule;
use DataTables;
use Illuminate\Support\Facades\DB;

class HandleClietController extends Controller
{
    protected $clients;
    protected $validation;
    protected $redirectRule;

    public function __construct(
        ClientRepository $clients,
        ValidationFactory $validation,
        RedirectRule $redirectRule
    ) {
        $this->clients = $clients;
        $this->validation = $validation;
        $this->redirectRule = $redirectRule;
    }

    public function index(Request $request)
    {
        return view('client.index');
    }

    //Datatables
    public function getAllClient(Request $request)
    {
        if ($request->ajax()) {
            $userId = $request->user()->getAuthIdentifier();
            $clients = $this->clients->activeForUser($userId);

            $datas = $clients->makeVisible('secret');

            return Datatables::of($datas)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $routeEdit = route('client.edit', ['client_id' => $row->id, 'user_id' => $row->user_id]);
                    $routeDelete = route('client.destroy', ['client_id' => $row->id, 'user_id' => $row->user_id]);
                    $actionBtn = '<a href="' . $routeEdit . '" class="btn-edit">Edit</a> <button onclick="deleteClient(\'' . $row->id . '\', \'' . $row->user_id . '\')" class="btn-hapus">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('client.add');
    }

    public function store(Request $request)
    {
        $this->validation->make($request->all(), [
            'name' => 'required|max:191',
            'redirect' => ['required', $this->redirectRule],
        ])->validate();

        $client = $this->clients->create(
            $request->user()->getAuthIdentifier(), $request->name, $request->redirect,
            null, false, false, (bool) $request->input('confidential', true)
        );

        return redirect()->route('client.index')->with('success', 'Oauth client berhasil ditambahkan');

    }

    public function edit(Request $request, $clientId, $userId) 
    {
        $client = $this->clients->findForUser($clientId, $userId);
        
        return view('client.edit', compact('client'));

    }


    public function update(Request $request, $clientId, $userId)
    {
        $client = $this->clients->findForUser($clientId, $userId);

        $this->validation->make($request->all(), [
            'name' => 'required|max:191',
            'redirect' => ['required', $this->redirectRule],
        ])->validate();

        $this->clients->update(
            $client, $request->name, $request->redirect
        );

        return redirect()->route('client.index')->with('success', 'Oauth client berhasil diubah');
    }

    public function destroy($clientId, $userId)
    {
        $client = $this->clients->findForUser($clientId, $userId);
        $delete = $this->clients->delete($client);

        $deleteData = DB::table('oauth_clients')->where('id', $clientId)->delete();

        if ($delete) {
            return redirect()->route('client.index')->with('success', 'Oauth client berhasil dihapus');
        }

    }
}
