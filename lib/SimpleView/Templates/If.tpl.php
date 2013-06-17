if ({{$token[1]}}) {
    @include("body", array('tpl' => $token[2]))
} 
@if (!empty($token[3]))
    @include("body", array('tpl' => $token[3]))
@end
