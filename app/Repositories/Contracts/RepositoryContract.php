<?php

namespace App\Repositories\Contracts;

interface RepositoryContract {
    public function all($columns = array('*'));
    public function count();
    public function create($data = array());
    public function updateBySlug($data = array(), $slug);
    public function updateById($data = array(), $id);
    public function updateByModel($data = array(), $model);
    public function deleteBySlug($slug);
    public function deleteById($id);
    public function deleteByModel($model);
    public function paginate($itemsPerPage = 15, $columns = array('*'));
    public function findBySlug($slug);
    public function findById($id);
    public function findManyByIds($ids = []);
    public function orderByAsc($col);
    public function orderByDesc($col);
    public function limit($limit = 0);
    public function where($compareFrom, $operator = '=', $compareTo);
}
