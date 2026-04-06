<?php

use App\Models\MovementSchool;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

new class extends Component {
    use WithFileUploads;

    public ?MovementSchool $school = null;

    public $slug,
        $label_id,
        $label_en,
        $title_id,
        $title_en,
        $description_id,
        $description_en,
        $media_path,
        $oldMedia,
        $type = 'image',
        $video_url,
        $order = 0;

    public function mount($schoolId = null)
    {
        if ($schoolId) {
            $this->school = MovementSchool::findOrFail($schoolId);
            $this->slug = $this->school->slug;
            $this->label_id = $this->school->label_id;
            $this->label_en = $this->school->label_en;
            $this->title_id = $this->school->title_id;
            $this->title_en = $this->school->title_en;
            $this->description_id = $this->school->description_id;
            $this->description_en = $this->school->description_en;
            $this->type = $this->school->type;
            $this->video_url = $this->school->video_url;
            $this->order = $this->school->order;
            $this->oldMedia = $this->school->media_path;
        }
    }

    // Auto slug dari Title ID
    public function updatedTitleId($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'slug' => 'required|unique:movement_schools,slug,' . ($this->school->id ?? 'NULL'),
            'label_id' => 'required',
            'label_en' => 'required',
            'title_id' => 'required',
            'title_en' => 'required',
            'description_id' => 'required',
            'description_en' => 'required',
            'type' => 'required|in:image,video',
            'video_url' => 'required_if:type,video',
            'media_path' => $this->school ? 'nullable|image|max:2048' : 'required|image|max:2048',
            'order' => 'required|numeric',
        ]);

        $data = [
            'slug' => $this->slug,
            'label_id' => $this->label_id,
            'label_en' => $this->label_en,
            'title_id' => $this->title_id,
            'title_en' => $this->title_en,
            'description_id' => $this->description_id,
            'description_en' => $this->description_en,
            'type' => $this->type,
            'video_url' => $this->video_url,
            'order' => $this->order,
        ];

        if ($this->media_path instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            $data['media_path'] = $this->media_path->store('movement-schools', 'public');
        }

        MovementSchool::updateOrCreate(['id' => $this->school->id ?? null], $data);

        session()->flash('message', 'Data berhasil disimpan.');
        return $this->redirect(route('movement-school.index'), navigate: true);
    }
}; ?>

<div class="max-w-4xl mx-auto pb-24 px-4">
    <x-slot name="header">
        <h2 class="font-serif italic text-2xl text-riak-army">
            {{ $school ? 'Edit Movement Program' : 'New Movement Program' }}</h2>
    </x-slot>

    <form wire:submit="save" class="space-y-10">
        <div class="bg-white p-10 rounded-[3rem] border border-riak-honey/10 shadow-sm space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Label (ID) - e.g
                        Rangkai Ilmu</label>
                    <input type="text" wire:model="label_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('label_id') border-red-400 @enderror">
                    @error('label_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Label (EN) -
                        e.g Education Series</label>
                    <input type="text" wire:model="label_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('label_en') border-red-400 @enderror">
                    @error('label_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Title
                        (ID)</label>
                    <input type="text" wire:model.live="title_id"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('title_id') border-red-400 @enderror">
                    @error('title_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Title
                        (EN)</label>
                    <input type="text" wire:model="title_en"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('title_en') border-red-400 @enderror">
                    @error('title_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Slug
                    (Auto-generated)</label>
                <input type="text" wire:model="slug"
                    class="w-full rounded-2xl bg-gray-50 border-riak-honey/10 text-riak-khaki text-xs" readonly>
                @error('slug')
                    <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Media
                        Type</label>
                    <select wire:model.live="type" class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                        <option value="image">Image Only</option>
                        <option value="video">Image + Video Link</option>
                    </select>
                </div>
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Order
                        (Sorting)</label>
                    <input type="number" wire:model="order"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                </div>
            </div>

            @if ($type === 'video')
                <div class="space-y-2 animate-fadeIn">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Video URL
                        (YouTube/Vimeo)</label>
                    <input type="url" wire:model="video_url" placeholder="https://..."
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army">
                    @error('video_url')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Description
                        (ID)</label>
                    <textarea wire:model="description_id" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_id') border-red-400 @enderror"></textarea>
                    @error('description_id')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey">Description
                        (EN)</label>
                    <textarea wire:model="description_en" rows="4"
                        class="w-full rounded-2xl border-riak-honey/20 focus:ring-riak-army @error('description_en') border-red-400 @enderror"></textarea>
                    @error('description_en')
                        <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-riak-honey/10">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-riak-honey mb-6">Thumbnail /
                    Cover Image</label>
                <div class="flex items-center gap-10">
                    <div
                        class="relative w-48 h-32 overflow-hidden rounded-3xl border-2 border-riak-honey/30 shadow-md bg-riak-cream/10">
                        @if ($media_path)
                            <img src="{{ $media_path->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($oldMedia)
                            <img src="{{ asset('storage/' . $oldMedia) }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center text-riak-khaki italic text-[10px]">
                                No Preview</div>
                        @endif

                        <div wire:loading wire:target="media_path"
                            class="absolute inset-0 bg-white/80 backdrop-blur-sm flex items-center justify-center">
                            <div
                                class="w-6 h-6 border-2 border-riak-army border-t-transparent rounded-full animate-spin">
                            </div>
                        </div>
                    </div>
                    <div class="flex-grow space-y-3">
                        <input type="file" wire:model="media_path"
                            class="text-[10px] text-riak-khaki file:mr-6 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-riak-cream file:text-riak-army hover:file:bg-riak-honey/20 transition-all cursor-pointer">
                        <p class="text-[10px] text-riak-khaki italic">Best ratio 16:9. Max 2MB (JPG, PNG, WEBP)</p>
                        @error('media_path')
                            <p class="text-red-500 text-[9px] italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center gap-8">
            <a href="{{ route('movement-school.index') }}" wire:navigate
                class="text-[10px] font-bold uppercase tracking-widest text-riak-khaki hover:text-riak-army transition-colors">Discard</a>
            <button type="submit" wire:loading.attr="disabled"
                class="px-14 py-5 bg-riak-army text-riak-cream rounded-2xl text-[10px] font-bold uppercase tracking-widest shadow-2xl hover:bg-riak-honey transition-all disabled:opacity-50 group">
                <span wire:loading.remove wire:target="save">Save</span>
                <span wire:loading wire:target="save" class="flex items-center gap-2">
                    <svg class="animate-spin h-3 w-3 text-white" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Processing...
                </span>
            </button>
        </div>
    </form>
</div>
