<?php

namespace App\Http\Controllers\Main;

use App\Contact;
use App\ContactCate;
use App\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Mail;

class ContactController extends Controller
{
    public function __construct(Contact $contact, ContactCate $contactCate, Mail $mail, Setting $setting)
    {
        //$this->middleware('auth');
        
        $this-> contact = $contact;
        $this->contactCate = $contactCate;
        //$this->article = $article;
        $this->mail = $mail;
        $this->setting = $setting;
        
        //$this->user = Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$cate_option = $this->contactCate->all();
        
//        $cate_option = $objs->map(function ($obj) {
//    		return $obj->cate_name;
//		});

        return view('main.contact.index', ['cate_option'=>$cate_option]);
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
        $rules = [
        	'askcate_id' => 'required',
            'per_name' => 'required|max:255',
            'per_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
            'tel_num' => 'required|max:255',
//            'admin_password' => 'required|min:6',
        ];
        
        if($request->input('askcate_id') == 1) {
        	$addArr = [
            	'age' => 'required|max:255',
                'school' => 'required|max:255',
            ];
            
            $rules = array_merge($rules, $addArr);
        }
        
        $message = [ //lang内に記載
        	'askcate_id.required' => '「お問合わせ種別」は必須です。',
//            'per_name.required' => '「お問合わせ種別」は必須です。',
//            'per_email.required' => '「お問合わせ種別」は必須です。',
//            'per_name.required' => '「お問合わせ種別」は必須です。',
//            'per_email.required' => '「お問合わせ種別」は必須です。',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする

//		print_r($data['pic_1']);
//        exit;
        
        
        $contactModel = $this->contact;
        
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        $conId = $contactModel->id;
        
        
        
        //Thumbnail upload
        if(isset($data['pic_1'])) {
            
            $filename = $data['pic_1']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            $pre = time() . '-';
            $filename = 'contact/' . $conId . '/' . $pre . $filename;
            
            $path =  $data['pic_1']->storeAs('public', $filename);
            
            $contactModel->pic_1 = $path;
            $contactModel->save();
            
            $data['attach_1'] = $filename;
        }
        
        if(isset($data['pic_2'])) {
            
            $filename = $data['pic_2']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            
            $pre = time() . '-';
            $filename = 'contact/' . $conId . '/' . $pre . $filename;
            
            $path =  $data['pic_2']->storeAs('public', $filename);
            
            $contactModel->pic_2 = $path;
            $contactModel->save();
            
            $data['attach_2'] = $filename;
        }
        
		$data['ask_cate'] = $this->contactCate->find($data['askcate_id'])->cate_name;
        
        $this->sendMail($data);
        //$this->fakeMail($data);
        

        return view('main.contact.done')->with('status', '送信されました！');
        //return redirect('mypage/'.$id.'/edit')->with('status', '記事が追加されました！');
        
    }
    
    private function sendMail($data)
    {
    	$set = $this->setting->get()->first();
        
    	$data['is_user'] = 1;
        Mail::send('emails.contact', $data, function($message) use ($data, $set) //引数について　http://readouble.com/laravel/5/1/ja/mail.html
        {
            //$dataは連想配列としてviewに渡され、その配列のkey名を変数としてview内で取得出来る
            $message -> from($set->email, $set->name)
                     -> to($data['per_email'], $data['per_name'])
                     -> subject('お問い合わせの送信が完了しました');
            //$message->attach($pathToFile);
        });
        
        //for Admin
        $data['is_user'] = 0;
        //if(! env('MAIL_CHECK', 0)) { //本番時 env('MAIL_CHECK')がfalseの時
            Mail::send('emails.contact', $data, function($message) use ($data, $set)
            {
                $message -> from($set->email, $set->name)
                         -> to($set->email, $set->name)
                         -> subject('お問い合わせがありました - '. config('app.name', 'Cute.Campus'). ' -');
            });
    }
    
    private function fakeMail($data)
    {
    	Mail::fake();

        // 注文コードの実行…

        Mail::assertSent($this::store(), function ($mail) use ($data) {
            return $mail->name === $data['name'];
        });

        // メッセージが指定したユーザに届いたことをアサート
        Mail::assertSentTo([$data['email']], $this::store());

        // Mailableが送られなかったことをアサート
        Mail::assertNotSent($this::store());
    }
    
    public function aaa()
    {
    	//$this->aaa = "aaa";
    	return "aaa";
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
        //
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
        //
    }
}
