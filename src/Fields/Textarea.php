<?php

namespace Green\FlexForm\Fields;

use Illuminate\Support\HtmlString;

class Textarea extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.textarea.label'));
        $this->icon('bi-textarea');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\Textarea::make('value')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),
        ]);
    }
}