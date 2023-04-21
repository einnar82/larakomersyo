<?php

namespace App\Http\Resources\API;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection as SupportCollection;
use function Clue\StreamFilter\fun;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Collection $orderItems */
        $orderItems = $this->order_items;

        return array_merge(parent::toArray($request), [
            'order_items' => OrderItemResource::collection($this->mapOrderItems($orderItems))
        ]);
    }

    /**
     * @param Collection $orderItems
     * @return Collection
     */
    private function mapOrderItems(Collection $orderItems): Collection
    {
        return $orderItems->map(function (OrderItem $orderItem) {
            return [
                'id' => $orderItem->id,
                'product' => new ProductResource($orderItem->product)
            ];
        });
    }
}
