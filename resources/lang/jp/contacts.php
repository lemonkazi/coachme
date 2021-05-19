<?php
return [  
    "insert_message"=>"正常に挿入された",  
    "name"=>[
        "required"=>"ユーザークエリ名を入力してください",
        "max"=>"名前は255文字未満にする必要があります",
        'string' => '名前はテキストである必要があります',
    ],
    "title"=>[
        "required"=>"タイトルは必須です",
        "max"=>"タイトルは100文字未満にする必要があります",
    ],
    "phone_number"=>[
        "required"=>"電話番号が必要です",
        "numeric"=>"電話番号は数字である必要があります",
        "digits_between"=>"電話番号は9から11桁でなければなりません",
    ],
    "description"=>[
        "required"=>"説明を入力してください",
    ],
    "status"=>[
        "required"=>"ステータス値を入力してください", 
        "in"=>"ステータス値はPENDING、INPROGRESS、COMPLETEDのいずれかである必要があります"
    ],
    "user_birthday"=>[
        "date_format"=>"誕生日はyyyy / mm / dd形式である必要があります"
    ]
];