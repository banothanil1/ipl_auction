<?php

namespace App\Services;

use App\Models\Buyer;
use App\Models\Player;
use Illuminate\Http\JsonResponse;

class PlayerBid
{
    public static function bidding($buyerName): JsonResponse
    {
        $buyer = Buyer::with('players')->first();

        if (!$buyer) {
            return response()->json(['error' => 'Buyer not found'], 404);
        }

        $player = Player::first();

        if (!$player) {
            return response()->json(['error' => 'No players available for bidding'], 404);
        }

        // Present player for bidding
        $data = [
            "name" => $player->name,
            "jersey_number" => $player->jersey_number,
            "place" => $player->place,
            "age" => $player->age,
            "baseprice" => $player->baseprice
        ];

        $player->delete();

        $buyer->networth -= $player->baseprice;

        return response()->json(['message' => 'Player bid successful', 'data' => $data]);
    }
}
