@foreach($users as $id => $user1)
    @set($user, $user1)
    hi {{$user}}
    @set($foo, 'xxx')
    @if ($user == 1)
        @continue
    @end
@end
@foreach($users as $user1)
    hi {{$user1}}
    @break
@end
