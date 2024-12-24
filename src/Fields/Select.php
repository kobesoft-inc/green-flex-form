<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Repeater;
use Green\FlexForm\Forms\Components\OptionsEditor;

class Select extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.select.label'));
        $this->icon('bi-menu-button-wide');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\Select::make('value'))
                ->options(fn() => $this->getProperty('options'))
                ->native(false),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),

            // 選択肢
            OptionsEditor::make('options')
                ->label(__('green::flex-form.fields.field.options')),
        ]);
    }
}