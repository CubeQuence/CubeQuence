<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\DB\DB;
use CQ\Controllers\AuthWebhookController as CQAuthWebhookController;
use CQ\Response\Respond;

final class AuthWebhookController extends CQAuthWebhookController
{
    public function debug()
    {
        return Respond::prettyJson('hi');
    }

    /**
     * Delete user webhook app specific
     */
    protected function deleteSteps(string $userId): void
    {
        DB::delete(
            table: 'example',
            where: [
                'user_id' => $userId
            ]
        );
    }
}
