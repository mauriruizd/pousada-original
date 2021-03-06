<?php
namespace App\Repositories;

interface TiposQuartosRepository {
    public function find($id);
    public function findAll();
    public function create($data);
    public function update($id, $data);
    public function save($object);
    public function delete($object);
    public function searchAndPaginate($queryString, $perPage = 15, $pageName = 'page');
}