@extends('layouts.app')

@section('content')
        <div class="col-md-12 mx-auto contact">
            <div class="panel panel-default">

                <div class="panel-heading">
                	<h2>お問い合わせ</h2>
                    <p>当社へサービスに関するお問い合わせは下記フォームよりお願いいたします。<br>内容により返信できない場合もありますのであらかじめご了承ください。<br>お客様から取得したお名前、ご連絡先電話番号、回答先メールアドレス、ご住所などの個人情報（その他お客様からいただいた情報のうち個人情報に該当するものを含む）およびお問い合わせの内容の利用目的は、次のとおりです。</p>
<ul>
<li>ご意見、ご要望、お問い合わせへの対応および確認
<li>商品、サービスの改善のための分析
<li>応対サービス向上のための分析
</ul>
<p>当社は、お客様の個人情報の流出・漏洩の防止、その他個人情報の安全管理のために必要かつ適切な措置を講じるものとし、法令などに正当な理由がある場合を除き、お客様の同意なく目的外での利用および第三者への提供は行いません。</p>
                </div>

                <div class="panel-body">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!!</strong> 追加できません<br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

					<div class="table-responsive col-md-10 mx-auto">
                    	<form class="form-horizontal" role="form" method="POST" action="/contact">
                            {{ csrf_field() }}

                            <input type="hidden" name="done_status" value="0">

                        <table class="table table-bordered">
                            <colgroup>
                                <col class="cth">
                                <col class="ctd">
                            </colgroup>
                            
                            <tbody>
                                <tr>
                                	<th>お問い合わせ内容</th>
                                    <td>
										<div class="form-group{{ $errors->has('askcate_id') ? ' has-error' : '' }}">

                                            <div class="col-md-8">
                                                    <select class="form-control" name="askcate_id">
                                                    	<option selected disabled>選択</option>
                                                        @foreach($cate_option as $val)
                                                            <option value="{{ $val->id }}"{{ old('askcate_id') && old('askcate_id') == $val->id ? ' selected' : '' }}>{{ $val->cate_name }}</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('askcate_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('askcate_id') }}</strong>
                                                        </span>
                                                    @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>


                                <tr>
                                	<th>お名前</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('per_name') ? ' has-error' : '' }}">
                                            {{-- <label for="per_name" class="col-md-4 control-label">お名前</label> --}}

                                            <div class="col-md-12">
                                                <input id="per_name" type="text" class="form-control" name="per_name" value="{{ old('per_name') }}" required>

                                                @if ($errors->has('per_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('per_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>メールアドレス</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('per_email') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="per_email" type="per_email" class="form-control" name="per_email" value="{{ old('per_email') }}" required>

                                                @if ($errors->has('per_email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('per_email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                                    </td>
                                </tr>

                                <tr>
                                	<th>年齢</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('per_name') ? ' has-error' : '' }}">
                                            {{-- <label for="per_name" class="col-md-4 control-label">お名前</label> --}}

                                            <div class="col-md-12">
                                                <input id="per_name" type="text" class="form-control" name="per_name" value="{{ old('per_name') }}" required>

                                                @if ($errors->has('per_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('per_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>学校</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('per_name') ? ' has-error' : '' }}">
                                            {{-- <label for="per_name" class="col-md-4 control-label">お名前</label> --}}

                                            <div class="col-md-12">
                                                <input id="per_name" type="text" class="form-control" name="per_name" value="{{ old('per_name') }}" required>

                                                @if ($errors->has('per_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('per_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>電話番号</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('tel_num') ? ' has-error' : '' }}">
                                            {{-- <label for="per_name" class="col-md-4 control-label">お名前</label> --}}

                                            <div class="col-md-12">
                                                <input id="tel_num" type="text" class="form-control" name="tel_num" value="{{ old('tel_num') }}" required>

                                                @if ($errors->has('tel_num'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('tel_num') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>郵便番号</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('post_num') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="post_num" type="text" class="form-control" name="post_num" value="{{ old('post_num') }}" required>

                                                @if ($errors->has('post_num'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('post_num') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>住所</th>
                                    <td>
                                    	<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}">

                                                @if ($errors->has('address'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('address') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                    	</div>
                    				</td>
                                </tr>

                                <tr>
                                	<th>写真１</th>
                                    <td>
                                    	<div class="clearfix thumb-wrap">
                                            <div class="col-md-4 pull-left thumb-prev">
                                                @if(count(old()) > 0)
                                                    @if(old('post_thumb') != '' && old('post_thumb'))
                                                    <img src="{{ Storage::url(old('post_thumb')) }}" class="img-fluid">
                                                    @elseif(isset($atcl) && $atcl->thumb_path)
                                                    <img src="{{ Storage::url($atcl->thumb_path) }}" class="img-fluid">
                                                    @else
                                                    <span class="no-img">No Image</span>
                                                    @endif
                                                @elseif(isset($atcl) && $atcl->thumb_path)
                                                    <img src="{{ Storage::url($atcl->thumb_path) }}" class="img-fluid">
                                                @else
                                                    <span class="no-img">No Image</span>
                                                @endif
                                            </div>

                                            <div class="col-md-8 pull-left text-left form-group{{ $errors->has('post_thumb') ? ' has-error' : '' }}">
                                                <label for="post_thumb" class="col-md-12">写真１</label><br>
                                                <div class="col-md-12">
                                                    <input id="post_thumb" class="post_thumb thumb-file" type="file" name="post_thumb">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                	<th>写真２</th>
                                    <td>
                                        <div class="clearfix thumb-wrap">
                                            <div class="col-md-4 pull-left thumb-prev">
                                                @if(count(old()) > 0)
                                                    @if(old('post_thumb') != '' && old('post_thumb'))
                                                    <img src="{{ Storage::url(old('post_thumb')) }}" class="img-fluid">
                                                    @elseif(isset($atcl) && $atcl->thumb_path)
                                                    <img src="{{ Storage::url($atcl->thumb_path) }}" class="img-fluid">
                                                    @else
                                                    <span class="no-img">No Image</span>
                                                    @endif
                                                @elseif(isset($atcl) && $atcl->thumb_path)
                                                    <img src="{{ Storage::url($atcl->thumb_path) }}" class="img-fluid">
                                                @else
                                                    <span class="no-img">No Image</span>
                                                @endif
                                            </div>

                                            <div class="col-md-8 pull-left text-left form-group{{ $errors->has('post_thumb') ? ' has-error' : '' }}">
                                                <label for="post_thumb" class="col-md-12">写真２</label><br>
                                                <div class="col-md-12">
                                                    <input id="post_thumb" class="post_thumb thumb-file" type="file" name="post_thumb">
                                                </div>
                                            </div>
                                        </div>
                                	</td>
                                </tr>

                                <tr>
                                	<th>コメント</th>
                                    <td>
										<div class="form-group{{ $errors->has('context') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <textarea id="context" class="form-control" name="context" required>{{ old('context') }}</textarea>

                                                @if ($errors->has('context'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('context') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>



                            </tbody>
                		</table>
                        <div class="form-group">
                            <div class="col-md-3 mx-auto">
                                <button type="submit" class="btn btn-primary col-md-12">送信</button>
                            </div>
                        </div>
                    </form>
                    </div>


            </div><!-- panel -->

        </div>
@endsection
