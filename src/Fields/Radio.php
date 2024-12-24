<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Repeater;
use Green\FlexForm\Forms\Components\OptionsEditor;

class Radio extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.radio.label'));
        $this->icon('bi-check-circle');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\Radio::make('value'))
                ->options(fn() => $this->getProperty('options')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),

            // 選択肢
            OptionsEditor::make('options')
                ->label(__('green::flex-form.fields.field.options')),
        ]);
    }
}