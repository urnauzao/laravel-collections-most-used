<?php

namespace Tests\Feature;

use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

# php artisan test --filter=CollectionsTest
# sail artisan test --filter=CollectionsTest
class CollectionsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function guide(): void
    {
        // Collections:
        // Fazer um array se tornar Collections
        // collect();
        // Checar se é collection $x instanceof Collection
        // count() e isEmpty()
        // 1- groupBy()
        // 2- where() / whereIn() / whereNotIn() / whereNull() / whereNotNull() / firstWhere()
        // 3- map() / transform() 
        // 4- sortBy()
        // 5- toArray()
    }

    # php artisan test --filter=CollectionsTest::test_main
    # sail artisan test --filter=CollectionsTest::test_main
    public function test_main(){
        $produtos = Produto::all()->toArray();
        $this->assertNotEmpty($produtos);
        
        $frutas = collect(['abacaxi', 'pera', 'uva']);
        $this->assertEquals('abacaxi', $frutas->first());
    }

    # php artisan test --filter=CollectionsTest::test_group_by
    # sail artisan test --filter=CollectionsTest::test_group_by
    public function test_group_by(){
        $produtos = Produto::all();
        $agrupado = $produtos->groupBy('tipo');
        $this->assertNotEmpty($agrupado['normal']);
        $this->assertNotEmpty($agrupado['especial']);
    }

    # php artisan test --filter=CollectionsTest::test_where
    # sail artisan test --filter=CollectionsTest::test_where
    public function test_where(){
        $produtos = Produto::all();
        // dd($produtos->first()->toArray());
        $result1 = $produtos->where('desconto', '!=', 0);
        $this->assertNotNull($result1->toArray());
        $this->assertNotNull($result1->first()->toArray());
        $this->assertNotNull($result1->whereIn('tipo', 'normal'));
        $this->assertNotNull($produtos->firstWhere('desconto', '!=', 0)->toArray());
        $t = $produtos->where('desconto', '=',-1);
        // dd($t);
        $this->assertEmpty($t);
        $this->assertTrue($t->isEmpty() || $t->count() == 0);
    }

    # php artisan test --filter=CollectionsTest::test_map
    # sail artisan test --filter=CollectionsTest::test_map
    public function test_map(){
        $produtos = Produto::all();
        // $produtos = collect(Produto::all()->toArray());
        $produtos_com_preco_desconto_aplicado = $produtos
        ->where('desconto', '<>', 0)
        ->where('preco_com_desconto', '=', 0)
        ->map(function($produto){
            $produto['preco_com_desconto'] = $produto['preco'] - $produto['desconto'];
            return $produto;
        })
        ->first();

        $this->assertNotNull($produtos_com_preco_desconto_aplicado['id']);
        $prod = $produtos->firstWhere('id', $produtos_com_preco_desconto_aplicado['id']);
        $this->assertNotNull($produtos_com_preco_desconto_aplicado['preco_com_desconto']);
        $this->assertNotNull($prod['preco_com_desconto']);
        $this->assertEquals($prod['preco_com_desconto'], $produtos_com_preco_desconto_aplicado['preco_com_desconto']);
    }

    # php artisan test --filter=CollectionsTest::test_sort
    # sail artisan test --filter=CollectionsTest::test_sort
    public function test_sort(){
        $produtos = Produto::all();
        $ordenados = $produtos->sortBy('preco');
        $this->assertNotNull($ordenados->pluck('preco', 'id')->toArray());
        $ordenados = $produtos->sortByDesc('preco');
        $this->assertNotNull($ordenados->pluck('preco', 'id')->toArray());
    }

    # php artisan test --filter=CollectionsTest::test_to_array
    # sail artisan test --filter=CollectionsTest::test_to_array
    public function test_to_array(){
        $produtos = Produto::all();
        $this->assertIsString($produtos->toJson());
        $this->assertIsArray($produtos->toArray());
        // dd($produtos->toBase());
    }

}
