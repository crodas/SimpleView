    {{$token[1]}} = {{$token[2]}};
    @if (preg_match("/^\\$[a-z_][a-z_0-9]*$/i", trim($token[1])))
        $this->context[{{@substr(trim($token[1]), 1)}}] = {{$token[1]}};
    @end
