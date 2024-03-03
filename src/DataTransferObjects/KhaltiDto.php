<?php
namespace SamratThapa\SamratKhalti\DataTransferObjects;
class KhaltiDto{
    public function __construct(
        public readonly string $purchaseOrderId,
        public readonly string $purchaseOrderName,
        public readonly float $amount,
    )
    {}

    public static function fromRequest(\Illuminate\Http\Request $request){
        return new  self(
            purchaseOrderId: $request->input('purchase_order_id',0),
            purchaseOrderName: $request->input('purchase_order_name',$request->input('purchase_order_id',0)),
            amount: $request->input('amount',0)*100
            );
    }
}
