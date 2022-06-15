# Redirecionar o navegador para oura página

redirect('/posts/index');

redirect()->route('login');

redirect()->action('PostsController@index');

return redirect()->route('user.dashboard');

return redirect()->back();
