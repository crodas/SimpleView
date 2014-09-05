foreach({{$token[1]}}) {
    @set($vars, preg_split("/\bas\b/", $token[1], 2))
    @set($vars, explode("=>", $vars[1]))

    @foreach($vars as $var)
        $this->context[{{@substr(trim($var),1)}}] = {{trim($var)}};
    @end
    @include('body', array('tpl' => $token[2]))
}
