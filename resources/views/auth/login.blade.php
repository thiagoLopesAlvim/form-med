@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center pt-12 px-4">
    <div class="w-full max-w-md rounded-3xl p-8 bg-slate-200 border border-slate-300 shadow">
        <div class="flex flex-col items-center mb-6 space-y-2">
            <div class="bg-slate-200 rounded-md p-2 shadow-inner">
                <img src="{{ asset('Logo/logo-vitoriahspitalar2.png') }}" alt="Logo" class="h-16 w-auto object-contain" />
            </div>
            <h1 class="text-2xl font-semibold text-slate-900">Acesso Administrativo</h1>
            <p class="text-sm text-slate-600">Somente usuários autorizados.</p>
        </div>
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login.perform') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-800" for="email">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-400 focus:ring-blue-400" />
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-800" for="password">Senha</label>
                <input id="password" name="password" type="password" required
                    class="mt-1 block w-full rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400 shadow-sm focus:border-blue-400 focus:ring-blue-400" />
            </div>
            <div class="flex items-center justify-between">
                <label class="inline-flex items-center text-sm text-slate-700">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 shadow-sm focus:border-blue-400 focus:ring-blue-400">
                    <span class="ml-2">Lembrar</span>
                </label>
                <button type="submit"
                    class="inline-flex justify-center rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 focus:ring-offset-white">
                    Entrar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
