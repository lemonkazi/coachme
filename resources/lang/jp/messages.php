<?php

    return [
        'image' => [
            'required' => 'ファイルが必要です',
            'image' => 'ファイルは有効な画像ではありません',
            'mimes' => '無効な画像形式',
            'url' => '画像は有効なURLである必要があります',
            'max' => '画像サイズは20 MB未満にする必要があります',
        ],
        'document' => [
            'required' => 'ファイルが必要です',
            'mimes' => '無効なドキュメント形式',
            'max' => 'ドキュメントサイズは20 MB未満である必要があります',
            'invalid' => 'ファイルが無効です',
            'error' => 'ファイルをアップロードできませんでした',
        ],

        'unauthorized_to_create_service_admin' => 'サービス管理者を作成または更新する権限がありません',
        'unauthorized_to_create_service_and_building_admin' => 'サービスおよび建物管理者を作成または更新する権限がありません',
        'unauthorized_to_other_building_admin' => '他の建物管理者を作成または更新する権限がありません',
        'unauthorized_to_other_city_admin' => '他のビルディングショップ管理者を作成または更新する権限がありません',
        'unauthorized_to_other_building_city_admin' => '他のショップ管理者を作成または更新する権限がありません',
        'success_message' => 'リクエストが成功しました',
        'user_success_message' => '変更が完了しました',
        'error_message' => '要求が失敗しました',
        'company_insert_message' => '会社と会社のフロアデータを正常に挿入する',
        'company_update_message' => '会社と会社のフロアデータを正常に更新する',
        'company_not_created' => '新しい会社は作成されませんでした！',
        'company_floors_not_found' => '会社のフロアが見つかりません',
        'company_record_not_found' => '会社の記録が見つかりません',
        'news_insert_message' => 'ニュースデータを正常に挿入しました',
        'news_updated_message' => 'ニュースデータを更新しました',
        'users' => [
            'deleted_successfully' => 'アイテムは正常に削除されました',
            'could_not_be_deleted' => 'アイテムを削除できませんでした',
        ],        
        'registration' => [
            'success_message' => '登録に成功',
            'error_message' => '登録に失敗しました',
        ],
        'user_id' => [
            'required' => 'ユーザー名を選択してください',
            'numeric' => 'ユーザー値は数値である必要があります',
        ],
        'news_id' => [
            'required' => 'ニュースIDを取得できません',
            'numeric' => 'ユーザー値は数値である必要があります',
            'invalid' => 'ニュースが無効です',
        ],
        'manual' => [
            'invalid' => '手動IDが無効です',
        ],
        'city_id' => [
            'required' => '地域を選択してください',
            'numeric' => '市の値は数値である必要があります',
            'invalid' => '市が無効です',
            "filled"=>"ビル名を入力してください",
        ],
        'city_block_id' => [
            'required' => '市名を選択してください',
            'numeric' => '市の値は数値である必要があります',
            'invalid' => '市が無効です',
        ],
        'name' => [
            'required' => '氏名を入力してください',
            'max' => '名前は50文字未満にする必要があります',
        ],
        'nickname' => [
            'required' => 'ユーザー名を入力してください',
            'max' => 'ニックネーム50文字未満にする必要があります',
        ],
        'email' => [
            'required' => 'メールアドレスを入力してください',
            'string' => 'メールアドレスはテキストである必要があります',
            'email' => '正しいメールアドレスを入力してください',
            'max' => '電子メールアドレスは255文字未満である必要があります',
            'already_registered' => '電子メールアドレスはすでに登録されています',
        ],
        'password' => [
            'required' => 'パスワードを入力してください',
            'min' => 'パスワードは8文字以上にする必要があります',
            'confirmed' => 'パスワードが一致していません',
            'same' => '新しいパスワードと確認パスワードは同じでなければなりません',
            'current'=>'現在のパスワードが一致しません'
        ],
        'current_password' => [
            'required' => '現在のパスワードを入力してください',
            'min' => 'パスワードは８文字以上で設定してください',
            'confirmed' => '現在のパスワードが一致していません',
            'current'=>'現在のパスワードが一致しません'
        ],
        'new_password' => [
            'required' => '新しいパスワードを入力してください',
            'min' => 'パスワードは８文字以上で設定してください',
            'confirmed' => '新しいパスワードが一致していません',
            'current'=>'新しいパスワードが一致しません',
            'same' =>'パスワードが一致していません'
        ],
        'image_path' => [
            'required' => 'アイコンを選択してください',
            'url' => '画像は有効なURLである必要があります'
        ],
        'gender' => [
            'required' => '性別を選択してください',
            'string' => '性別の値はテキストである必要があります',
            'in' => '性別の値は、男性、女性、その他のみです',
        ],
        'birthday' => [
            'required' => '生年月日を入力してください',
            'date_format' => '誕生日はyyyy/mm/dd形式である必要があります',
        ],
        'department' => [
            'required' => '部署名を入力してください',
            'string' => '部署はテキストでなければなりません',
        ],
        'authority' => [
            'required' => '権限を選択してください',
            'in' => '権限はSERVICE_ADMIN、CITY_ADMIN、USERのいずれかである必要があります',
        ],
        'token' => [
            'required' => 'トークンが必要です'
        ],
        'content_type' => [
            'required_with' => 'コンテンツタイプは必須です',
            'in' => 'コンテンツタイプは、EVENT、NEWS、WORKのいずれかである必要があります'
        ],
        'content_id' => [
            'required_with' => 'コンテンツIDは必須です',
            'numeric' => 'コンテンツIDは数値である必要があります',
            'invalid' => 'コンテンツIDが無効です',
        ],
        'delivery_date' => [
            'required' => '配信日時を設定してください',
            'date_format' => '配達日の形式はyyyy/mm/dd H：iである必要があります',
        ],
        'point' => [
            'required' => 'ポイント入力してください',
            'numeric' => 'ポイント値は数値である必要があります',
            'deleted_successfully' => 'ポイントは正常に削除されました',
            'could_not_be_deleted' => 'ポイントを削除できませんでした',
        ],

    ];
