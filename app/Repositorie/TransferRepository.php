<?php

declare(strict_types=1);

namespace App\Repositorie;

use App\Model\Transfer;

class TransferRepository
{
    /**
     * @var Transfer
    */
    public function __construct(readonly protected Transfer $transfer)
    {
    }

    public function createTransfer(array $data): array
    {
        return $this->transfer->newModelQuery()->create($data)->first()?->getAttributes();
    }
}
