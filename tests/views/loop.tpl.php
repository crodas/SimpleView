@foreach($users as $user1)
    @set($user, $user1)
    hi {{$user}}
    @continue
@end
