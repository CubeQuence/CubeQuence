<?php

namespace App\Controllers;

use Exception;
use CQ\DB\DB;
use CQ\Helpers\UUID;
use CQ\Controllers\Controller;
use App\Validators\DemoValidator;

class DemoController extends Controller
{
    /**
     * List entries
     * 
     * @return Json
     */
    public function index()
    {
        $demo = DB::select('demo', [
            'id',
            'string',
            'updated_at',
            'created_at'
        ], []);

        return $this->respondJson(
            'Demo Entries',
            $demo
        );
    }

    /**
     * Create entry
     * 
     * @param object $request
     * 
     * @return Html
     */
    public function create($request)
    {
        try {
            DemoValidator::create($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        $data = [
            'id' => UUID::v6(),
            'string' => $request->data->string
        ];

        DB::create('demo', $data);

        return $this->respondJson(
            'Demo Created',
            $data
        );
    }

    /**
     * Update entry
     * 
     * @param object $request
     * @param string $id
     * 
     * @return Html
     */
    public function update($request, $id)
    {
        try {
            DemoValidator::update($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        // get item based on id
        // check if exists

        // update
        $data = [];

        return $this->respondJson(
            'Demo Updated',
            $data
        );
    }

    /**
     * Delete entry
     * 
     * @param string $id
     * 
     * @return Html
     */
    public function delete($id)
    {
        DB::delete('history',  ['id' => $id]);

        return $this->respondJson('Demo Deleted');
    }
}
