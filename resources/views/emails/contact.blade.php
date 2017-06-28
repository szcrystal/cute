<?php 
/* Here is mail view */
?>

<?php //$info = DB::table('siteinfos')->first();
use App\Setting;

$setting = Setting::first();

?>

@if($is_user)
{{$per_name}}　様
<br /><br />
{!! nl2br($setting->mail_header) !!}
@else
{{$per_name}}様より、お問い合わせがありました。<br />
頂きました内容は下記となります。<br />
@endif


<br /><br />
………………………………………………………………………………………
<br /><br />

◆お問い合わせカテゴリー<br />
{{$ask_cate}}<br /><br />


◆お名前<br />
{{$per_name}}<br /><br />

◆メールアドレス<br />
{{$per_email}}<br /><br />

◆年齢<br />
{{$age}}<br /><br />

◆学校<br />
{{$school}}<br /><br />

◆電話番号<br />
{{$tel_num}}<br /><br />

◆郵便番号<br />
{{$post_num}}<br /><br />

◆住所<br />
{{$address}}<br /><br />

◆お問い合わせ内容<br />
{!! nl2br($context) !!}
<br /><br />

@if(isset($attach_1) && $attach_1 != '')
◆画像1<br />
<img style="width:85%; display:block; margin:auto;" src="{{ $message->embed(base_path() . '/storage/app/public/' .$attach_1) }}">
<br><br>
@endif

@if(isset($attach_2) && $attach_2 != '')
◆画像2<br />
<img style="width:85%; display:block; margin:auto;" src="{{ $message->embed(base_path() . '/storage/app/public/' .$attach_2) }}">
@endif

<br /><br /><br /><br />

{!! nl2br($setting->mail_footer) !!}

<br><br><br><br><br><br>


