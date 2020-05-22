<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Cliente;
use App\Endereco;

Route::get('/clientes', function(){
    $clientes = Cliente::all();

    echo '<h1> Busca os dados de Endereço a partir do Cliente "hasOne" </h1>';
    foreach($clientes as $c){
        echo '<p>ID: '       . $c->id . ' </p>';  
        echo '<p>NOME: '     . $c->nome . ' </p>'; 
        echo '<p>TELEFONE: ' . $c->telefone . ' </p>'; 

        // Busca os dados de endereço a partir do relacionamento 'hasOne'
        echo '<p>RUA: '      . $c->endereco->rua . ' </p>';  
        echo '<p>NÚMERO: '   . $c->endereco->numero . ' </p>';  
        echo '<p>BAIRRO: '   . $c->endereco->bairro . ' </p>';  
        echo '<p>CIDADE: '   . $c->endereco->cidade . ' </p>';  
        echo '<p>UF: '       . $c->endereco->uf . ' </p>';  
        echo '<p>CEP: '      . $c->endereco->cep . ' </p>'; 
        echo '<hr>';
    }
});


Route::get('/enderecos', function(){
    $enderecos = Endereco::all();

    echo '<h1> Busca os dados de Cliente a partir do Endereço "belongsTo" </h1>';

    foreach($enderecos as $e){
        echo '<p>CLIENTE_ID: ' . $e->cliente_id . ' </p>';  

        // Busca os dados de Cliente a partir do relacionamento 'belongsTo'
        echo '<p>NOME: '     . $e->cliente->nome . ' </p>';
        echo '<p>TELEFONE: ' . $e->cliente->telefone . ' </p>';

        echo '<p>RUA: ' . $e->rua . ' </p>';  
        echo '<p>NÚMERO: ' . $e->numero . ' </p>';  
        echo '<p>BAIRRO: ' . $e->bairro . ' </p>';  
        echo '<p>CIDADE: ' . $e->cidade . ' </p>';  
        echo '<p>UF: ' . $e->uf . ' </p>';  
        echo '<p>CEP: ' . $e->cep . ' </p>';  
        echo '<hr>';
    }
});

Route::get('/inserir', function(){
    $c = new Cliente();
    $c->nome = "Fauto Manoel";
    $c->telefone = "4555445544";
    $c->save();   

    $e = new Endereco();
    $e->rua = "Florisbela da Cunha";
    $e->numero = 1000;
    $e->bairro = "Jardim Botânico";
    $e->cidade = "Guarulhos";
    $e->uf = "SP";
    $e->cep = "78900-865";

    $c->endereco()->save($e);  // Salva Endereço diretamente no Cliente via relacionamento. Isso evita ter que regar o id do cliente inserido.


    $c = new Cliente();
    $c->nome = "Carlos Cruz";
    $c->telefone = "34 78889876";
    $c->save();   

    $e = new Endereco();
    $e->rua = "Aven. Padre Anchieta";
    $e->numero = 3100;
    $e->bairro = "Eucaliptus";
    $e->cidade = "Taboão da Serra";
    $e->uf = "MG";
    $e->cep = "67800-879";

    $c->endereco()->save($e);

    echo "Clientes inseridos com sucesso!";
});


//Lidando com a questão de carregamento de dados Lazy Loading x Eager Loading
Route::get('/clientes/json', function(){

    echo "<h1>Busca os dados de CLIENTE usando 'Lazy Loading' e 'Eager Loading'</h1>";
    
    //echo "<h2>Por padrão o Laravel trata os relacionamentos como Lazy Loading = Carregamento Tardio </h2>";
    //echo "<h2>Neste caso, retorna o Cliente sem o Endereço) </h2>";
    //$clientes = Cliente::all();  // Padrão Lazy Loading = carregamento tardio (Retorna Cliente sem o Endereço)

    echo "<h2>Carregamento Imediato com Eager Loading (Retorna o Cliente + Endereço)  </h2>";
    $clientes = Cliente::with(['endereco'])->get(); // Eager Loading = Carregamento Imediato 

    return $clientes->toJson();
});

Route::get('/enderecos/json', function(){

    echo "<h1>Busca os dados de ENDEREÇO usando 'Lazy Loading' e 'Eager Loading'</h1>";

    //echo "<h2>Padrão LAZY LOADING = Só carrega o ENDEREÇO, sem o Cliente</h2>";
    //$enderecos = Endereco::all();  // Padrão LAZY LOADING

    echo "<h2>EAGER LOADING = Carrega o ENDEREÇO e o Cliente</h2>";
    $enderecos = Endereco::with(['cliente'])->get();  // Padrão LAZY LOADING

    return $enderecos->toJson();
});