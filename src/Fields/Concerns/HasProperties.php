<?php

namespace Green\FlexForm\Fields\Concerns;

use Filament\Forms\Components\Component;
use Filament\Forms\Get;

trait HasProperties
{
    protected array|\Closure|null $propertiesForm = null;
    protected array|\Closure|null $properties = null;

    /**
     * フィールド設定のフォームを設定する
     *
     * @param array|\Closure|null $propertiesForm
     * @return $this
     */
    public function propertiesForm(array|\Closure|null $propertiesForm): static
    {
        $this->propertiesForm = $propertiesForm;
        return $this;
    }

    /**
     * フィールド設定のフォームを取得する
     *
     * @return array
     */
    public function getPropertiesForm(): array
    {
        return $this->evaluate($this->propertiesForm) ?? [];
    }

    /**
     * フィールド設定を設定します。
     *
     * @param array|\Closure|null $properties フィールド設定
     * @return $this
     */
    public function properties(array|\Closure|null $properties): static
    {
        $this->properties = $properties;
        return $this;
    }

    /**
     * フィールド設定を取得します。
     *
     * @return array
     */
    public function getProperty(string $name): mixed
    {
        if (is_array($this->properties)) {
            return $this->properties[$name] ?? null;
        } else {
            return $this->evaluate($this->properties, ['name' => $name]);
        }
    }
}