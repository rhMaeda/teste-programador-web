<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()	
    {
        Model::unguard();

        $this->call('ProdutoTableSeeder');

        Model::reguard();
    }
}

class ProdutoTableSeeder extends Seeder {
	public function run()
	{

        DB::insert('insert into provider
		(name)
		values (?)',
        array('Frutaria Veneza, Frutaria Casas de oleo'));
        DB::insert('insert into provider
		(name)
		values (?)',
		array('Frutaria Carrefour'));

		DB::insert('insert into product
		(name, price, id_provider)
		values (?,?,?)',
		array('Maça', 12.00, 1));

        DB::insert('insert into product
		(name, price, id_provider)
		values (?,?,?)',
        array('Banana', 6.00, 1));

        DB::insert('insert into product
		(name, price, id_provider)
		values (?,?,?)',
        array('Pessego', 2.00, 2));

        DB::insert('insert into product
		(name, price, id_provider)
		values (?,?,?)',
        array('Tomate', 11.00, 2));
        

	}
}
