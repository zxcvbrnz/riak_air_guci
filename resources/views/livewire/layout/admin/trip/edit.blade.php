<?php

use App\Models\CulturalTrip;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

new class extends Component {
    use WithFileUploads;

    public ?CulturalTrip $trip = null;

    // Trip Data
    public $title_id, $title_en, $slug, $duration, $price_display, $description_id, $description_en, $image, $oldImage;

    // Relational Data
    public $batches = [];
    public $rutes = [];

    public function mount($tripId = null)
    {
        if ($tripId) {
            $this->trip = CulturalTrip::with(['batches', 'rutes'])->findOrFail($tripId);

            $this->title_id = $this->trip->title_id;
            $this->title_en = $this->trip->title_en;
            $this->slug = $this->trip->slug;
            $this->duration = $this->trip->duration;
            $this->price_display = $this->trip->price_display;
            $this->description_id = $this->trip->description_id;
            $this->description_en = $this->trip->description_en;

            $this->oldImage = $this->trip->image;
            $this->image = null;

            $this->batches = $this->trip->batches->toArray();
            $this->rutes = $this->trip->rutes->sortBy('order')->values()->toArray();
        } else {
            $this->addBatch();
            $this->addRute();
        }
    }

    public function updatedTitleId($value)
    {
        $this->slug = Str::slug($value);
    }

    public function addBatch()
    {
        $this->batches[] = ['departure_date' => '', 'available_seats' => 0];
    }

    public function removeBatch($index)
    {
        unset($this->batches[$index]);
        $this->batches = array_values($this->batches);
    }

    public function addRute()
    {
        $this->rutes[] = ['title_id' => '', 'title_en' => '', 'description_id' => '', 'description_en' => ''];
    }

    public function removeRute($index)
    {
        unset($this->rutes[$index]);
        $this->rutes = array_values($this->rutes);
    }

    public function save()
    {
        $this->validate(
            [
                'title_id' => 'required|min:5',
                'title_en' => 'required|min:5',
                'slug' => 'required|unique:cultural_trips,slug,' . ($this->trip->id ?? 'NULL'),
                'duration' => 'required',
                'price_display' => 'required',
                'image' => $this->trip ? 'nullable|image|max:1024' : 'required|image|max:1024',
                'batches.*.departure_date' => 'required|date',
                'batches.*.available_seats' => 'required|numeric',
                'rutes.*.title_id' => 'required',
            ],
            [
                'batches.*.departure_date.required' => 'Tanggal wajib diisi.',
                'rutes.*.title_id.required' => 'Judul rute wajib diisi.',
            ],
        );

        $data = [
            'title_id' => $this->title_id,
            'title_en' => $this->title_en,
            'slug' => $this->slug,
            'duration' => $this->duration,
            'price_display' => $this->price_display,
            'description_id' => $this->description_id,
            'description_en' => $this->description_en,
        ];

        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['image'] = $this->image->store('trips', 'public');
        }

        $trip = CulturalTrip::updateOrCreate(['id' => $this->trip->id ?? null], $data);

        // Sync Batches
        $trip->batches()->delete();
        foreach ($this->batches as $batch) {
            $trip->batches()->create($batch);
        }

        // Sync Rutes
        $trip->rutes()->delete();
        foreach ($this->rutes as $index => $rute) {
            $rute['order'] = $index + 1;
            $trip->rutes()->create($rute);
        }

        session()->flash('message', 'Data Trip berhasil disimpan.');
        return $this->redirect(route('trip.index'), navigate: true);
    }
}; ?>

