<?php

namespace App\Repositories;

use App\Repositories\Eloquents\LogPembelianCustomerEloquent;
use App\Repositories\Interfaces\LogPembelianCustomerInterface;
use Illuminate\Cache\CacheManager;

class LogPembelianCustomerCacheRepository implements LogPembelianCustomerInterface {
    protected $repo;
    protected $cache;

    const TTL = 1; #1 minutes

    public function __construct(
        CacheManager $cache, LogPembelianCustomerEloquent $repo
    ){
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * @return LogPembelianCustomerEloquent
     */
    public function getAll()
    {
        return $this->cache->remember('pembelian-customers', self::TTL, function () {
            return $this->repo->getAll();
        });
    }

    public function getById($id)
    {
        return $this->cache->remember('pembelian-customers.'.$id, self::TTL, function () use ($id) {
            return $this->repo->getById($id);
        });
    }

    public function getMyLog($customer_id)
    {
        return $this->cache->remember('pembelian-customers.'.$customer_id, self::TTL, function () use ($customer_id) {
            return $this->repo->getMyLog($customer_id);
        });
    }

    public function create(array $inputs)
    {
        return $this->cache->remember('pembelian-customers', self::TTL, function () use ($inputs) {
            return $this->repo->create($inputs);
        });
    }

    public function update(array $inputs, $id)
    {
        return $this->cache->remember('pembelian-customers.'.$id, self::TTL, function () use ($inputs,$id) {
            $user = $this->repo->find($id);
            $user->update($inputs);

            return $user;
        });
    }

    public function delete($id)
    {
        return $this->cache->remember('pembelian-customers.'.$id, self::TTL, function () use ($id) {
            return $this->repo->destroy($id);
        });
    }
}
