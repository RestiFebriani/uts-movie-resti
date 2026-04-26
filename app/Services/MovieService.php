<?php

namespace App\Services;

use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MovieService
{
    protected $movieRepo;

    public function __construct(MovieRepositoryInterface $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function listMovies($search)
    {
        return $this->movieRepo->getAll($search, 6);
    }

    public function adminListMovies()
    {
        return $this->movieRepo->getAll(null, 10);
    }

    public function getMovieById($id)
    {
        return $this->movieRepo->find($id);
    }

    public function createMovie(array $data, $imageFile)
    {
        $data['foto_sampul'] = $this->uploadImage($imageFile);
        return $this->movieRepo->store($data);
    }

    public function updateMovie($id, array $data, $imageFile = null)
    {
        $movie = $this->movieRepo->find($id);

        if ($imageFile) {
            $this->deleteImage($movie->foto_sampul);
            $data['foto_sampul'] = $this->uploadImage($imageFile);
        }

        return $this->movieRepo->update($id, $data);
    }

    public function deleteMovie($id)
    {
        $movie = $this->movieRepo->find($id);
        $this->deleteImage($movie->foto_sampul);
        return $this->movieRepo->delete($id);
    }

    // Clean Code: Mengelompokkan fungsi upload agar bisa digunakan berulang (DRY)
    private function uploadImage($file)
    {
        $fileName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $fileName);
        return $fileName;
    }

    private function deleteImage($fileName)
    {
        if (File::exists(public_path('images/' . $fileName))) {
            File::delete(public_path('images/' . $fileName));
        }
    }
}