<div class="max-w-5xl mx-auto space-y-8 pb-20">
    <x-slot name="header">{{ $trip ? 'Edit Trip' : 'Tambah Trip Baru' }}</x-slot>

    <form wire:submit="save" class="space-y-8">
        <div class="bg-white p-8 rounded-[2rem] border border-[#DDA15E]/10 shadow-sm space-y-6">
            <h3 class="font-serif italic text-lg text-[#283618]">Informasi Dasar</h3>
            <div class="grid grid-cols-2 gap-6">
                <div class="col-span-2 md:col-span-1 space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Judul
                        (ID)</label>
                    <input type="text" wire:model.live="title_id"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('title_id') border-red-400 @enderror">
                    @error('title_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1 space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Slug
                        (URL)</label>
                    <input type="text" wire:model="slug"
                        class="w-full rounded-xl border-[#DDA15E]/20 bg-gray-50 @error('slug') border-red-400 @enderror"
                        readonly>
                    @error('slug')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1 space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Durasi</label>
                    <input type="text" wire:model="duration" placeholder="3D 2N"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('duration') border-red-400 @enderror">
                    @error('duration')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1 space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Harga
                        Display</label>
                    <input type="text" wire:model="price_display" placeholder="2.850k"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('price_display') border-red-400 @enderror">
                    @error('price_display')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Foto Utama</label>
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                            <img src="{{ $image->temporaryUrl() }}"
                                class="w-32 h-32 object-cover rounded-2xl shadow-md border-2 border-[#BC6C25]">
                        @elseif($oldImage)
                            <img src="{{ asset('storage/' . $oldImage) }}"
                                class="w-32 h-32 object-cover rounded-2xl border border-[#DDA15E]/20">
                        @else
                            <div
                                class="w-32 h-32 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif

                        <div wire:loading wire:target="image"
                            class="absolute inset-0 bg-white/70 backdrop-blur-[2px] rounded-2xl flex flex-col items-center justify-center gap-1">
                            <svg class="animate-spin h-5 w-5 text-[#BC6C25]" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow">
                        <input type="file" wire:model="image"
                            class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#FEFAE0] file:text-[#283618] hover:file:bg-[#DDA15E]/20">
                        <p class="mt-2 text-[10px] text-gray-400 italic">* Kosongkan jika tidak ingin mengubah foto
                            (Maks 1MB)</p>
                        @error('image')
                            <p class="text-red-500 text-[9px] font-bold mt-1 tracking-wide">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#DDA15E]/10 shadow-sm space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-serif italic text-lg text-[#283618]">Jadwal Keberangkatan</h3>
                <button type="button" wire:click="addBatch"
                    class="text-[10px] font-bold uppercase text-[#BC6C25] hover:underline">+ Tambah Batch</button>
            </div>
            <div class="space-y-4">
                @foreach ($batches as $index => $batch)
                    <div class="p-4 bg-[#FEFAE0]/30 rounded-2xl border border-[#DDA15E]/10">
                        <div class="flex items-end gap-4">
                            <div class="flex-grow grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-[#283618] uppercase mb-1">Tanggal</label>
                                    <input type="date" wire:model="batches.{{ $index }}.departure_date"
                                        class="w-full rounded-lg border-none text-sm focus:ring-[#BC6C25] @error('batches.' . $index . '.departure_date') ring-1 ring-red-400 @enderror">
                                </div>
                                <div>
                                    <label
                                        class="block text-[9px] font-bold text-[#283618] uppercase mb-1">Kursi</label>
                                    <input type="number" wire:model="batches.{{ $index }}.available_seats"
                                        class="w-full rounded-lg border-none text-sm focus:ring-[#BC6C25] @error('batches.' . $index . '.available_seats') ring-1 ring-red-400 @enderror">
                                </div>
                            </div>
                            <button type="button" wire:click="removeBatch({{ $index }})"
                                class="text-red-400 p-2 hover:bg-red-50 rounded-lg">&times;</button>
                        </div>
                        @error('batches.' . $index . '.departure_date')
                            <p class="text-red-500 text-[8px] mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] border border-[#DDA15E]/10 shadow-sm space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-serif italic text-lg text-[#283618]">Itinerary (Rute)</h3>
                <button type="button" wire:click="addRute"
                    class="text-[10px] font-bold uppercase text-[#BC6C25] hover:underline">+ Tambah Rute</button>
            </div>
            <div class="space-y-6">
                @foreach ($rutes as $index => $rute)
                    <div class="p-6 bg-[#FEFAE0]/30 rounded-3xl space-y-4 relative border border-[#DDA15E]/10">
                        <span
                            class="absolute -left-3 top-4 w-8 h-8 bg-[#283618] text-[#FEFAE0] rounded-full flex items-center justify-center font-bold text-xs shadow-lg">{{ $index + 1 }}</span>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <input type="text" wire:model="rutes.{{ $index }}.title_id"
                                    placeholder="Judul Rute (ID)"
                                    class="w-full rounded-xl border-none text-sm focus:ring-[#BC6C25] @error('rutes.' . $index . '.title_id') ring-1 ring-red-400 @enderror">
                                @error('rutes.' . $index . '.title_id')
                                    <p class="text-red-500 text-[8px] italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-1">
                                <input type="text" wire:model="rutes.{{ $index }}.title_en"
                                    placeholder="Route Title (EN)"
                                    class="w-full rounded-xl border-none text-sm focus:ring-[#BC6C25]">
                            </div>

                            <textarea wire:model="rutes.{{ $index }}.description_id" placeholder="Deskripsi (ID)"
                                class="rounded-xl border-none text-sm focus:ring-[#BC6C25] h-20"></textarea>

                            <textarea wire:model="rutes.{{ $index }}.description_en" placeholder="Description (EN)"
                                class="rounded-xl border-none text-sm focus:ring-[#BC6C25] h-20"></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" wire:click="removeRute({{ $index }})"
                                class="text-[10px] text-red-400 font-bold uppercase hover:underline">Hapus
                                Rute</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end items-center gap-6">
            <a href="{{ route('trip.index') }}" wire:navigate
                class="text-xs font-bold uppercase text-gray-400 hover:text-[#283618]">Batal</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-12 py-4 bg-[#BC6C25] text-white rounded-2xl text-xs font-bold uppercase tracking-[0.2em] shadow-xl shadow-[#BC6C25]/20 hover:bg-[#283618] transition-all transform hover:-translate-y-1 disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                <span wire:loading wire:target="save text-white flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses...
                </span>
            </button>
        </div>
    </form>
</div>
