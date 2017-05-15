@extends('layouts.appDashBoard')

@section('content')
	
	<h3 class="page-header">問い合わせ編集</h3>

    <div class="bs-component clearfix">
        <div class="pull-left">
            <a href="{{ url('/dashboard/contacts') }}" class=""><i class="fa fa-angle-double-left" aria-hidden="true"></i>一覧へ戻る</a>
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Error!!</strong> 追加できません<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
	@if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
        
    <div class="well">
        <form class="form-horizontal" role="form" method="POST" action="/dashboard/contacts/{{$id}}">

            {{ csrf_field() }}

            {{ method_field('PUT') }}


            	<div class="table-responsive">
                    <table class="table table-bordered">
                        <colgroup>
                            <col style="background: #fefefe; width: 25%;" class="cth">
                            <col style="background: #fefefe;" class="ctd">
                        </colgroup>
                        
                        <tbody>
                            <tr>
                                <th>問合わせ日</th>
                                <td>
                                    {{ Ctm::changeDate($contact->created_at) }}
                                </td>
                            </tr>

                            <tr>
                                <th>カテゴリー</th>
                                <td>{{ $contact->ask_category }}</td>
                            </tr>
                            <tr>
                                <th>名前</th>
                                <td>{{ $contact->per_name }}</td>
                            </tr>
                            <tr>
                                <th>メール</th>
                                <td><a href="mailto:{{ $contact->per_email }}">{{ $contact->per_email }}</a>

                                </td>
                            </tr>
                            <tr>
                                <th>年齢</th>
                                <td>{{ $contact->age }}</td>
                            </tr>
                            <tr>
                                <th>学校・所属</th>
                                <td>{{ $contact->school }}</a></td>
                            </tr>

							<tr>
                                <th>電話番号</th>
                                <td>{{ $contact->tel_num }}</td>
                            </tr>
                            <tr>
                                <th>郵便番号</th>
                                <td>{{ $contact->post_num }}</a></td>
                            </tr>

                            <tr>
                                <th>写真１</th>
                                <td><img src="{{ Storage::url($contact->pic_1) }}" width="60%"></td>
                            </tr>

                            <tr>
                                <th>写真２</th>
                                <td><img src="{{ Storage::url($contact->pic_2) }}" width="60%"></td>
                            </tr>


                            <tr>
                                <th style="height:15em;">コメント</th>
                                <td>{!! nl2br($contact->context) !!}</td>
                            </tr>

                            {{--
                            <tr>
                                <th>対応状況</th>
                                <td>
                                    <div class="form-group{{ $errors->has('done_status') ? ' has-error' : '' }}">
                                        <div class="col-md-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="done_status" value="1"{{isset($contact) && $contact->done_status ? ' checked' : '' }}> 対応済みにする
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            --}}

                            <tr>

                            </tr>
                            

                        </tbody>
                    </table>
                </div>

                {{--
                <div class="form-group">
                    <div class="col-md-4 col-md-offset-2">
                        <button type="submit" class="btn btn-primary center-block w-btn">更　新</button>
                    </div>
                </div>
                --}}

        </form>
    </div>

@endsection
