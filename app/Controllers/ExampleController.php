<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Validators\ExampleValidator;
use CQ\Controllers\Controller;
use CQ\DB\DB;
use CQ\Helpers\AuthHelper;
use CQ\Helpers\UuidHelper;
use CQ\Response\JsonResponse;
use CQ\Response\Respond;

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

        return Respond::prettyJson(
            message: 'Example Entries',
            data: $example
        );
    }

    /**
     * Create entry.
     */
    public function create(object $request): JsonResponse
    {
        try {
            ExampleValidator::create($request->data);
        } catch (\Throwable $th) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                data: $th->getMessage(),
                code: 422
            );
        }

        $user = AuthHelper::getUser();
        $data = [
            'id' => UuidHelper::v6(),
            'user_id' => $user->getId(),
            'string' => $request->data->string,
        ];

        DB::create(
            table: 'example',
            data: $data
        );

        return Respond::prettyJson(
            message: 'Example Created',
            data: $data
        );
    }

    /**
     * Update entry.
     */
    public function update(object $request, string $id): JsonResponse
    {
        try {
            ExampleValidator::update($request->data);
        } catch (\Throwable $th) {
            return Respond::prettyJson(
                message: 'Provided data was malformed',
                data: $th->getMessage(),
                code: 422
            );
        }

        $example = DB::get('example', ['string'], ['id' => $id]);

        if (!$example) {
            return Respond::prettyJson(
                message: 'Example not found',
                code: 404
            );
        }

        $data = [
            'string' => $request->data->string ?: $example['string'],
        ];

        DB::update(
            table: 'example',
            data: $data,
            where: [
                'id' => $id,
            ]
        );

        return Respond::prettyJson(
            message: 'Example Updated',
            data: $data
        );
    }

    /**
     * Delete entry.
     */
    public function delete(string $id): JsonResponse
    {
        DB::delete(
            table: 'example',
            where: ['id' => $id]
        );

        return Respond::prettyJson(
            message: 'Example Deleted'
        );
    }
}
