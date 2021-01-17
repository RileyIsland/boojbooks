<?php

namespace Tests\Unit\App\Repositories\Eloquent;

use App\Models\BaseModel;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Eloquent\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ConcreteEloquentRepository extends EloquentRepository implements EloquentRepositoryInterface
{
}

class EloquentRepositoryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    const ATTRIBUTES = [
        'Test Attribute Name 1' => 'Test Attribute Value 1',
    ];

    const MODEL_ID = 1;

    /** @var BaseModel|LegacyMockInterface|MockInterface */
    protected $model;

    /** @var ConcreteEloquentRepository */
    private $eloquentRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->model = Mockery::mock(BaseModel::class);
        $this->eloquentRepository = new ConcreteEloquentRepository($this->model);
    }

    public function testCreate()
    {
        $this->model->shouldReceive('create')->once()->with(self::ATTRIBUTES);
        $this->eloquentRepository->create(self::ATTRIBUTES);
    }

    public function testFind()
    {
        $this->model->shouldReceive('find')->once()->with(self::ATTRIBUTES, ['*']);
        $this->eloquentRepository->find(self::ATTRIBUTES);
    }

    public function testFindOrFail()
    {
        $this->model->shouldReceive('findOrFail')->once()->with(self::MODEL_ID, ['*']);
        $this->eloquentRepository->findOrFail(self::MODEL_ID);
    }


    public function testFindOrFailThrowsException()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->model->shouldReceive('findOrFail')->once()->with(self::MODEL_ID, ['*'])->andThrow(ModelNotFoundException::class);
        $this->eloquentRepository->findOrFail(self::MODEL_ID);
    }

    public function testFirstOrCreate()
    {
        $this->model->shouldReceive('firstOrCreate')->once()->with(self::ATTRIBUTES, []);
        $this->eloquentRepository->firstOrCreate(self::ATTRIBUTES);
    }
}
