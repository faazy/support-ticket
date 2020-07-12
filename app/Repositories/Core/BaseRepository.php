<?php


namespace App\Repositories\Core;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryContract
{

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $searchable = [];

    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param $value
     * @param string $field
     * @param array $with
     * @return Model
     */
    public function findByFiled($value, string $field, $with = [])
    {
        return $this->model->with($with)->where($field, $value)->firstOrFail();
    }

    /**
     * @param \Closure|null $filterClosure
     * @return LengthAwarePaginator
     */
    public function paginatedCollection(?\Closure $filterClosure = null)
    {
        $query = $this->model->newQuery();
        $this->applyFilters($query);

        //Add Custom Filtering options
        if ($filterClosure instanceof Closure) {
            $filterClosure($query);
        }

        return $query->paginate();
    }

    /**
     * @param $query
     */
    protected function applyFilters(&$query)
    {
        $term = request()->get('q');
        foreach ($this->searchable as $field => $condition) {

            if (request()->filled($field)) {
                $value = request()->get($field);
                $query->where($field, $value);
            } else if (request()->filled($condition)) {
                $value = request()->get($condition);
                $query->where($condition, $value);
            }

            if (request()->filled('q')) {
                if ($condition == 'OR') {
                    $query->orWhere($field, 'LIKE', '%' . $term . '%');
                } else {
                    $query->where($condition, 'LIKE', '%' . $term . '%');
                }
            }
        }
    }
}
