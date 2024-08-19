<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use ReflectionClass;
use Sefirosweb\LaravelOdooConnector\Http\Models\ProductTemplate;
use Sefirosweb\LaravelOdooConnector\Http\Models\StockRoute;
use Tests\TestCase;

class ModelRelationsTest extends TestCase
{
    /**
     * A test all relations.
     *
     * @return void
     */
    public function test_belongs_to()
    {
        //    obten todos los modelos que se usa en este paquete de laravel y obten 1 elemento por cada modelo
        $models = self::getModels();

        try {
            foreach ($models as $model) {
                $modelInstance = new $model;
                $relations = self::get_relations($model);
                $firstItem = $modelInstance::first();
                $this->assertInstanceOf(Model::class, $modelInstance);
                $this->assertNotNull($modelInstance, 'Model instance is null');

                if (!$firstItem) {
                    continue;
                }

                foreach ($relations as $relation) {

                    if (strpos($relation['type'], 'BelongsToMany') !== false) {
                        $relationInstance = $firstItem->{$relation['name']}()->first();
                        continue;
                    }

                    if (strpos($relation['type'], 'BelongsTo') !== false) {
                        $relationInstance = $firstItem->{$relation['name']};
                        continue;
                    }

                    if (strpos($relation['type'], 'HasOne') !== false) {
                        $relationInstance = $firstItem->{$relation['name']};
                        continue;
                    }

                    if (strpos($relation['type'], 'HasMany') !== false) {
                        $relationInstance = $firstItem->{$relation['name']}()->first();
                        continue;
                    }
                }
            }
        } catch (\Exception $e) {
            $this->assertTrue(false, $modelInstance::class . ' ' . $relation['name'] . ' ' . $relation['type'] . ' ' . $e->getMessage());
        }
    }

    /**
     * Get all of the classes in the \App namespace extending the
     * \Illuminate\Database\Eloquent\Model base class.
     *
     * @return array List of absolute model namespace names
     */
    private static function getModels(): array
    {
        // $currentPath = __FILE__ . '/../src/Http/Models';
        $currentPathOffile = __FILE__;
        $path = explode('/', $currentPathOffile);
        $currentPath = '';
        for ($i = 0; $i < count($path) - 2; $i++) {
            $currentPath .= $path[$i] . '/';
        }


        $models = [];
        $files = scandir($currentPath . '/../src/Http/Models');
        foreach ($files as $file) {
            if ($file === '.' || $file === '..' || $file === 'OdooModel.php') {
                continue;
            }

            $model = 'Sefirosweb\LaravelOdooConnector\Http\Models\\' . str_replace('.php', '', $file);

            $models[] = $model;
        }

        return $models;
    }

    public static function get_relations($model)
    {
        $reflector = new ReflectionClass($model);
        $relations = [];
        foreach ($reflector->getMethods() as $reflectionMethod) {
            $returnType = $reflectionMethod->getReturnType();
            if ($returnType) {
                if (in_array(class_basename($returnType->getName()), ['HasOne', 'HasMany', 'BelongsTo', 'BelongsToMany', 'MorphToMany', 'MorphTo'])) {
                    $relations[] = [
                        'name' => $reflectionMethod->getName(),
                        'type' => $returnType->getName()
                    ];
                }
            }
        }

        return $relations;
    }
}
