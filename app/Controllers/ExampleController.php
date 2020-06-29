<?php

namespace App\Controllers;

use App\Validators\ExampleValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\UUID;
use Exception;

class ExampleController extends Controller
{
    /**
     * List entries.
     *
     * @return Json
     */
    public function index()
    {
        $example = DB::select('example', [
            'id',
            'string',
            'updated_at',
            'created_at',
        ], []);

        return $this->respondJson(
            'Example Entries',
            $example
        );
    }

    /**
     * Create entry.
     *
     * @param object $request
     *
     * @return Html
     */
    public function create($request)
    {
        try {
            ExampleValidator::create($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        $data = [
            'id' => UUID::v6(),
            'string' => $request->data->string,
        ];

        DB::create('example', $data);

        return $this->respondJson(
            'Example Created',
            $data
        );
    }

    /**
     * Update entry.
     *
     * @param object $request
     * @param string $id
     *
     * @return Html
     */
    public function update($request, $id)
    {
        try {
            ExampleValidator::update($request->data);
        } catch (Exception $e) {
            return $this->respondJson(
                'Provided data was malformed',
                json_decode($e->getMessage()),
                422
            );
        }

        $example = DB::get('example', ['string'], ['id' => $id]);

        if (!$example) {
            return $this->respondJson(
                'Example not found',
                [],
                404
            );
        }

        $data = [
            'string' => $request->data->string ?: $example['string'],
        ];

        DB::update(
            'example',
            $data,
            [
                'id' => $id,
            ]
        );

        return $this->respondJson(
            'Example Updated',
            $data
        );
    }

    /**
     * Delete entry.
     *
     * @param string $id
     *
     * @return Html
     */
    public function delete($id)
    {
        DB::delete('example', ['id' => $id]);

        return $this->respondJson('Example Deleted');
    }
}
