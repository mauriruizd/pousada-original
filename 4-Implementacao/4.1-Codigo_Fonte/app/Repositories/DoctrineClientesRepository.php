<?php
namespace App\Repositories;

use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineClientesRepository extends DoctrineBaseRepository implements ClientesRepository {
    use PaginatesFromRequest;
}