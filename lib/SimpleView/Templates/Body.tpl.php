@foreach ($tpl->getStmts() as $token) {
    @include($token[0], array('token' => $token ));
@end
