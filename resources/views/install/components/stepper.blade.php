@php
$steps = [
    ['name' => 'Selamat Datang', 'route' => 'install.index'],
    ['name' => 'Persyaratan', 'route' => 'install.requirements'],
    ['name' => 'Database', 'route' => 'install.database'],
    ['name' => 'Info Desa', 'route' => 'install.desa'],
    ['name' => 'Admin', 'route' => 'install.admin'],
    ['name' => 'Selesai', 'route' => 'install.finalize'],
];
@endphp

<div class="mb-8">
    <div class="flex items-center">
        @foreach($steps as $index => $step)
            @php
                $isCurrent = request()->routeIs($step['route']);
                $isCompleted = $currentStep > $index + 1;
            @endphp
            
            <div class="flex items-center" style="flex: 1;">
                <div class="flex flex-col items-center" style="min-width: 80px;">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-medium mb-2
                        {{ $isCompleted ? 'bg-green-600 text-white' : ($isCurrent ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                        @if($isCompleted)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="text-xs text-center {{ $isCurrent ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                        {{ $step['name'] }}
                    </span>
                </div>
                
                @if($index < count($steps) - 1)
                    <div class="h-0.5 {{ $isCompleted ? 'bg-green-600' : 'bg-gray-200' }}" style="flex: 1; margin: 0 8px 24px 8px;"></div>
                @endif
            </div>
        @endforeach
    </div>
</div>
