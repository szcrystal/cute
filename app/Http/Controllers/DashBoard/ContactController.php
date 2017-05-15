<?php

namespace App\Http\Controllers\DashBoard;

use App\Admin;
use App\Contact;
use App\ContactCate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
	public function __construct(Admin $admin, Contact $contact, ContactCate $contactCate)
    {
    	
        $this -> middleware('adminauth');
        //$this -> middleware('log', ['only' => ['getIndex']]);
        
        $this -> admin = $admin;
        $this->contact = $contact;
        $this->contactCate = $contactCate;
        
        $this->perPage = 20;

	}
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::orderBy('id', 'desc')->paginate($this->perPage);
        
        $cateModel = $this->contactCate;
        
        //$atcl = $this->article;
        //$status = $this->articlePost->where(['base_id'=>15])->first()->open_date;
        
        return view('dashboard.contact.index', ['contacts'=>$contacts, 'cateModel'=>$cateModel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cates = $this->contactCate->all();
        
        return view('dashboard.contact.addCate', ['cates'=>$cates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'cate_name' => 'required|max:255',
//            'admin_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
        
        $this->contactCate->fill($data);
        $this->contactCate->save();
        
        return redirect('dashboard/contacts/create')->with('status', 'お問合わせカテゴリーが追加されました');
    }
    
    //cate編集
    public function getEditCate($cateId)
    {
    	$cate = $this->contactCate->find($cateId);
        
        return view('dashboard.contact.editCate', ['cate'=>$cate, 'cateId'=>$cateId]);
    }
    
    //cate編集（Post）
    public function postEditCate(Request $request, $cateId)
    {
    	$rules = [
            'cate_name' => 'required|max:255',
        ];
        $this->validate($request, $rules);
        
    	$cate = $this->contactCate->find($cateId);
        $cate->cate_name = $request->input('cate_name');
        $cate->save();
        
        
        return view('dashboard.contact.editCate', ['cate'=>$cate, 'cateId'=>$cateId, 'status'=>'お問合わせカテゴリーが更新されました']);
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = $this->contact->find($id);
        //$atcl = $this->article;
        
    	return view('dashboard.contact.form', ['contact'=>$contact, 'id'=>$id]);
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
        $name = $this->contactCate->find($id)->cate_name;
        
//        $atcls = $this->contactCate->where('cate_id', $id)->get()->map(function($atcl){
//        	$atcl->cate_id = 0;
//            $atcl->save();
//        });
        
        $atclDel = $this->contactCate->destroy($id);
        
        $status = $atclDel ? 'カテゴリー「'.$name.'」が削除されました' : 'カテゴリー「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/contacts/create')->with('status', $status);
    }
}
