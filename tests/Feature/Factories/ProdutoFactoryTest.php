<?php

namespace Tests\Feature\Factories;

use App\Models\Produto;
use Tests\TestCase;

# sail artisan test --filter=ProdutoFactoryTest
class ProdutoFactoryTest extends TestCase
{
    public function test_main(){
        $produto = Produto::factory()->make();
        dd($produto);
    }
}
