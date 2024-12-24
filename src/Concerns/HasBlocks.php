<?php

namespace Green\FlexForm\Concerns;

use Green\FlexForm\Fields;

trait HasBlocks
{
    protected array $blocks = [];

    /**
     * ブロックの定義を追加する
     *
     * @param array $blocks
     * @return $this
     */
    public function blocks(array $blocks): static
    {
        $this->blocks = [
            ...$this->blocks,
            ...$blocks
        ];

        return $this;
    }

    /**
     * ブロックの定義を取得する
     *
     * @return array
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * FlexFormDesignerに表示するためのブロックの定義を作成する
     *
     * @return HasBlocks
     */
    public function makeForDesigner(): static
    {
        foreach ($this->getBlocks() as $block) {
            $block->makeForDesigner();
        }
        return $this;
    }

    /**
     * ブロック名からブロックの定義を取得する
     *
     * @param string $name
     * @return Fields\Field
     */
    public function getBlock(string $name): Fields\Field
    {
        return collect($this->getBlocks())
            ->first(fn($block) => $block->getName() === $name);
    }

    /**
     * デフォルトのブロックの定義を取得する
     */
    public function makeDefaultBlocks(): array
    {
        $blocks = [
            Fields\TextInput::make('text-input'),
            Fields\Textarea::make('textarea'),
            Fields\Radio::make('radio'),
            Fields\Checkbox::make('checkbox'),
            Fields\Select::make('select'),
            Fields\FileUpload::make('file-upload'),
            Fields\DatePicker::make('date-picker'),
            Fields\TimePicker::make('time-picker'),
        ];
        return $blocks;
    }
}