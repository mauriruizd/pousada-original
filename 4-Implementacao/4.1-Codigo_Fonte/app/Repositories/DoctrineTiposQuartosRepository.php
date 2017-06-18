<?php
namespace App\Repositories;

use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineTiposQuartosRepository extends DoctrineBaseRepository implements TiposQuartosRepository {
    use PaginatesFromRequest;
}