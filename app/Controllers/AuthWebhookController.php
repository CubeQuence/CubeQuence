<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\AuthWebhookController as CQAuthWebhookController;
use CQ\DB\DB;

final class AuthWebhookController extends CQAuthWebhookController
{
    /**
     * Delete user webhook app specific
     */
    protected function deleteSteps(string $userId): void
    {
        DB::delete(
            table: 'example',
            where: [
                'user_id' => $userId,
            ]
        );
    }
}
