<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Get;

class TextInput extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.text-input.label'));
        $this->icon('bi-input-cursor-text');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\TextInput::make('value')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),
        ]);
    }
}