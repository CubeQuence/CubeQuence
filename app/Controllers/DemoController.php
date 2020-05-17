<?php

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Controllers\Controller;

class DemoController extends Controller
{
    /**
     * Index screen
     * 
     * @param object $request
     * 
     * @return Html
     */
    public function index($request)
    {
        // list in json entries in demo
    }

    /**
     * Error screen
     * 
     * @param string $httpcode
     * 
     * @return Html
     */
    public function create($code)
    {
        // create demo entry
    }

    /**
     * Error screen
     * 
     * @param string $httpcode
     * 
     * @return Html
     */
    public function update($code)
    {
        // update demo entry
    }

    /**
     * Error screen
     * 
     * @param string $httpcode
     * 
     * @return Html
     */
    public function delete($code)
    {
        // delete demo entry
    }
}
