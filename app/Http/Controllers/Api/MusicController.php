<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;
use App\Http\Resources\MusicResource;
use App\Http\Requests\MusicRequest;

class MusicController extends Controller
{
    // INDEX (GET /api/musics)
    public function index()
    {
        $musics = Music::where('is_active', true)->orderBy('day_of_week')->get();
        return MusicResource::collection($musics);
    }

    // INSERT (POST /api/musics)
    public function store(MusicRequest $request)
    {
        // 1. Valida e cria
        $music = Music::create($request->validated());

        // 2. Retorna a música recém-criada (Isso garante que não venha vazio)
        return new MusicResource($music);
    }

    // SHOW (GET /api/musics/{id})
    public function show(Music $music)
    {
        return new MusicResource($music);
    }

    // UPDATE (PUT/PATCH /api/musics/{id})
    public function update(MusicRequest $request, Music $music)
    {
        // O MusicRequest valida os dados novos
        // O $music já é o objeto encontrado no banco pelo ID da URL
        $music->update($request->validated());
        return new MusicResource($music);
    }

    // DELETE (DELETE /api/musics/{id})
    public function destroy(Music $music)
    {
        $music->delete();
        return response()->json(['message' => 'Música removida com sucesso'], 200);
    }
}
