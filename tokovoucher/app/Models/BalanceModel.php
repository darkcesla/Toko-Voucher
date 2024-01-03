<?php

namespace App\Models;

use CodeIgniter\Model;

class BalanceModel extends Model
{
    protected $table = 'balances';
    protected $primaryKey = 'id';
    protected $allowedFields = ['balance', 'created_at', 'updated_at'];

    public function getCurrentBalance()
    {
        $latestBalance = $this->select('balance')->orderBy('id', 'DESC')->first();
        return $latestBalance ? $latestBalance['balance'] : 0;
    }

    public function decreaseBalance($amount)
    {
        $latestBalance = $this->select('balance')->orderBy('id', 'DESC')->first();
        if (!$latestBalance) {
            return false;
        }
        $newBalance = $latestBalance['balance'] - $amount;
        $this->save([
            'balance' => $newBalance,
        ]);
        return true;
    }
}
