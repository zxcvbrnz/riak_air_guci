<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UniqueCode;
use App\Models\Member;

class UniqueCodeInput extends Component
{
    public $code;

    public function submit()
    {
        $this->validate([
            'code' => 'required|exists:unique_codes,code'
        ]);

        $uniqueCode = UniqueCode::where('code', $this->code)->first();

        // 1. Cek apakah unique code sudah digunakan (baik lewat relasi member atau kolom is_used)
        if ($uniqueCode->is_used || $uniqueCode->member) {
            session()->flash('error', 'Kode sudah digunakan');
            return;
        }

        // 2. Buat member baru dengan unique code yang dipilih
        Member::create([
            'unique_code_id' => $uniqueCode->id
        ]);

        // 3. UBAH STATUS KODE MENJADI USED (Tambahan Utama)
        $uniqueCode->update([
            'is_used' => true
        ]);

        session()->flash('message', 'Kode berhasil diverifikasi.');

        // 4. Redirect ke dashboard
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.unique-code-input');
    }
}
