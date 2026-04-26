<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAll($search = null, $paginate = 6)
    {
        $query = Movie::latest();
        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%')
                ->orWhere('sinopsis', 'like', '%' . $search . '%');
        }
        return $query->paginate($paginate)->withQueryString();
    }

    public function find($id)
    {
        return Movie::findOrFail($id);
    }

    public function store(array $data)
    {
        return Movie::create($data);
    }

    public function update($id, array $data)
    {
        $movie = $this->find($id);
        $movie->update($data);
        return $movie;
    }

    public function delete($id)
    {
        $movie = $this->find($id);
        return $movie->delete();
    }
}
