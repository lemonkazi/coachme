<?php 
    return [
        'logout_success' => 'ログアウトしました',
        'refresh_token' => [
            'required' => 'refresh_tokenは必須です',
        ],
        'grant_type' => [
            'required' => 'grant_typeは必須です',
            'in' => 'grant_typeは、passwordおよびrefresh_tokenのいずれかである必要があります',
        ],
        'grant_type_otp' => [
            'in' => 'grant_typeはotpでなければなりません',
        ],
        'client_id' => [
            'required' => 'client_idは必須です',
            'numeric' => 'client_idは数値でなければなりません',
            'max' => 'client_idが大きすぎます',
        ],
        'client_secret' => [
            'required' => 'client_secretは必須です',
        ],
        'client_type' => [
            'required' => 'client_typeは必須です',
            'in' => 'client_typeはIOS、Android、Webのいずれかである必要があります',
        ],
        'push_token' => [
            'required' => 'push_tokenは必須です',
        ],
        'invalid_request' => '更新トークンが無効です',
        'invalid_credentials' => 'メールアドレスもしくはパスワードが異なっています',
        'invalid_grant' => 'メールアドレスもしくはパスワードが異なっています',
        'invalid_client' => 'client_idまたはclient_secretが正しくありません',
        'unauthenticated' => 'ユーザーは認証されていません',
        'not_found' => '見つかりません',
        'out_of_date' => 'ポイント付与期間外のためポイントを獲得できませんでした',
        'qrcode_expire' => 'QRコードは既に使用されています。',
        'low_balance' => 'ポイント交換に必要なポイントが足りません',
        'client_id_not_exists' => 'クライアントIDが存在しません',
        'client_id_not_match_user_id' => 'クライアントIDとユーザーIDが一致しません',
        'user_not_match_otp' => '認証コードが一致しません',
        'time_expired' => '時間切れです',
        'verified_user' => '確認済みユーザーになりました',
        'unknown_phone_user' => 'この電話番号は既に使われています',
        'user_not_found' => 'ユーザーが見つかりません',
        'version_not_found' => '再ログインしてください',
        'otp_send_success' => 'OTPが送信されました',
        'email_send_reset_password' => 'パスワードをリセットして正常に送信',
        'reset_password_title' => 'パスワードのURLをリセット',
        'reset_password_subject' => 'パスワードのリセットURLのメール',
        'data_not_found' => 'データが見つかりません',
        'update_password_successfully' => 'パスワードが正常に更新されました',
        'time_is_over' => 'パスワードの更新時間は24時間にする必要があります',
        'please_complete_signup' => '本人認証が完了していません。電話番号を利用して本人認証を行ってください',
    ];