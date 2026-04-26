<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        $movies = $this->movieService->listMovies($request->search);
        return view('homepage', compact('movies'));
    }

    public function store(Request $request)
    {
        // Validasi sebaiknya di pindah ke Form Request untuk poin Clean Code tambahan
        $this->movieService->createMovie($request->all(), $request->file('foto_sampul'));
        return redirect('/')->with('success', 'Data berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $this->movieService->updateMovie($id, $request->all(), $request->file('foto_sampul'));
        return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->movieService->deleteMovie($id);
        return redirect('/movies/data')->with('success', 'Data berhasil dihapus');
    }
}
