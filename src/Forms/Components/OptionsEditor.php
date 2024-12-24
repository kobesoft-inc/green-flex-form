<?php

namespace Green\FlexForm\Forms\Components;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;

/**
 * 選択肢一覧を編集するコンポーネント
 * 選択肢の順序変更、名前変更に追従するために、Repeaterコンポーネントを拡張する
 */
class OptionsEditor extends \Filament\Forms\Components\Repeater
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->simple(TextInput::make('value'));

        $this->defaultItems(0);

        $this->afterStateHydrated(static function (Repeater $component, ?array $state): void {
            $items = [];
            if (!($simpleField = $component->getSimpleField())) {
                throw new \Exception('The OptionsEditor component requires a simple field.');
            }
            foreach ($state ?? [] as $itemKey => $itemData) {
                $items[$itemKey] = [$simpleField->getName() => $itemData];
            }
            $component->state($items);
        });

        $this->mutateDehydratedStateUsing(static function (Repeater $component, ?array $state): array {
            if (!($simpleField = $component->getSimpleField())) {
                throw new \Exception('The OptionsEditor component requires a simple field.');
            }
            $simpleFieldName = $simpleField->getName();
            return collect($state ?? [])
                ->mapWithKeys(static function ($item, $key) use ($simpleFieldName) {
                    return [$key => $item[$simpleFieldName]];
                })
                ->all();
        });

        $this->generateUuidUsing(fn() => Str::ulid());
    }
}
