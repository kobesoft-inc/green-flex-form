<?php

namespace Green\FlexForm\Fields\Actions;

use Filament\Forms\Components\Builder;

class PropertiesFormAction extends \Filament\Forms\Components\Actions\Action
{
    public function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-cog-6-tooth');

        $this->modal();
        $this->modalWidth('md');
        $this->modalHeading(__('green::flex-form.modal.heading'));
        $this->modalSubmitActionLabel(__('green::flex-form.modal.update'));
        $this->slideOver();

        // モーダル入力フォームの初期値
        $this->fillForm(function (array $arguments, Builder $component) {
            $item = $component->getItemState($arguments['item']);
            return json_decode($item['properties'], true);
        });

        // 入力フォーム送信時の処理
        $this->action(function (array $arguments, Builder $component, array $data) {
            $items = $component->getState();
            $items[$arguments['item']]['data']['properties'] = json_encode($data);
            $component->state($items);
        });

        // 入力フォーム
        $this->form(function (array $arguments, Builder $component) {
            return $component
                ->getBlock($component->getState()[$arguments['item']]['type'])
                ->getPropertiesForm();
        });
    }
}
