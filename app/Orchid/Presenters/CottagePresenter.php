<?php

declare(strict_types=1);

namespace App\Orchid\Presenters;

use Orchid\Support\Presenter;

class CottagePresenter extends Presenter
{
    public function floor1(): string
    {
        return implode("\n", $this->entity->floor1_features ?? []);
    }

    public function floor2(): string
    {
        return implode("\n", $this->entity->floor2_features ?? []);
    }

    public function floor3(): string
    {
        return implode("\n", $this->entity->floor3_features ?? []);
    }
}
