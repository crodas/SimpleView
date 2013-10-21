//foobar
@if ($token[1][0] == '@')
    echo var_export({{substr($token[1], 1)}}, true);
@else
    echo {{ $token[1] }};
@end
