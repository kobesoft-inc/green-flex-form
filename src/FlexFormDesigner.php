<?php

namespace Green\FlexForm;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Concerns;
use Green\FlexForm\Concerns\HasBlocks;

class FlexFormDesigner extends Component
{
    use Concerns\HasName;
    use HasBlocks;

    protected string $view = 'filament-forms::components.group';
    protected Builder $builder;

    final public function __construct(string $name)
    {
        $this->blocks($this->makeDefaultBlocks());
        $this->schema(fn() => [$this->makeComponent($name)]);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();
        return $static;
    }

    /**
     * Builderコンポーネントを構築する
     *
     * @param string $name コンポーネント名
     * @return Builder Builderコンポーネント
     */
    protected function makeComponent(string $name): Builder
    {
        $this->makeForDesigner();
        return $this->builder = Builder::make($name)
            ->label(fn() => $this->getLabel())
            ->blocks($this->getBlocks())
            ->blockLabels(false)
            ->addActionLabel(__('green::flex-form.actions.add-field'))
            ->addBetweenActionLabel(__('green::flex-form.actions.add-field'))
            ->extraAttributes([
                'class' => 'green-flex-form-designer',
            ])
            ->extraItemActions([
                // 設定のモーダル入力ダイアログを表示するアクション
                Fields\Actions\PropertiesFormAction::make('settings-form'),
            ])
            ->afterStateHydrated(fn(Builder $component, array $state) => $component->state($this->hydrate($state)))
            ->mutateDehydratedStateUsing(fn(array $state) => $this->dehydrate($state));
    }

    /**
     * 整理されたBuilderコンポーネントの状態を復元する
     *
     * @param array $state 整理されたBuilderコンポーネントの状態
     * @return array 復元された状態
     */
    protected function hydrate(array $state): array
    {
        return collect($state)
            ->mapWithKeys(function ($block) {
                return [$block['id'] => [
                    'type' => $block['type'],
                    'data' => [
                        'id' => $block['id'],
                        'properties' => json_encode($block['properties']),
                    ],
                ]];
            })
            ->toArray();
    }

    /**
     * Builderコンポーネントの状態を整理する
     *
     * @param array $state Builderコンポーネントの状態
     * @return array 整理された状態
     */
    protected function dehydrate(array $state): array
    {
        return collect($state)
            ->map(function ($block) {
                return [
                    'type' => $block['type'],
                    'id' => $block['data']['id'],
                    'properties' => json_decode($block['data']['properties'], true),
                ];
            })
            ->values()
            ->toArray();
    }
}