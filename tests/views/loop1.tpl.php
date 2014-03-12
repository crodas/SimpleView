@foreach($users as $id => $user)
    @include("loop1-example")
    @if ($user == 1)
        @continue
    @end
@end
@foreach($users as $user)
    @include("loop1-example")
    @break
@end
