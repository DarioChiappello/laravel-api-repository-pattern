<?php
namespace App\Repositories;

use App\Models\OrderDetail;

class OrderDetailRepository extends BaseRepository
{
    public function __construct(OrderDetail $orderDetail)
    {
        parent::__construct($orderDetail);
    }

    public function storeDetail($id, $data, $method = "POST")
    {
        $detailData = $method === "POST" ? $this->addOrderIdToDetailData($id, $data) : $data;
        return $method === "POST" ? $this->insert($detailData) : $this->upsert($detailData, ['order_id', 'product_id'], ['amount']);
    }

    private function addOrderIdToDetailData($id, $data)
    {
        foreach($data as & $detail)
        {
            $detail['order_id'] = $id;
        }

        return $data;
    }
}
