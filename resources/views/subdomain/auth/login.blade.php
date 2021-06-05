<div>
    <form method="post" action="{{ route('subdomain.login.post', request()->route()->account) }}">
        @csrf
        <div>
            <label for="email">Email</label> <br>
            <input type="email" name="email" id="email" />
        </div>
        <div>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" />
        </div>
        <button type="submit">
            Login
        </button>
    </form>
</div>
