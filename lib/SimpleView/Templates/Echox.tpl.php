@if ($token[1][0] == '@')
    $__temporary = var_export({{substr($token[1], 1)}}, true);
@else
    $__temporary = {{$token[1]}};
@end
if (!empty($__temporary)) {
    echo htmlentities($__temporary, ENT_QUOTES, 'UTF-8', false);
}
