<?php

namespace App\Repository\Eloquent;

use App\Models\Page;
use App\Repository\PageRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class PageRepository extends Repository implements PageRepositoryInterface
{
    protected Model $model;

    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function getBySlug(string $slug)
    {
        return $this->model::query()->where('slug', $slug)->first();
    }
}
