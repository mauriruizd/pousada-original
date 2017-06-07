<?php
namespace App\Repositories;

use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository {
    use PaginatesFromRequest;
}