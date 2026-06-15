<?php

namespace App\Livewire;

use Livewire\Component;

class UniqueCodeInput extends Component
{
    public $code;
    public function submit()
    {
        $this->validate([
            'code' => 'required|exists:unique_codes,code'
        ]);

        $uniqueCode = \App\Models\UniqueCode::where('code', $this->code)->first();

        // cek apakah unique code sudah digunakan
        if ($uniqueCode->member) {
            session()->flash('error', 'Kode sudah digunakan');
            return;
        }

        // buat member baru dengan unique code yang dipilih
        \App\Models\Member::create([
            'unique_code_id' => $uniqueCode->id
        ]);

        // redirect ke dashboard
        return redirect()->route('dashboard');
    }
    public function render()
    {
        return view('livewire.unique-code-input');
    }
}
