foreach({{$token[1]}}) {
    @include('body', array('tpl' => $token[2]))
}
