<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modelando o relacionamento 1 x 1, onde 1 cliente só pode ter 1 endereço.
        Schema::create('enderecos', function (Blueprint $table) {
            
            $table->unsignedBigInteger('cliente_id');  // Cria o campo 'cliente_id' que será PK e FK ao mesmo tempo
            
            $table->foreign('cliente_id')->references('id')->on('clientes');   // Define a FK com 'cliente'

            $table->primary('cliente_id'); // Define a PK de 'enderecos' como sendo a PK de 'clientes'
            // Isso evita que 1 cliente tenha mais de 1 endereço

            $table->integer('numero');
            $table->string('rua');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf');
            $table->string('cep');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
