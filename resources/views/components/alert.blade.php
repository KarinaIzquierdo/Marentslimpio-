@if ($errors->any())
    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm shadow-sm">
        @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
        @endforeach
    </div>
@endif