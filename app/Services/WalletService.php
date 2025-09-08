<?php
namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class WalletService
{
    /**
     * Credit (add money) to wallet
     */
    public function credit(Wallet $wallet, float $amount, string $reason = null, array $meta = [])
    {
        return DB::transaction(function () use ($wallet, $amount, $reason, $meta) {
            $wallet->increment('balance', $amount);

            return $wallet->transactions()->create([
                'type'   => 'credit',
                'amount' => $amount,
                'reason' => $reason,
                'meta'   => $meta,
            ]);
        });
    }

    /**
     * Debit (deduct money) from wallet
     */
    public function debit(Wallet $wallet, float $amount, string $reason = null, array $meta = [])
    {
        return DB::transaction(function () use ($wallet, $amount, $reason, $meta) {
            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient balance");
            }

            $wallet->decrement('balance', $amount);

            return $wallet->transactions()->create([
                'type'   => 'debit',
                'amount' => $amount,
                'reason' => $reason,
                'meta'   => $meta,
            ]);
        });
    }

    /**
     * Hold funds (reserve money without removing from balance)
     */
    public function hold(Wallet $wallet, float $amount, string $reason = null, array $meta = [])
    {
        return DB::transaction(function () use ($wallet, $amount, $reason, $meta) {
            if ($wallet->balance < $amount) {
                throw new Exception("Insufficient balance to hold");
            }

            $wallet->decrement('balance', $amount);
            $wallet->increment('held', $amount);

            return $wallet->transactions()->create([
                'type'   => 'hold',
                'amount' => $amount,
                'reason' => $reason,
                'meta'   => $meta,
            ]);
        });
    }

    /**
     * Release funds from hold back to balance
     */
    public function release(Wallet $wallet, float $amount, string $reason = null, array $meta = [])
    {
        return DB::transaction(function () use ($wallet, $amount, $reason, $meta) {
            if ($wallet->held < $amount) {
                throw new Exception("Insufficient held funds to release");
            }

            $wallet->decrement('held', $amount);
            $wallet->increment('balance', $amount);

            return $wallet->transactions()->create([
                'type'   => 'release',
                'amount' => $amount,
                'reason' => $reason,
                'meta'   => $meta,
            ]);
        });
    }
}