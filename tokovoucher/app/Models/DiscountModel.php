<?php

namespace App\Models;

use CodeIgniter\Model;

class DiscountModel extends Model
{
    protected $table = 'discounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'value', 'expiration_date', 'used'];

    public function getUnusedVoucher()
    {
        return $this->where('used', 0)->first();
    }
}
