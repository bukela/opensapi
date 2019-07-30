<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site {{$user->name}}</h2>
<br/>
<p>Your registered email is: {{$user->email}} , and access password is: {{$user->password}}</p>
<p>Follow this <a href="{{config('app.url').'/login'}}">link</a> to login.</p>
</body>

</html>