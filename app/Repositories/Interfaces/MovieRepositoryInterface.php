<?php

namespace App\Repositories\Interfaces;

interface MovieRepositoryInterface
{
    public function getAll($search = null, $paginate = 6);
    public function find($id);
    public function store(array $data);
    public function update($id, array $data);
    public function delete($id);
}
