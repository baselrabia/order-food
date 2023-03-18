<?php

namespace App\Services;

use Illuminate\Support\Facades\DB as DBF;

class DB
{

    /**
     * @return bool
     * @throws \Exception
     */
    public static function beginTransaction()
    {
        if (DBF::transactionLevel() === 0) {
            DBF::beginTransaction();
            return true;
        }
        return false;
    }

    /**
     * @param bool $ongoingTransaction
     */
    public static function commit($ongoingTransaction)
    {
        if ($ongoingTransaction === true) {
            DBF::commit();
        }
    }

    /**
     * @param bool $ongoingTransaction
     */
    public static function rollBack($ongoingTransaction)
    {
        if ($ongoingTransaction === true) {
            DBF::rollBack();
        }
    }
}
