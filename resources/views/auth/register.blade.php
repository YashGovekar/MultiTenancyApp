<div>
    <form method="post" action="{{ route('register.post') }}">
        @csrf
        <div>
            <label for="name">Name</label> <br>
            <input type="text" name="name" id="name" />
        </div>
        <div>
            <label for="email">Email</label> <br>
            <input type="email" name="email" id="email" />
        </div>
        <div>
            <label for="password">Password</label> <br>
            <input type="password" name="password" id="password" />
        </div>
        <button type="submit">
            Register
        </button>
    </form>
</div>
