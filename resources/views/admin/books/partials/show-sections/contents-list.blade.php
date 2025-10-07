<div class="overflow-hidden">
    <div class="space-y-2">
        @foreach ($contents->sortBy('sort_order') as $content)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-1">
                            @if ($content->chapter_number)
                                <span
                                    class="bg-orange-100 text-orange-800 text-sm font-medium px-2 py-1 rounded flex items-center">
                                    <i class="fas fa-hashtag mr-1"></i>
                                    Cap. {{ $content->chapter_number }}
                                </span>
                            @endif

                            @if ($content->page_start)
                                <span class="text-sm text-gray-500 flex items-center">
                                    <i class="fas fa-file-alt mr-1"></i>
                                    Pág. {{ $content->page_start }}
                                    @if ($content->page_end)
                                        - {{ $content->page_end }}
                                    @endif
                                </span>
                            @endif
                        </div>

                        <h4 class="font-semibold text-gray-900 mb-1 flex items-center">
                            <i class="fas fa-bookmark text-gray-400 mr-2"></i>
                            {{ $content->chapter_title }}
                        </h4>

                        @if ($content->description)
                            <p class="text-sm text-gray-700 flex items-start">
                                <i class="fas fa-align-left text-gray-400 mr-2 mt-1 flex-shrink-0"></i>
                                {{ $content->description }}
                            </p>
                        @endif
                    </div>

                    <span class="text-xs text-gray-400 ml-4 flex items-center">
                        <i class="fas fa-sort mr-1"></i>
                        #{{ $content->sort_order + 1 }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
