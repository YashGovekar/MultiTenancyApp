<div>
    <form method="post" action="{{ route('customers.register.post') }}">
        @csrf
        <div>
            <label for="name">Company Name</label> <br>
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
        <div>
            <label for="subdomain">Desired Subdomain Name (For eg : abc.my-domain.com)</label> <br>
            <input type="text" name="subdomain" id="subdomain" placeholder="Type abc if you want to have abc.my-domain.com" />
        </div>
        <button type="submit">
            Register
        </button>
    </form>
</div>
