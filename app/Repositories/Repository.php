<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryContract;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryContract{

    protected $model;
    protected $app;

    /**
     * Initialize dependencies
     * @param App $app 
     */
    public function __construct(App $app){
        $this->app = $app;
        $this->model = $this->makeModel();
    }

    /**
     * Model namespace
     * @return String 
     */
    public abstract function model();

    /**
     * Create instance of model based on return value of model() method.
     * @return mixed 
     */
    public function makeModel(){
        $tmpModel = $this->app->make($this->model());

        if(!$tmpModel instanceof Model){
            return $tmpModel . ' is not an instance of Model';
        }

        return $tmpModel;
    }

    /**
     * Fetch all records.
     * @param  array  $columns 
     * @return Collection          
     */
    public function all($columns = array('*')){
        return $this->model
                    ->all($columns);
    }

    /**
     * Count all records.
     * @return int 
     */
    public function count(){
        return $this->model->count();
    }

    /**
     * Insert new record.
     * @param  array  $data 
     * @return mixed       
     */
    public function create($data = array()){
        $instance = $this->model
                        ->create($data);
        return $instance;
    }

    /**
     * Find record that has the specefied slug, and update it's record based on data passed.
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function updateBySlug($data = array(), $id){
        $updated = $this->model
                        ->findBySlugOrFail($slug)
                        ->update($data);

        if(!$updated){
            return 'Update failed.';
        }

        $updated->resluggify()
                ->save();

        return $updated;
    }

    /**
     * Find record that has the specefied id, and update it's record based on data passed.
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function updateById($data = array(), $id){
        $entry = $this->model
                        ->findOrFail($id);
        $updated = $entry->update($data);

        if(!$entry){
            return 'Update failed.';
        }

        return $entry;
    }

    /**
     * Find record that has the specefied slug, and delete.
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function deleteBySlug($slug){
        return $this->model
                    ->findBySlugOrFail($slug)
                    ->delete();
    }

    /**
     * Find record that has the specefied id, and delete.
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function deleteById($id){
        return $this->model
                    ->findOrFail($id)
                    ->delete();
    }

    /**
     * Update passed model's data with the passed data..
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function updateByModel($data = array(), $model){
        return $model->update($data);
    }

    /**
     * Delete passed model.
     * @param  array  $data 
     * @param  mixed $id   
     * @return mixed       
     */
    public function deleteByModel($model){
        return $model->delete();
    }

    /**
     * Paginate Items.
     * @param  integer $itemsPerPage 
     * @param  array   $columns      
     * @return mixed                
     */
    public function paginate($itemsPerPage = 15, $columns = array('*')){
        return $this->model
                    ->paginate($itemsPerPage, $columns);
    }

    /**
     * Find a record by it's slug.
     * @param  mixed $slug 
     * @return mixed       
     */
    public function findBySlug($slug){
        return $this->model
                    ->findBySlugOrFail($slug);
    }

    public function findBy($col, $val = null){
        if(!is_array($col)) return $this->model->where($col, $val)->limit(1)->first();

        return $this->model->where($col)->limit(1)->first();
    }
    
    /**
     * Find a record by it's id.
     * @param  mixed $id 
     * @return mixed       
     */
    public function findById($id){
        return $this->model
                    ->findOrFail($id);
    }

    public function findManyByIds($ids = []){
        if(!is_array($ids)){
            return $this->findById(($ids));
        }

        return $this->model->whereIn('id', $ids)->get();
    }
    
    public function limit($limit = 0){
        return $this->model
                    ->limit($limit);
    }

    public function orderByAsc($col){
        return $this->model
                    ->orderBy($col, 'asc')
                    ->get();
    }

    public function orderByDesc($col){
        return $this->model
                    ->orderBy($col, 'desc')
                    ->get();
    }

    public function where($compareFrom, $operator = '=', $compareTo){
        return $this->model
                    ->where($compareFrom, $operator, $compareTo)
                    ->get();
    }
    
}
