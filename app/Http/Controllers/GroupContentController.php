<?php

namespace App\Http\Controllers;

use App\NewsCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GroupContentController extends Controller {

    public function gcontentshow() {
        if(isset($_GET['keyword'])){
            $news = NewsCat::SearchByKeyword($_GET['keyword'],'')->sortable()->paginate(10);
        }else{
            $news = NewsCat::sortable()->paginate(10);

        }   return view('content.addgroup',compact('news'));

    }

    public function store(Request $req) {
      try{
      \DB::table('news_cat')->insert([
          'type_news_cat' => $req->input('type'),
          'order' => $req->input('order'),
            'name_th' => $req->input('name_th'),
            'name_en' => $req->input('name_en'),
            'create_user' => $req->input('create_name'),
            'create_date' => $req->input('create_date'),
            'last_user' => $req->input('create_name'),
            'last_date' => $req->input('create_date')
        ]);
        return redirect('gcontent?mes=createGContentOK');
      }catch(\Exception $e){
        return redirect('gcontent?mes=createGContentError');
      }
    }

    public function update(Request $req) {
      try{
        \DB::table('news_cat')->where('id', $req->input('id'))->update([
            'type_news_cat' => $req->input('type'),
            'order' => $req->input('order'),
            'name_th' => $req->input('name_th'),
            'name_en' => $req->input('name_en'),
            'last_user' => $req->input('last_user'),
            'last_date' => $req->input('last_date')
        ]);
        return redirect('gcontent?mes=updateGContentOK');
        }catch(\Exception $e){
        return redirect('gcontent?mes=updateGContentError');
        }
    }

    public function destroy(Request $req) {
      try{

        DB::table('news_cat')->where('id', $req->id )->delete();
        return redirect('gcontent?mes=deleteGContentOK');
        }catch(\Exception $e){
        return redirect('gcontent?mes=deleteGContentError');
        }

    }

}
