<?php

namespace app\controller;

use iboxs\facade\Cookie;
use iboxs\Request;

class Index
{
    public function test()
    {
        Cookie::set('name', 'iboxs');
        return 'test';
    }

    public function json(Request $request)
    {
        return json($request->post());
    }
}
