Hi {{$user['name']}}
@unless($user['has_session'])
    you must login
@end
