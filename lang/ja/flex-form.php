<?php

declare(strict_types=1);

return [
    // デザイナーフォーム
    'actions' => [
        'add-field' => 'フィールドを追加',
    ],

    // モーダル
    'modal' => [
        'heading' => 'フィールド設定',
        'update' => '更新',
    ],

    // フィールド
    'fields' => [
        // フィールド
        'field' => [
            'label' => 'ラベル',
            'description' => '説明',
            'placeholder' => 'プレースホルダー',
            'required' => '必須',
            'options' => '選択肢',
        ],

        // テキスト入力
        'text-input' => [
            'label' => '単一行テキスト',
        ],

        // テキストエリア
        'textarea' => [
            'label' => '段落テキスト',
        ],

        // ドロップダウン
        'select' => [
            'label' => 'ドロップダウン',
        ],

        // ラジオボタン
        'radio' => [
            'label' => 'ラジオボタン',
        ],

        // チェックボックス
        'checkbox' => [
            'label' => 'チェックボックス',
        ],

        // ファイル
        'file-upload' => [
            'label' => 'ファイルのアップロード',
        ],

        // 日付
        'date-picker' => [
            'label' => '日付',
        ],

        // 時刻
        'time-picker' => [
            'label' => '時刻',
        ],
    ]
];