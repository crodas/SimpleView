@foreach ($tpl->getStmts() as $token) {
    @if ($token instanceof \crodas\SimpleView\Macro\Base)
        {{ $token->run($this->context) }}
    @else
        @include($token[0], array('token' => $token ));
    @end
@end
