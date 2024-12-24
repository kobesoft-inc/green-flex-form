<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Get;

class DatePicker extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.date-picker.label'));
        $this->icon('bi-calendar');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\DatePicker::make('value')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),
        ]);
    }
}