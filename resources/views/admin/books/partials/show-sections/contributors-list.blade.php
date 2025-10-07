<div class="overflow-hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($contributors->sortBy('sequence_number') as $contributor)
            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex justify-between items-start mb-2">
                    <span
                        class="px-2 py-1 text-xs rounded-full flex items-center
                    @switch($contributor->contributor_type)
                        @case('author') bg-blue-100 text-blue-800 @break
                        @case('editor') bg-green-100 text-green-800 @break
                        @case('translator') bg-purple-100 text-purple-800 @break
                        @default bg-gray-100 text-gray-800
                    @endswitch">
                        <i
                            class="fas
                        @switch($contributor->contributor_type)
                            @case('author') fa-user-edit @break
                            @case('editor') fa-edit @break
                            @case('translator') fa-language @break
                            @default fa-user
                        @endswitch mr-1">
                        </i>
                        {{ ucfirst($contributor->contributor_type) }}
                    </span>
                    <span class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-sort-numeric-down mr-1"></i>
                        #{{ $contributor->sequence_number }}
                    </span>
                </div>

                <h4 class="font-semibold text-gray-900 mb-1 flex items-center">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    {{ $contributor->full_name }}
                </h4>

                @if ($contributor->email)
                    <p class="text-sm text-gray-600 mb-2 flex items-center">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        {{ $contributor->email }}
                    </p>
                @endif

                @if ($contributor->biographical_note)
                    <p class="text-sm text-gray-700 line-clamp-2 flex items-start">
                        <i class="fas fa-info-circle text-gray-400 mr-2 mt-1 flex-shrink-0"></i>
                        {{ Str::limit($contributor->biographical_note, 100) }}
                    </p>
                @endif
            </div>
        @endforeach
    </div>
</div>
