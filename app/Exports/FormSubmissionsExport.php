<?php

namespace App\Exports;

use App\Models\FormSubmission;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FormSubmissionsExport implements FromCollection, WithHeadings, WithMapping
{
    private array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = FormSubmission::query()->orderByDesc('created_at');

        if (!empty($this->filters['email'])) {
            $query->where('email', 'like', '%'.$this->filters['email'].'%');
        }

        if (!empty($this->filters['from'])) {
            $query->whereDate('created_at', '>=', $this->filters['from']);
        }

        if (!empty($this->filters['to'])) {
            $query->whereDate('created_at', '<=', $this->filters['to']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tipo Cadastro',
            'Nome / Razão social',
            'CPF',
            'Razão Social',
            'Nome Fantasia',
            'CNPJ',
            'Representante Legal',
            'Website',
            'Endereço',
            'Email',
            'Email Testemunha',
            'Telefone',
            'Nacionalidade',
            'Profissão',
            'Data Nascimento',
            'Dados Bancários',
            'Mensagem',
            'Checklist Docs',
            'Políticas Compliance',
            'Investigado por',
            'Detalhes investigação',
            'Lei 12.846',
            'LGPD',
            'Qtd Documentos',
            'Criado em',
        ];
    }

    public function map($submission): array
    {
        return [
            $submission->id,
            $submission->registration_type,
            $submission->nome,
            $submission->cpf,
            $submission->razao_social,
            $submission->nome_fantasia,
            $submission->cnpj,
            $submission->representante_legal,
            $submission->website,
            $submission->endereco,
            $submission->email,
            $submission->email_testemunha,
            $submission->telefone,
            $submission->nacionalidade,
            $submission->profissao,
            optional($submission->data_nascimento)->format('Y-m-d'),
            $submission->dados_bancarios,
            $submission->mensagem,
            is_array($submission->doc_checklist) ? implode('; ', $submission->doc_checklist) : null,
            is_array($submission->compliance_policies) ? implode('; ', $submission->compliance_policies) : null,
            $submission->investigated_for,
            $submission->investigation_details,
            $submission->law_12846_compliant ? 'Sim' : 'Não',
            $submission->lgpd_compliant ? 'Sim' : 'Não',
            is_array($submission->documents) ? count($submission->documents) : 0,
            optional($submission->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
