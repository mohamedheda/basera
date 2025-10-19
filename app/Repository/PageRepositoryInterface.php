<?php

namespace App\Repository;

interface PageRepositoryInterface extends RepositoryInterface
{
    public function getBySlug(string $slug);
}
