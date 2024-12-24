<?php

namespace Green\FlexForm\Fields\Concerns;

use Filament\Forms\Components\Component;
use Filament\Forms\Get;

trait HasId
{
    protected string|\Closure|null $id = null;

    /**
     * IDを設定します。
     *
     * @param string|\Closure|null $id ID
     * @return $this
     */
    public function id(string|\Closure|null $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * IDを取得します。
     *
     * @return string|null ID
     */
    public function getId(): ?string
    {
        return $this->evaluate($this->id) ?? 'value';
    }
}