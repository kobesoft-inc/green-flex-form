<?php

namespace Green\FlexForm\Fields;

use Filament\Forms\Get;

class FileUpload extends Field
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('green::flex-form.fields.file-upload.label'));
        $this->icon('bi-upload');

        $this->columns(12);
        $this->schema([
            $this->applyGeneral(\Filament\Forms\Components\FileUpload::make('value')),
        ]);

        $this->propertiesForm(fn() => [
            ...$this->getGeneralForm(),
        ]);
    }
}