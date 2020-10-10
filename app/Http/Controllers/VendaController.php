<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;

class VendaController extends Controller
{
    public function index()
    {
        return view('produto.listagem');
    }

    public function listProdutos(){
        $listUser = Produtos::all();
        return $listUser->toJson(JSON_PRETTY_PRINT);
    }
}
