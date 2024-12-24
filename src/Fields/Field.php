<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Components\Component;
use Illuminate\Support\HtmlString;

class Field extends \Filament\Forms\Components\Builder\Block
{
    use Concerns\HasReadOnly;
    use Concerns\HasProperties;

    protected string $view = 'filament-forms::components.group';

    protected Component $propertyComponent;
    protected bool $forDesigner = false;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * スキーマを設定する
     *
     * @param \Closure|array $components コンポーネントの配列
     * @return $this
     */
    public function schema(\Closure|array $components): static
    {
        return parent::schema(fn() => [
            ...$this->evaluate($components),
        ]);
    }

    /**
     * FlexFormDesigner用のスキーマを設定する
     *
     * @return Field $this
     */
    public function makeForDesigner(): static
    {
        // デザイナー用の設定をしたかを示すフラグを立てる
        // すでに設定済みの場合は何もしない
        if ($this->forDesigner) {
            return $this;
        }
        $this->forDesigner = true;

        // プロパティの取得方法を設定する
        $this->properties(function (string $name) {
            $properties = json_decode($this->propertyComponent->getState(), true);
            return $properties[$name] ?? null;
        });

        // スキーマに追加する
        return $this->schema([
            ...$this->getChildComponents(),

            // IDを保持するための非表示フィールド
            \Filament\Forms\Components\Hidden::make('id')
                ->default(fn() => (string)\Illuminate\Support\Str::ulid()),

            // フィールド設定を保持するための非表示フィールド
            $this->propertyComponent = \Filament\Forms\Components\Hidden::make('properties')
                ->default(fn() => json_encode($this->getDefaultProperties())),
        ]);
    }

    /**
     * 複数行テキストをHTML文字列に変換する
     *
     * @param string|null $text 複数行テキスト
     * @return HtmlString|null HTML文字列
     */
    protected function escapeMultilineText(string|null $text): \Illuminate\Support\HtmlString|null
    {
        if (is_null($text)) {
            return null;
        }
        return new \Illuminate\Support\HtmlString(
            nl2br(htmlspecialchars($text))
        );
    }

    /**
     * 共通する設定をフィールドに適用する
     */
    protected function applyGeneral(\Filament\Forms\Components\Field $field): \Filament\Forms\Components\Field
    {
        $field->label(fn() => $this->getProperty('label'));
        $field->helperText(fn() => $this->escapeMultilineText($this->getProperty('description')));
        if (method_exists($field, 'placeholder')) {
            $field->placeholder(fn() => $this->getProperty('placeholder'));
        }
        $field->columnSpanFull();
        return $field;
    }

    /**
     * 共通する設定スキーマを取得する
     *
     * @return array 共通する設定スキーマ
     */
    protected function getGeneralForm(): array
    {
        return [
            // ラベル
            \Filament\Forms\Components\TextInput::make('label')
                ->label(__('green::flex-form.fields.field.label')),

            // 説明文
            \Filament\Forms\Components\Textarea::make('description')
                ->label(__('green::flex-form.fields.field.description')),

            // プレースホルダー
            \Filament\Forms\Components\TextInput::make('placeholder')
                ->label(__('green::flex-form.fields.field.placeholder')),
        ];
    }

    /**
     * フィールドの設定のデフォルト値を取得する
     *
     * @return array 設定の値
     */
    protected function getDefaultProperties(): array
    {
        return [
            'label' => $this->getLabel(),
        ];
    }
}
