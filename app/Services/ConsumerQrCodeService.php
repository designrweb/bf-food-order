<?php

namespace App\Services;

use App\Http\Resources\ConsumerQrCodeCollection;
use App\Repositories\ConsumerQrCodeRepository;
use bigfood\grid\BaseModelService;
use App\ConsumerQrCode;

/**
 * Class ConsumerQrCodeService
 *
 * @package App\Services
 */
class ConsumerQrCodeService extends BaseModelService
{
    /**
     * @var ConsumerQrCodeRepository
     */
    protected $repository;

    /**
     * ConsumerQrCodeService constructor.
     *
     * @param ConsumerQrCodeRepository $repository
     */
    public function __construct(ConsumerQrCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ConsumerQrCodeCollection
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new ConsumerQrCode()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new ConsumerQrCode()));
    }

    /**
     * @param $accountId
     * @return bool
     */
    public function generateQrCodeForConsumer($accountId)
    {
        try {
            return bin2hex(random_bytes(32));
        } catch (\Exception $t) {
            // TODO: check if needed exception handling
            return false;
        }
    }
}
