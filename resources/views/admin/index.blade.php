<h5>Hello {{ auth()->user()->name }}!</h5> <br>
<form method="post" action="{{ route('admin.logout') }}">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
