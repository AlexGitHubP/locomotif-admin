<?php

namespace Locomotif\Admin\Controller;

use Locomotif\Admin\Models\Accounts;
use Locomotif\Admin\Models\Users;
use Locomotif\Media\Controller\MediaController;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Hash;

class AccountsController extends Controller
{

    public function __construct(){
        $this->middleware(['authgate:administrator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $items = Accounts::whereIn('type', ['designer', 'client'])->get();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('accounts::list')->with('items', $items);
    }
    
    public function getDesignersAccounts(){
        $designerAccounts = Accounts::where('type', '=', 'designer')->get();
        return $designerAccounts;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'    => 'required',
            'surname' => 'required',
            'email'   => 'required',
            'status'  =>'required'
        ]);
        
        
        //create new user
        $user = Users::create(['name' => $request->name,'email' => $request->email]);
        //set the role for the user
        setUserRole($request->type, $user->id);
        
        //save designer
        $account = new Accounts();

        $account->name         = $request->name;
        $account->user_id      = $user->id;
        $account->type         = $request->type;
        $account->surname      = $request->surname;
        $account->email        = $request->email;
        $account->phone        = $request->phone;
        $account->url          = $request->url;
        $account->description  = $request->description;
        $account->ordering     = getOrdering($account->getTable(), 'ordering');
        $account->status       = $request->status;
        
        $account->save();
        

        return redirect('admin/accounts/'.$account->id.'/edit');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function show(Accounts $account)
    {
        return view('accounts::show')->with('account', $account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounts $account)
    {
        $associatedMedia = app(MediaController::class)->mediaAssociations($account->getTable(), $account->id);
        return view('accounts::edit')->with('item', $account)->with('associatedMedia', $associatedMedia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accounts $account)
    {
       
        $request->validate([
            'name'    => 'required',
            'surname' => 'required',
            'email'   => 'required',
            'status'  =>'required'
        ]);

        setUserRole($account->type, $account->user_id);

        $account->name         = $request->name;
        $account->surname      = $request->surname;
        $account->email        = $request->email;
        $account->type         = $request->type;
        $account->phone        = $request->phone;
        $account->url          = $request->url;
        $account->description  = $request->description;
        $account->status       = $request->status;
        
        $account->save();
        
        return redirect('admin/accounts/'.$account->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounts  $accounts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounts $account)
    {
        $account->delete();
        return redirect('/admin/accounts');
    }



    public function listDesigners(){
        $items = Accounts::where('type', '=', 'designer')->get();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('designers::list')->with('items', $items);
    }

    public function listClients(){
        $items = Accounts::where('type', '=', 'client')->get();
        foreach ($items as $key => $value) {
            $items[$key]->status_nice = mapStatus($value->status);
        }
        return view('clients::list')->with('items', $items);
    }
    

}
