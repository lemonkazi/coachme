<?php 


  return [
      'company' => [
          'name' => '企業名を入力してください',
          'companyFloors' => 'company_floorsは配列である必要があります',
          'buildingId' => '建物IDは必須です',
          'buildingIdType' => '建物IDは数値でなければなりません',
          'startFloor' => '開始階番号が必要です',
          'startFloorType' => '開始フロアは数値でなければなりません',
          'endFloor' => '終了階番号が必要です',
          'endFloorType' => '終了階は数値でなければなりません',
          'notIn' => '床をゼロにすることはできません',
          'greaterThan' => '終了階は開始階以上である必要があります'
      ],
      'news' => [
          'title' => 'タイトルを入力してください',
          'description' => '本文を入力してください',
          'delivery_date' => '公開期間を設定してください',
          'delivery_date_format' => '入力形式を確認してください',
          'end_date' => '公開期間を設定してください',
          'status' => 'ステータスを選択してください',
          "in"=>"ステータス値はRELEASED、DRAFTのいずれかである必要があります",
          "after"=>"公開期間の終了日は開始日よりも後に設定してください"
      ],
  ];

