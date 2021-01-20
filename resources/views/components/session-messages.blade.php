@if (session()->has('message'))
    <div class="text-white px-6 py-4 border-0 rounded relative mb-4 bg-{{ session('message')[0] }}-500">
      <span class="inline-block align-middle mr-8">
        {{ session('message')[1] }}
      </span>
    </div>
@endif


