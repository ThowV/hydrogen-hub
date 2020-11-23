<div>
    <h1 class="text-gray-700 text-2xl">Password reset</h1>
    <form action="{{route('password.reset')}}" method="post">
        @csrf
        <input type="email" name="email">
        @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror

        <input type="text" name="password">
        @error('password') <span class="error text-red-500">{{ $message }}</span> @enderror

        <input type="text" name="password_confirmation">
        @error('password_confirmation') <span class="error text-red-500">{{ $message }}</span> @enderror

        <input type="hidden" name="token" value="{{Request::query('token')}}">
        <button type="submit">Send</button>

    </form>
</div>
