<?php

namespace App\Http\Controllers\DashBoard;

use App\Category;
use App\Article;
use App\CategoryItem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
	public function __construct(Category $category, Article $article, CategoryItem $categoryItem)
    {
    	$this->category = $category;
        $this->article = $article;
        $this->categoryItem = $categoryItem;
        
        $this->itemCount = 10;
        $this->perPage = 30;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cates = Category::orderBy('id', 'desc')->paginate($this->perPage);
           //->take(10)
        
        $atclModel = $this->article->where('feature', 0)->get();
        
        $cateItem = $this->categoryItem;
        
        return view('dashboard.category.index', ['cates'=>$cates, 'cateItem'=>$cateItem, 'atclModel'=>$atclModel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$itemCount = $this->itemCount;
        
        return view('dashboard.category.form', ['itemCount'=>$itemCount]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $editId = $request->input('edit_id');
        
        $rules = [
            'name' => 'required|unique:categories,name,'.$editId.'|max:255',
            'slug' => 'required|unique:categories,slug,'.$editId.'|max:255', /* 注意:unique */
        
            'title.*' => 'required_with:second.*',
            'second.*' => 'required_with:title.*|integer|nullable',
        ];
        
        $messages = [
            'name.required' => '「カテゴリー名」は必須です。',
            'name.unique' => '「カテゴリー名」が既に存在します。',
            'slug.unique' => '「スラッグ」が既に存在します。',
            'title.*.required_with' => '「アイテム」のタイトルを入力して下さい。',
            'second.*.required_with' => '「アイテム」の秒数を入力して下さい。',
        	'second.*.integer' => '「秒数」は半角数字を入力して下さい。',
        ];
        
        $this->validate($request, $rules, $messages);
        
        $data = $request->all(); //requestから配列として$dataにする
        
//        if(! isset($data['open_status'])) { //checkbox
//        	$data['open_status'] = 0;
//        }
        

        if($request->input('edit_id') !== NULL ) { //update（編集）の時
        	$status = 'カテゴリーが更新されました！';
            $cateModel = $this->category->find($request->input('edit_id'));
        }
        else { //新規追加の時
            $status = 'カテゴリーが追加されました！';
            $data['view_count'] = 0;
        	$cateModel = $this->category;
        }
        
        $cateModel->fill($data); //モデルにセット
        $cateModel->save(); //モデルからsave
        
        $cateId = $cateModel->id;
        
        
        //Item Save
        $titles = $data['title'];
        $seconds = $data['second'];
        $itemNums = $data['item_num'];
        
        //$items = $this->categoryItem->where('cate_id'=>$cateId)->get();
        
        
        foreach($titles as $key => $title) {
        	
            if(isset($data['del_item'][$key]) && $data['del_item'][$key]) {
                
            	$itemModel = $this->categoryItem->where(['item_num'=>$itemNums[$key], 'cate_id'=>$cateId])->first();
                
                if($itemModel !== null) {
	                $itemModel ->delete();
    			}
//                $snapModel = $this->modelSnap->create(
//                    [
//                        'model_id'=>$modelId,
//                        'number'=> $count+1,
//                    ]
//                );
            }
        	else if($title != '') {
                $this->categoryItem->updateOrCreate(
                    ['item_num'=>$itemNums[$key], 'cate_id'=>$cateId],
                    [
                        'item_num'=>$itemNums[$key],
                        'title'=>$title,
                        'second'=>$seconds[$key],
                    ]
                );
            }
            
        }
        
        //Item numberを振り直す
        $num = 1;
        $items = $this->categoryItem->where(['cate_id'=>$cateId])->get();
        
        foreach($items as $item) {
            $item->item_num = $num;
            $item->save();
            $num++;
        }
        
        
        

        return redirect('dashboard/cates/'.$cateId)->with('status', $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cate = $this->category->find($id);
        
        $cateItem = $this->categoryItem->where(['cate_id'=>$id])->get()->all();
		
        $itemCount = $this->itemCount;

    	return view('dashboard.category.form', ['cate'=>$cate, 'cateItem'=>$cateItem, 'itemCount'=>$itemCount, 'id'=>$id, 'edit'=>1]);
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
        $name = $this->category->find($id)->name;
        
        $atcls = $this->article->where('cate_id', $id)->get()->map(function($atcl){
        	$atcl->cate_id = 0;
            $atcl->save();
        });
        
        $cateDel = $this->category->destroy($id);
        
        $status = $cateDel ? 'カテゴリー「'.$name.'」が削除されました' : '記事「'.$name.'」が削除出来ませんでした';
        
        return redirect('dashboard/cates')->with('status', $status);
    }
}
