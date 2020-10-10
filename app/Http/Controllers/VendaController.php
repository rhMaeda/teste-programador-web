<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produtos;
use App\Vendas;
use App\VendaProd;
use Carbon\Carbon;
use DB;

class VendaController extends Controller
{
    public function index()
    {
        return view('produto.listagem');
    }

    public function listProdutos(){
        $listUser = Produtos::all();
        // $listUser = DB::table('product_sale')
        // ->join('product', 'product.id', '=', 'product_sale.id_product')
        // ->join('sale', 'sale.id', '=', 'product_sale.id_sale')
        // ->get();
        return $listUser->toJson(JSON_PRETTY_PRINT);
    }
    public function criaVenda(Request $request){
        
        $total = $request->total;
        $endereco = $request->address;
        $id_product = $request->produto_id;

        $inp = ['total' =>  $total, 'date'=> Carbon::now(), 'address' => $endereco];
        Vendas::create($inp);
        $id_venda = DB::table('sale')->insertGetId($inp);
        $saleProd = ['id_sale' => $id_venda, 'id_product'=> $id_product];
        VendaProd::create($saleProd);
        $listVendas = Vendas::all();
        return  $this->listVendas();
       
        
    }

    public function listVendas(){
         $vendas = DB::table('product_sale')
         ->join('product', 'product.id', '=', 'product_sale.id_product')
         ->join('sale', 'sale.id', '=', 'product_sale.id_sale')
        ->join('provider', 'provider.id', '=', 'product.id_provider')
        ->select('provider.nameP', 'sale.*', 'product.*')
         ->get();
        // $list = Vendas::all();
        return $vendas->toJson(JSON_PRETTY_PRINT);
    }
}
