foreach({{$token[1]}}) {
    @set($vars, explode("=>", explode("as", $token[1], 2)[1]))
    @foreach($vars as $var)
        $this->context[{{@substr(trim($var),1)}}] = {{trim($var)}};
    @end
    @include('body', array('tpl' => $token[2]))
}
