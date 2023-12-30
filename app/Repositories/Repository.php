<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository extends BaseRepository
{
    
    private $app;

    private $fqcn;

    public function __construct(App $app)
    {
        $modelFQCN = str_replace('\\Repositories\\', '\\Models\\', static::class);

        $this->fqcn =  preg_replace('@Repository$@', '', $modelFQCN);

        $this->app = $app;

        $this->setModel();

        parent::__construct($app);
    }

    public function setModel(): void
    {
        $model = $this->app->make($this->fqcn);
        
        if (!$model instanceof Model) {
            throw new \RuntimeException("Class {$model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        
        $this->setInstanceModel($model);
    }
}