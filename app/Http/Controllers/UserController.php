<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


      if(isset($_GET['keyword'])){
          $users = User::SearchByKeyword($_GET['keyword'],'')->sortable()->paginate(10);
      }else{
          $users = User::sortable()->paginate(10);

      }   return view('user.index', ['users' => $users]);
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
      try{
      DB::table('users')->insert([
        'name' => $request->input('nameuser'),
        'email' => $request->input('nameuser'),
        'password' => bcrypt("123456"),
        'create_user' => $request->input('create_user'),
        'created_at' => $request->input('create_date'),
        'updated_at' => $request->input('create_date'),
      ]);
      return redirect('user?mes=addUserOK');
    }catch(\Exception $e){
       return redirect('user?mes=addUserError');
    }
}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function show($id)
//    {
        //
  //  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function edit($id)
  //  {
    //}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  //  public function update(Request $request)
    //{
        //
    //}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $req) {
        try{
       DB::table('users')->where('id', $req->id )->delete();
         return redirect('user?mes=fileDelOK');
       }catch(\Exception $e){
          return redirect('user?mes=errorFile');
       }
     }
}
