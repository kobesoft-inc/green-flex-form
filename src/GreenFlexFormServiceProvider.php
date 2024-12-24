<?php

namespace Green\FlexForm;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

class GreenFlexFormServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * アプリケーションサービスを登録する
     *
     * @return void
     */
    public function register(): void
    {
    }

    /**
     * アプリケーションサービスの起動処理を行う
     *
     * @return void
     */
    public function boot(): void
    {
        // アセットを登録
        FilamentAsset::register([
            Css::make('green-flex-form', __DIR__ . '/../resources/css/green-flex-form.css'),
        ], 'kobesoft/green-flex-form');

        // ローカライズ
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'green');
    }
}