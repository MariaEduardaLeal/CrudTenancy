<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json($user->transactions);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'cpf' => 'required|string|size:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'status' => 'required|in:Em processamento,Aprovada,Negada',
            'document' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('documents', 'public');
        }

        $data['cpf'] = preg_replace('/\D/', '', $data['cpf']);
        $data['user_id'] = Auth::id();

        $transaction = Transaction::create($data);
        return response()->json($transaction, 201);
    }
}
