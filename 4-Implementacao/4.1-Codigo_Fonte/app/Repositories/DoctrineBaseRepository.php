<?php
namespace App\Repositories;

use Doctrine\Common\Util\Inflector;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineBaseRepository extends EntityRepository {

    public function create($data)
    {
        $entity = new $this->_entityName();
        return $this->prepare($entity, $data);
    }

    public function update($id, $data)
    {
        $entity = $this->find($id);

        return $this->prepare($entity, $data);
    }

    public function save($object, $flush = true)
    {
        $this->_em->persist($object);
        if ($flush) {
            $this->_em->flush($object);
        }
        return $object;
    }

    public function saveMany($array)
    {
        foreach ($array as $object) {
            $this->save($object, false);
        }
        $this->_em->flush();
        return $array;
    }

    public function delete($object)
    {
        $this->_em->remove($object);
        $this->_em->flush($object);
        return true;
    }

    public function prepare($entity, $data)
    {
        $set = 'set';
        $whitelist = $entity->whitelist();

        foreach ($whitelist as $field) {
            if (isset($data[$field])) {
                $setter = $set . Inflector::classify($field);
                $entity->$setter($data[$field]);
            }
        }
        return $entity;
    }

    public function searchAndPaginate($queryString, $perPage = 15, $pageName = 'page')
    {
        $searchableFields = ($this->_entityName)::searchableFields();
        $builder = $this->createQueryBuilder('o');
        $or = $builder->expr()->orx();
        foreach ($searchableFields as $field) {
            $or->add($builder->expr()->like('o.' . $field, "'%" . $queryString . "%'"));
        }
        $builder->where($or);
        return $this->paginate($builder->getQuery(), $perPage, $pageName);
    }
}