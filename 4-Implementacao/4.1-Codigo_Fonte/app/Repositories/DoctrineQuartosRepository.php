<?php
namespace App\Repositories;

use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineQuartosRepository extends DoctrineBaseRepository implements QuartosRepository
{
    use PaginatesFromRequest;
}