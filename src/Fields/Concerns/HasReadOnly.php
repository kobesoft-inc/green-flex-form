<?php

namespace Green\FlexForm\Fields\Concerns;

trait HasReadOnly
{
    /**
     * 子コンポーネントを読み込み専用にする
     *
     * @param bool|callable $readOnly
     * @return $this
     */
    public function readOnly(bool|callable $readOnly = true): static
    {
        static::eachComponents($this->getChildComponents(), function ($component) use ($readOnly) {
            if (method_exists($component, 'readOnly')) {
                $component->readOnly($readOnly);
            }
        });
        return $this;
    }

    static private function eachComponents(array $components, callable $callback): void
    {
        foreach ($components as $component) {
            /// @var \Filament\Forms\Components\Component $component
            if (method_exists($component, 'getChildComponents')) {
                static::eachComponents($component->getChildComponents(), $callback);
            }
            $callback($component);
        }
    }
}