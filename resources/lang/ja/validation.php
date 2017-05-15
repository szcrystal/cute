<?php  // resources/lang/ja/validation.php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attributeを承認してください。',
    'active_url'           => ':attributeは正しいURLではありません。',
    'after'                => ':attributeは:date以降の日付にしてください。',
    'alpha'                => ':attributeは英字のみにしてください。',
    'alpha_dash'           => ':attributeは英数字とハイフンのみにしてください。',
    'alpha_num'            => ':attributeは英数字のみにしてください。',
    'array'                => ':attributeは配列にしてください。',
    'before'               => ':attributeは:date以前の日付にしてください。',
    'between'              => [
        'numeric' => 'The :attributeは:min〜:maxまでにしてください。',
        'file'    => 'The :attributeは:min〜:max KBまでのファイルにしてください。',
        'string'  => 'The :attributeは:min〜:max文字にしてください。',
        'array'   => 'The :attributeは:min〜:max個までにしてください。',
    ],
    'boolean'              => ':attributeはtrueかfalseにしてください。',
    'confirmed'            => ':attributeが確認用:attributeと一致していません。',
    'date'                 => ':attributeは正しい日付を入力して下さい。',
    //'date_format'          => ':attributeは":format"書式と一致していません。',
    'date_format'          => ':attributeは0000-00-00の書式で正しい数値を入力して下さい。',
    'different'            => ':attributeは:otherと違うものにしてください。',
    'digits'               => ':attributeは:digits桁にしてください',
    'digits_between'       => ':attributeは:min〜:max桁にしてください。',
    'email'                => ':attributeを正しい形式にしてください。',
    'filled'               => ':attributeは必須です。',
    'exists'               => '登録された:attributeではないようです。',
    'image'                => ':attributeは画像にしてください。',
    'in'                   => '選択された:attributeは正しくありません。',
    'integer'              => ':attributeは整数にしてください。',
    'ip'                   => ':attributeを正しいIPアドレスにしてください。',
    'max'                  => [
        'numeric' => ':attributeは:max以下にしてください。',
        'file'    => ':attributeは:max KB以下のファイルにしてください。.',
        'string'  => ':attributeは:max文字以下にしてください。',
        'array'   => ':attributeは:max個以下にしてください。',
    ],
    'mimes'                => ':attributeは:valuesタイプのファイルにしてください。',
    'min'                  => [
        'numeric' => ':attributeは:min以上にしてください。',
        'file'    => ':attributeは:min KB以上のファイルにしてください。.',
        'string'  => ':attributeは:min文字以上にしてください。',
        'array'   => ':attributeは:min個以上にしてください。',
    ],
    'not_in'               => '選択された:attributeは正しくありません。',
    'numeric'              => ':attributeは半角数字にしてください。',
    'regex'                => ':attributeの書式が正しくありません。',
    'required'             => ':attributeは必須です。',
    'required_if'          => ':otherが:valueの時、:attributeは必須です。',
    'required_with'        => ':valuesが存在する時、:attributeは必須です。',
    'required_with_all'    => ':valuesが存在する時、:attributeは必須です。',
    'required_without'     => ':valuesが存在しない時、:attributeは必須です。',
    'required_without_all' => ':valuesが存在しない時、:attributeは必須です。',
    'same'                 => ':attributeと:otherは一致していません。',
    'size'                 => [
        'numeric' => ':attributeは:sizeにしてください。',
        'file'    => ':attributeは:size KBにしてください。.',
        'string'  => ':attribute:size文字にしてください。',
        'array'   => ':attributeは:size個にしてください。',
    ],
    'string'               => ':attributeは文字列にしてください。',
    'timezone'             => ':attributeは正しいタイムゾーンを指定してください。',
    'unique'               => ':attributeが既に存在します。',
    'url'                  => ':attributeを正しい書式にしてください。',
    'future'			   => ':attributeは現在より先の指定はできません。',
    'date_check'		   => ':attributeは正しい値を入力して下さい。',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
            'passwords.user' => 'パスワード',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
    	'email' => '「メールアドレス」', //for login register
        'user_id' => '「ユーザーID（メールアドレス）」', //for login
        'password' => '「パスワード」', //for login register
        'user_name' => '「お名前」', // forお問い合わせ
        'user_email' => '「メールアドレス」',// forお問い合わせ
        'ask_category' => 'お問合わせ内容',
        'name' => '「名前」',
        'email' => '「メールアドレス」',
        'context' => '「コメント」',
        'title' => '「タイトル」',
        'cate_id' => '「カテゴリー」',
        'movie_site' => '「動画サイト」',
        'movie_url' => '「動画URL」',
        'slug' => '「スラッグ」',
        'category' => '「カテゴリー」',
        'address' => '「所在地」',
        'sub_title' => '「サブタイトル」',
        'url_name' => '「リンク名」',
        'company_name' => '「企業名」',
        'music_file' => '「ファイル」',
        'org_date' => '「日付」',
        'date_y' => '「日付（年）」',
        'date_m' => '「日付（月）」',
        'date_d' => '「日付（日）」',
        'birth' => '「生年月日」',
        'set_date' => '「日付」',
    ],

];
