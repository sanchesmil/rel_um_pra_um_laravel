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
        Schema::create('enderecos', function (Blueprint $table) {
            //Modelando o relacionamento 1 x 1 

            $table->unsignedBigInteger('cliente_id');  // Recebe a chave estrangeira de cliente
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->primary('cliente_id'); // Define a chave primária como sendo a chave estrangeira de cliente
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
