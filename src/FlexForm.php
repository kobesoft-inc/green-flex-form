<?php

namespace Green\FlexForm;

use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Green\FlexForm\Concerns\HasBlocks;

class FlexForm extends Component
{
    use Concerns\HasName;
    use HasBlocks;

    protected string $view = 'filament-forms::components.group';
    protected Group $group;
    protected array $blocks = [];
    protected array|\Closure|null $flexForm = null;

    final public function __construct(string $name)
    {
        $this->blocks($this->makeDefaultBlocks());
        $this->schema(fn() => [$this->makeComponent($name)]);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();
        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * フォームの定義を設定する
     *
     * @param array|\Closure|null $flexForm フォームの定義
     * @return static コンポーネント
     */
    public function flexForm(array|\Closure|null $flexForm): static
    {
        $this->flexForm = $flexForm;
        return $this;
    }

    /**
     * フォームの定義を取得する
     *
     * @return array フォームの定義
     */
    public function getFlexForm(): array
    {
        return $this->evaluate($this->flexForm);
    }

    /**
     * コンポーネントを構築する
     *
     * @param string $name コンポーネント名
     * @return Group コンポーネント
     */
    protected function makeComponent(string $name): Group
    {
        $this->group = Group::make(
            collect($this->getFlexForm())
                ->map(function ($field) {
                    return $this
                        ->getBlock($field['type'])
                        ->properties($field['properties'])
                        ->statePath($field['id'])
                        ->getClone();
                })
                ->toArray()
        )->statePath($name);
        return $this->group;
    }
}