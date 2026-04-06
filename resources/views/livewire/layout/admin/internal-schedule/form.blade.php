<?php

use App\Models\InternalSchedule;
use Livewire\Volt\Component;

new class extends Component {
    public ?InternalSchedule $schedule = null;

    public $title_id,
        $title_en,
        $date,
        $location_id,
        $location_en,
        $is_completed = false,
        $order = 0;

    public function mount($scheduleId = null)
    {
        if ($scheduleId) {
            $this->schedule = InternalSchedule::findOrFail($scheduleId);
            $this->title_id = $this->schedule->title_id;
            $this->title_en = $this->schedule->title_en;
            $this->date = $this->schedule->date;
            $this->location_id = $this->schedule->location_id;
            $this->location_en = $this->schedule->location_en;
            $this->is_completed = (bool) $this->schedule->is_completed;
            $this->order = $this->schedule->order;
        } else {
            $this->date = date('Y-m-d');
        }
    }

    public function save()
    {
        $this->validate([
            'title_id' => 'required|min:3',
            'title_en' => 'required|min:3',
            'date' => 'required|date',
            'location_id' => 'required',
            'location_en' => 'required',
            'order' => 'required|numeric',
        ]);

        $data = [
            'title_id' => $this->title_id,
            'title_en' => $this->title_en,
            'date' => $this->date,
            'location_id' => $this->location_id,
            'location_en' => $this->location_en,
            'is_completed' => $this->is_completed,
            'order' => $this->order,
        ];

        InternalSchedule::updateOrCreate(['id' => $this->schedule->id ?? null], $data);

        session()->flash('message', 'Agenda berhasil disimpan.');
        return $this->redirect(route('internal-schedule.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">
            {{ $schedule ? 'Edit Jadwal Internal' : 'Tambah Jadwal Baru' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-10">
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Nama Agenda
                        (ID)</label>
                    <input type="text" wire:model="title_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('title_id') border-red-400 @enderror">
                    @error('title_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Agenda Name
                        (EN)</label>
                    <input type="text" wire:model="title_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('title_en') border-red-400 @enderror">
                    @error('title_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Tanggal
                        Kegiatan</label>
                    <input type="date" wire:model="date"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('date') border-red-400 @enderror">
                    @error('date')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Urutan Tampil
                        (Order)</label>
                    <input type="number" wire:model="order"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Lokasi
                        (ID)</label>
                    <input type="text" wire:model="location_id" placeholder="Misal: Aula SMKN 4 Banjarmasin"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                    @error('location_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Location
                        (EN)</label>
                    <input type="text" wire:model="location_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                    @error('location_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-riak-honey/10">
                <label class="flex items-center gap-4 cursor-pointer group w-fit">
                    <div class="relative">
                        <input type="checkbox" wire:model="is_completed" class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-riak-army">
                        </div>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-riak-army">Tandai sebagai selesai
                        (Completed)</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end items-center gap-8">
            <a href="{{ route('internal-schedule.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors">Batal</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-14 py-5 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl hover:bg-riak-honey transition-all disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Simpan Agenda</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
