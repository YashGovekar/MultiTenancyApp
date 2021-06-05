<h5>Hello {{ auth()->user()->name }}!</h5> <br>
<form method="post" action="{{ route('subdomain.logout', request()->route()->account) }}">
    @csrf
    <button type="submit">
        Logout
    </button>
</form>
