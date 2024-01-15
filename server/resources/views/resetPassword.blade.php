<form method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$user[0]['id']}}">
    <input type="password" name="password" placeholder="New password">
    <br>
    <input type="password" name="password_confirmation" placeholder="Confirm password">
    <br>
    <input type="submit" name="submit" value="Submit">
</form>