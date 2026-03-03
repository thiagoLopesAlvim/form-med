@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 pt-10">
    <div class="glass rounded-3xl p-10 shadow-xl border border-white/70">
        <div class="flex items-start justify-between mb-10">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-100">Envio seguro</div>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 leading-tight">QUESTIONÁRIO INICIAL PARA SOLICITAÇÃO DE CADASTRO</h1>
                <p class="text-slate-600">SGC - R 1-03-1 - Revisão:07  - Emissão: 24/02/2026.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 flex items-start space-x-3">
                <svg class="h-5 w-5 mt-0.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 00-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <div>
                    <p class="font-semibold">Tudo certo!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                <p class="font-semibold mb-2">Revise os campos abaixo:</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('form.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="submission-form">
            @csrf
            <div class="rounded-2xl border border-slate-100 bg-white/90 p-6 shadow-sm">
                <p class="block text-sm font-semibold text-slate-800 mb-3">Tipo de cadastro</p>
                <div class="flex flex-wrap gap-4">
                    <label class="inline-flex items-center gap-2 text-slate-900 text-sm font-medium px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:border-blue-200 hover:bg-blue-50 transition">
                        <input type="radio" name="registration_type" value="pj" {{ old('registration_type') === 'pj' ? 'checked' : '' }} required class="text-blue-600 border-slate-300">
                        <span>Pessoa Jurídica</span>
                    </label>
                    <label class="inline-flex items-center gap-2 text-slate-900 text-sm font-medium px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 hover:border-blue-200 hover:bg-blue-50 transition">
                        <input type="radio" name="registration_type" value="pf" {{ old('registration_type') === 'pf' ? 'checked' : '' }} required class="text-blue-600 border-slate-300">
                        <span>Pessoa Física</span>
                    </label>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white/90 p-6 shadow-sm" id="fields-common">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-semibold text-slate-900">Nome / Razão social</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Seu nome ou razão social" />
                    </div>
                    <div class="pf-only">
                        <label for="cpf" class="block text-sm font-semibold text-slate-900">CPF (PF)</label>
                        <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}"
                        class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="000.000.000-00" />
                        <p id="cpf-error" class="mt-1 text-xs text-red-600 hidden">CPF inválido.</p>
                    </div>
                    <div class="pj-only">
                        <label for="razao_social" class="block text-sm font-semibold text-slate-900">Razão social</label>
                        <input type="text" name="razao_social" id="razao_social" value="{{ old('razao_social') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="pj-only">
                        <label for="nome_fantasia" class="block text-sm font-semibold text-slate-900">Nome fantasia</label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" value="{{ old('nome_fantasia') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="pj-only">
                        <label for="cnpj" class="block text-sm font-semibold text-slate-900">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="00.000.000/0000-00" />
                    </div>
                    <div class="pj-only">
                        <label for="representante_legal" class="block text-sm font-semibold text-slate-900">Representante legal</label>
                        <input type="text" name="representante_legal" id="representante_legal" value="{{ old('representante_legal') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="pj-only">
                        <label for="website" class="block text-sm font-semibold text-slate-900">Website</label>
                        <input type="url" name="website" id="website" value="{{ old('website') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="https://" />
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-900">E-mail</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="voce@email.com" />
                    </div>
                    <div>
                        <label for="email_testemunha" class="block text-sm font-semibold text-slate-900">E-mail testemunha</label>
                        <input type="email" name="email_testemunha" id="email_testemunha" value="{{ old('email_testemunha') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="testemunha@email.com" />
                    </div>
                    <div>
                        <label for="telefone" class="block text-sm font-semibold text-slate-900">Telefone</label>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="(11) 99999-9999" />
                    </div>
                    <div>
                        <label for="nacionalidade" class="block text-sm font-semibold text-slate-900">Nacionalidade</label>
                        <input type="text" name="nacionalidade" id="nacionalidade" value="{{ old('nacionalidade') }}" required
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label for="profissao" class="block text-sm font-semibold text-slate-900">Profissão</label>
                        <input type="text" name="profissao" id="profissao" value="{{ old('profissao') }}" required
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="pf-only">
                        <label for="data_nascimento" class="block text-sm font-semibold text-slate-900">Data de nascimento</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="{{ old('data_nascimento') }}"
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-semibold text-slate-900">Endereço</label>
                        <input type="text" name="endereco" id="endereco" value="{{ old('endereco') }}" required
                            class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div class="md:col-span-2">
                        <label for="dados_bancarios" class="block text-sm font-semibold text-slate-900">Dados bancários</label>
                        <textarea name="dados_bancarios" id="dados_bancarios" rows="2" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Banco, agência, conta ou chave PIX">{{ old('dados_bancarios') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="pj-only space-y-4 rounded-2xl border border-slate-100 bg-white/90 p-6 shadow-sm">
                <div>
                    <p class="text-sm font-medium text-slate-800">Documentos solicitados (marque os que enviará)</p>
                    @php
                        $docOptions = [
                            'Cartão do CNPJ',
                            'Contrato social',
                            'Documentos pessoais dos representantes (CNH ou RG)',
                            'Estatuto social',
                            'Ata de nomeação ou procuração com poderes específicos de representação',
                            'Qualificação técnica profissional ativa (ex. CRM)',
                            'Certificação de especialização profissional',
                            'Alvará de funcionamento (válido)',
                            'Alvará sanitário (válido)',
                            'Licenças ambientais (municipais, estaduais e federais)',
                            'Certidão negativa distribuidores cíveis/criminais (Estadual)',
                            'Certidão negativa distribuidores cíveis/criminais (Federal)',
                            'Certidões de inexistência/distribuição procedimentos extrajudiciais (MPF)',
                            'Certidões de inexistência/distribuição procedimentos extrajudiciais (MPE)',
                            'Certificado de Responsabilidade Técnica',
                            'Contrato com a VH ou minuta',
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                        @foreach ($docOptions as $option)
                            <label class="inline-flex items-start space-x-2 text-sm text-slate-700">
                                <input type="checkbox" name="doc_checklist[]" value="{{ $option }}" {{ in_array($option, old('doc_checklist', [])) ? 'checked' : '' }} class="mt-0.5 text-blue-600 border-slate-300"> 
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="text-sm font-medium text-slate-800">A empresa possui:</p>
                    @php
                        $policyOptions = [
                            'Código de Ética/Conduta',
                            'Programa de Compliance estruturado',
                            'Canal de Denúncias',
                            'Política Anticorrupção',
                            'Política de Conflito de Interesses',
                            'Política de Proteção de Dados (LGPD)',
                        ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                        @foreach ($policyOptions as $option)
                            <label class="inline-flex items-start space-x-2 text-sm text-slate-700">
                                <input type="checkbox" name="compliance_policies[]" value="{{ $option }}" {{ in_array($option, old('compliance_policies', [])) ? 'checked' : '' }} class="mt-0.5 text-blue-600 border-slate-300">
                                <span>{{ $option }}</span>
                            </label>
                        @endforeach
                        <label class="inline-flex items-start space-x-2 text-sm text-slate-700">
                            <input type="checkbox" name="compliance_policies[]" value="Nenhum" {{ in_array('Nenhum', old('compliance_policies', [])) ? 'checked' : '' }} class="mt-0.5 text-blue-600 border-slate-300">
                            <span>Nenhum dos itens acima</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-800">Empresa ou sócios foram investigados por:</label>
                        <select name="investigated_for" class="mt-1 block w-full rounded-xl border border-slate-200 bg-white text-slate-900 shadow-sm focus:border-blue-400 focus:ring-blue-400">
                            <option value="" {{ old('investigated_for') === null ? 'selected' : '' }}>Selecione</option>
                            @foreach (['Corrupção','Fraude','Lavagem de dinheiro','Crimes ambientais','Infrações trabalhistas graves','Não'] as $opt)
                                <option value="{{ $opt }}" {{ old('investigated_for') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-800">Lei 12.846/2013 (Anticorrupção)</label>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-slate-700">
                            <label class="inline-flex items-center space-x-2">
                                <input type="radio" name="law_12846_compliant" value="1" {{ old('law_12846_compliant') === '1' ? 'checked' : '' }} class="text-blue-600 border-slate-300">
                                <span>Sim</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                                <input type="radio" name="law_12846_compliant" value="0" {{ old('law_12846_compliant') === '0' ? 'checked' : '' }} class="text-blue-600 border-slate-300">
                                <span>Não</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-800">LGPD</label>
                        <div class="flex items-center space-x-4 mt-2 text-sm text-slate-700">
                            <label class="inline-flex items-center space-x-2">
                                <input type="radio" name="lgpd_compliant" value="1" {{ old('lgpd_compliant') === '1' ? 'checked' : '' }} class="text-blue-600 border-slate-300">
                                <span>Sim</span>
                            </label>
                            <label class="inline-flex items-center space-x-2">
                                <input type="radio" name="lgpd_compliant" value="0" {{ old('lgpd_compliant') === '0' ? 'checked' : '' }} class="text-blue-600 border-slate-300">
                                <span>Não</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-800">Detalhes de investigações (se houver)</label>
                    <textarea name="investigation_details" rows="3" class="mt-1 block w-full rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-400 focus:ring-blue-400">{{ old('investigation_details') }}</textarea>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white/90 p-6 shadow-sm space-y-4">
                <div>
                    <label for="mensagem" class="block text-sm font-semibold text-slate-900">Observações adicionais</label>
                    <textarea name="mensagem" id="mensagem" rows="4" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Conte-nos mais...">{{ old('mensagem') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900">Documentação (PDF, JPG, PNG ou DOC até 5MB)</label>
                    <div class="mt-3 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-slate-700">
                        <input type="file" name="documents[]" id="documents" multiple required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                            class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700" />
                        <p class="mt-2 text-xs text-slate-500">Anexe todos os documentos solicitados (pode selecionar vários de uma vez).</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-white transition">Enviar formulário</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        const form = document.getElementById('submission-form');
        if (!form) return;
        const toggle = () => {
            const type = form.querySelector('input[name="registration_type"]:checked')?.value;
            const pj = type === 'pj';
            form.querySelectorAll('.pj-only').forEach(el => el.style.display = pj ? '' : 'none');
            form.querySelectorAll('.pf-only').forEach(el => el.style.display = pj ? 'none' : '');
            if (pj) {
                const cpfInput = document.getElementById('cpf');
                if (cpfInput) cpfInput.value = '';
            }
        };
        form.querySelectorAll('input[name="registration_type"]').forEach(r => r.addEventListener('change', toggle));
        toggle();

        const digits = (value) => value.replace(/\D/g, '');
        const formatCpf = (value) => {
            const v = digits(value).slice(0, 11);
            return v
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        };
        const formatCnpj = (value) => {
            const v = digits(value).slice(0, 14);
            return v
                .replace(/(\d{2})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1.$2')
                .replace(/(\d{3})(\d)/, '$1/$2')
                .replace(/(\d{4})(\d{1,2})$/, '$1-$2');
        };
        const formatPhone = (value) => {
            const v = digits(value).slice(0, 11);
            if (v.length <= 10) {
                return v
                    .replace(/(\d{2})(\d)/, '($1) $2')
                    .replace(/(\d{4})(\d{1,4})$/, '$1-$2');
            }
            return v
                .replace(/(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d{1,4})$/, '$1-$2');
        };
        const attachMask = (id, formatter) => {
            const el = document.getElementById(id);
            if (!el) return;
            const handler = () => { el.value = formatter(el.value); };
            el.addEventListener('input', handler);
            handler();
        };

        const isValidCpf = (value) => {
            const v = digits(value);
            if (v.length !== 11) return false;
            if (/^(\d)\1{10}$/.test(v)) return false;
            const calc = (factor) => {
                let total = 0;
                for (let i = 0; i < factor - 1; i++) {
                    total += parseInt(v[i], 10) * (factor - i);
                }
                const digit = ((total * 10) % 11) % 10;
                return digit === parseInt(v[factor - 1], 10);
            };
            return calc(10) && calc(11);
        };

        attachMask('cpf', formatCpf);
        attachMask('cnpj', formatCnpj);
        attachMask('telefone', formatPhone);

        form.addEventListener('submit', (e) => {
            const type = form.querySelector('input[name="registration_type"]:checked')?.value;
            const cpfInput = document.getElementById('cpf');
            const cpfError = document.getElementById('cpf-error');
            if (type === 'pf' && cpfInput) {
                const valid = isValidCpf(cpfInput.value);
                if (!valid) {
                    e.preventDefault();
                    if (cpfError) cpfError.classList.remove('hidden');
                    cpfInput.focus();
                    return;
                }
            }
            if (cpfError) cpfError.classList.add('hidden');
        });
    })();
</script>
@endsection
