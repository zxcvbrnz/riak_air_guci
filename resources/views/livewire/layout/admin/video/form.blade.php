<?php

use App\Models\Video;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?Video $video = null;

    // Form Properties
    public $title_id,
        $title_en,
        $category_id,
        $category_en,
        $duration,
        $thumb,
        $oldThumb,
        $video_url,
        $is_featured = false;

    public function mount($videoId = null)
    {
        if ($videoId) {
            $this->video = Video::findOrFail($videoId);
            $this->title_id = $this->video->title_id;
            $this->title_en = $this->video->title_en;
            $this->category_id = $this->video->category_id;
            $this->category_en = $this->video->category_en;
            $this->duration = $this->video->duration;
            $this->video_url = $this->video->video_url;
            $this->is_featured = $this->video->is_featured;
            $this->oldThumb = $this->video->thumb;

            // Biarkan $this->thumb tetap null agar tidak bentrok dengan string path
            $this->thumb = null;
        }
    }

    public function save()
    {
        $this->validate([
            'title_id' => 'required|min:3',
            'title_en' => 'required|min:3',
            'category_id' => 'required',
            'category_en' => 'required',
            'duration' => 'required',
            'thumb' => $this->video ? 'nullable|image|max:1024' : 'required|image|max:1024',
            'video_url' => 'required|url',
        ]);

        $data = [
            'title_id' => $this->title_id,
            'title_en' => $this->title_en,
            'category_id' => $this->category_id,
            'category_en' => $this->category_en,
            'duration' => $this->duration,
            'video_url' => $this->video_url,
            'is_featured' => $this->is_featured,
        ];

        // Hanya simpan jika ada file baru yang diunggah
        if ($this->thumb instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['thumb'] = $this->thumb->store('videos', 'public');
        }

        Video::updateOrCreate(['id' => $this->video->id ?? null], $data);

        session()->flash('message', 'Data video berhasil disimpan.');
        return $this->redirect(route('video.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-20">
    <x-slot name="header">{{ $video ? 'Edit Video' : 'Tambah Video Baru' }}</x-slot>

    <form wire:submit="save" class="space-y-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-[#DDA15E]/10 shadow-sm space-y-6">
            <h3 class="font-serif italic text-lg text-[#283618]">Informasi Video</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Judul
                        (ID)</label>
                    <input type="text" wire:model="title_id"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('title_id') border-red-400 @enderror">
                    @error('title_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Judul
                        (EN)</label>
                    <input type="text" wire:model="title_en"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('title_en') border-red-400 @enderror">
                    @error('title_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Kategori
                        (ID)</label>
                    <input type="text" wire:model="category_id" placeholder="Misal: Dokumenter"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('category_id') border-red-400 @enderror">
                    @error('category_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Kategori
                        (EN)</label>
                    <input type="text" wire:model="category_en" placeholder="Misal: Documentary"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('category_en') border-red-400 @enderror">
                    @error('category_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">Durasi</label>
                    <input type="text" wire:model="duration" placeholder="04:20"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('duration') border-red-400 @enderror">
                    @error('duration')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25]">URL Video
                        (YouTube/Vimeo)</label>
                    <input type="url" wire:model="video_url"
                        class="w-full rounded-xl border-[#DDA15E]/20 focus:ring-[#BC6C25] @error('video_url') border-red-400 @enderror">
                    @error('video_url')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-[#DDA15E]/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-[#BC6C25] mb-4">Thumbnail
                    Video</label>

                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-6">
                        <div class="relative group">
                            @if ($thumb instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $thumb->temporaryUrl() }}"
                                    class="w-40 h-24 object-cover rounded-2xl shadow-md border-2 border-[#BC6C25]">
                            @elseif($oldThumb)
                                <img src="{{ asset('storage/' . $oldThumb) }}"
                                    class="w-40 h-24 object-cover rounded-2xl border border-[#DDA15E]/20">
                            @else
                                <div
                                    class="w-40 h-24 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            <div wire:loading wire:target="thumb"
                                class="absolute inset-0 bg-white/70 backdrop-blur-[2px] rounded-2xl flex flex-col items-center justify-center gap-1">
                                <svg class="animate-spin h-5 w-5 text-[#BC6C25]" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <span
                                    class="text-[8px] font-bold text-[#BC6C25] uppercase tracking-tighter">Uploading</span>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <input type="file" wire:model="thumb"
                                class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#FEFAE0] file:text-[#283618] hover:file:bg-[#DDA15E]/20">
                            <p class="mt-2 text-[9px] text-gray-400 italic">Format: JPG, PNG, WEBP (Maks. 1MB)</p>
                        </div>
                    </div>
                    @error('thumb')
                        <p class="text-red-500 text-[9px] font-bold italic tracking-wide">* {{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <input type="checkbox" wire:model="is_featured"
                    class="rounded border-[#DDA15E]/40 text-[#BC6C25] focus:ring-[#BC6C25]">
                <label class="text-[10px] font-bold uppercase tracking-widest text-[#283618]">Tampilkan di halaman utama
                    (Featured)</label>
            </div>
        </div>

        <div class="flex justify-end gap-6 items-center">
            <a href="{{ route('video.index') }}" wire:navigate
                class="text-xs font-bold uppercase text-gray-400 hover:text-[#283618]">Batal</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-12 py-4 bg-[#BC6C25] text-white rounded-2xl text-xs font-bold uppercase tracking-widest shadow-xl shadow-[#BC6C25]/20 hover:bg-[#283618] transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="save">Simpan Video</span>
                <span wire:loading wire:target="save">Memproses...</span>
            </button>
        </div>
    </form>
</div>
