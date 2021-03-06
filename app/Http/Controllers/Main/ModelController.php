<?php

namespace App\Http\Controllers\Main;

use App\User;
use App\State;
use App\ModelSnap;
use App\TwAccount;
use App\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ModelController extends Controller
{
    public function __construct(User $user, State $state, ModelSnap $modelSnap, TwAccount $twAccount, Article $article)
    {
        //$this->middleware('auth');
        
        $this-> user = $user;
        $this->state = $state;
        $this->modelSnap = $modelSnap;
        $this->twAccount = $twAccount;
        //$this->contactCate = $contactCate;
        $this->article = $article;
        
        $this->perPage = env('PER_PAGE', 12);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($state = 'all')
    {
		$whereArr = [];
        
        if($state != 'all') {
        	$stateObj = $this->state->where('slug', $state)->get()->first();
            
            //404
            if(!isset($stateObj)) abort(404);
            
            $whereArr['state_id'] = $stateObj->id;
        }
        
        $user = $this->user->where($whereArr)->whereNotIn('id',[1, 2]);
        $newModel = $user->orderBy('created_at','DESC')->take(3)->get();
        
        $models = $user->orderBy('created_at','DESC')->paginate($this->perPage);

		return view('main.model.index', ['models'=>$models, 'newModel'=>$newModel, 'modelSlide'=>1]);
    }
    
    
    public function showSingle($state, $id)
    {
        $model = $this->user->find($id);
        
        $twa = $this->twAccount->where('model_id', $id)->get()->first();
        
        $snaps = $this->modelSnap->where('model_id', $id)->orderBy('number', 'ASC')->get();
        
        //Other Atcl
        $otherAtcl = $this->article->where(['model_id'=>$id, 'open_status'=>1])->orderBy('created_at','DESC')->take(5)->get();
        
        return view('main.model.single', ['model'=>$model, 'state'=>$state, 'snaps'=>$snaps, 'twa'=>$twa, 'otherAtcl'=>$otherAtcl]);
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
            'per_name' => 'required|max:255',
            'per_email' => 'required|email|max:255', /* |unique:admins 注意:unique */
            'askcate_id' => 'required',
//            'admin_password' => 'required|min:6',
        ];
        
        $this->validate($request, $rules);
        
        $data = $request->all(); //requestから配列として$dataにする
//		echo $data['askcate_id'];
//        exit;
        
        
        $contactModel = $this->contact;
        
        $contactModel->fill($data); //モデルにセット
        $contactModel->save(); //モデルからsave
        //$id = $postModel->id;
        
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
