<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function index(): FoodResource
    {
        $foods = Food::all();
        return new FoodResource(true,  "List data post", $foods);
    }

    public function show($id): FoodResource
    {
        $food = Food::find($id);
        return new FoodResource(true,  "Detail data post", $food);
    }

    public function store(Request $req): FoodResource|JsonResponse
    {
        $validator = Validator::make($req->all(), [
           'nama' => 'required',
           'harga' => 'required',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $image = $req->file('image');
        $image->storeAs('public/food-images', $image->hashName());

        $food = Food::create([
            'nama' => $req->nama,
            'harga' => $req->harga,
            'image' => $image->hashName()
        ]);

        return new FoodResource(true,  "Data Food Berhasil Ditambahkan!", $food);
    }

    public function update(Request $req, $food): FoodResource|JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'harga' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $food = Food::find($food);
        if (!$food){
            return response()->json(["message" => "Data Tidak Ditemukan"], 404);
        }

        if ($req->hasFile("image")){
            $image = $req->file("image");
            $image->storeAs('public/food-images', $image->hashName());

            Storage::delete('public/food-images/'.$food->image);
            $food->update([
                'nama'    => $req->nama,
                'harga'   => $req->harga,
                'image'   => $image->hashName(),
            ]);
        } else {
            $food->update([
                'nama'  => $req->nama,
                'harga' => $req->harga
            ]);
        }

        return new FoodResource(true,  "Data Food Berhasil Diupdate!", $food);
    }

    public function destroy($id): FoodResource
    {
        $food = Food::find($id);
        Storage::delete('public/food-images/' . $food->image);
        $food->delete();
        return new FoodResource(true, "Data Food Berhasil Dihapus!", null);
    }

    public function showHistory(): FoodResource
    {
        $history = History::all();
        return new FoodResource(true,  "List history order", $history);
    }

    public function addHistory(Request $req): FoodResource|JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'nama' => 'required',
            'harga' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $history = History::create([
            'nama' => $req->nama,
            'harga' => $req->harga,
            'jumlah' => $req->jumlah,
            'total_harga' => $req->total_harga
        ]);

        return new FoodResource(true,  "Data History Berhasil Ditambahkan!", $history);
    }
}
