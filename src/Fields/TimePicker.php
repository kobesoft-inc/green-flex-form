<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Get;

class TimePicker extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.time-picker.label'));
        $this->icon('bi-clock');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\TimePicker::make('value')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),
        ]);
    }
}