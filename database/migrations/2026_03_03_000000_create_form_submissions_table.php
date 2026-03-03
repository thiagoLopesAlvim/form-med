<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('registration_type');
            $table->string('nome');
            $table->string('cpf')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('representante_legal')->nullable();
            $table->string('website')->nullable();
            $table->text('endereco');
            $table->string('email');
            $table->string('email_testemunha')->nullable();
            $table->string('telefone')->nullable();
            $table->string('nacionalidade');
            $table->string('profissao');
            $table->date('data_nascimento')->nullable();
            $table->text('dados_bancarios')->nullable();
            $table->text('mensagem')->nullable();
            $table->json('doc_checklist')->nullable();
            $table->json('compliance_policies')->nullable();
            $table->string('investigated_for')->nullable();
            $table->text('investigation_details')->nullable();
            $table->boolean('law_12846_compliant')->nullable();
            $table->boolean('lgpd_compliant')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('form_submissions');
    }
};
