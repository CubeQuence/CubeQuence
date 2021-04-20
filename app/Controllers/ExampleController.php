<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Validators\ExampleValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\User;
use CQ\Helpers\UUID;
use CQ\Response\HtmlResponse;
use CQ\Response\JsonResponse;

class ExampleController extends Controller
{
    /**
     * List entries.
     */
    public function index(): JsonResponse
    {
        $example = DB::select('example', [
            'id',
            'user_id',
            'string',
            'updated_at',
            'created_at',
        ], []);

        return $this->respond->prettyJson(
            'Example Entries',
            $example
        );
    }

    /**
     * Create entry.
     */
    public function create(object $request): HtmlResponse
    {
        try {
            ExampleValidator::create($request->data);
        } catch (\Throwable $th) {
            return $this->respond->prettyJson('Provided data was malformed', $th->getMessage(), 422);
        }

        $data = [
            'id' => UUID::v6(),
            'user_id' => User::getId(),
            'string' => $request->data->string,
        ];

        DB::create('example', $data);

        return $this->respond->prettyJson(
            'Example Created',
            $data
        );
    }

    /**
     * Update entry.
     */
    public function update(object $request, string $id): HtmlResponse
    {
        try {
            ExampleValidator::update($request->data);
        } catch (\Throwable $th) {
            return $this->respond->prettyJson(
                'Provided data was malformed',
                json_decode($th->getMessage()),
                422
            );
        }

        $example = DB::get('example', ['string'], ['id' => $id]);

        if (! $example) {
            return $this->respond->prettyJson(
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

        return $this->respond->prettyJson(
            'Example Updated',
            $data
        );
    }

    /**
     * Delete entry.
     */
    public function delete(string $id): HtmlResponse
    {
        DB::delete('example', ['id' => $id]);

        return $this->respond->prettyJson('Example Deleted');
    }
}
