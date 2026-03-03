<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_type',
        'nome',
        'cpf',
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'representante_legal',
        'website',
        'endereco',
        'email',
        'email_testemunha',
        'telefone',
        'nacionalidade',
        'profissao',
        'data_nascimento',
        'dados_bancarios',
        'mensagem',
        'doc_checklist',
        'compliance_policies',
        'investigated_for',
        'investigation_details',
        'law_12846_compliant',
        'lgpd_compliant',
        'documents',
    ];

    protected $casts = [
        'documents' => 'array',
        'doc_checklist' => 'array',
        'compliance_policies' => 'array',
        'data_nascimento' => 'date',
        'law_12846_compliant' => 'boolean',
        'lgpd_compliant' => 'boolean',
    ];
}
