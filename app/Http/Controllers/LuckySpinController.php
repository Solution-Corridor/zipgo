<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\SpinHistory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class LuckySpinController extends Controller
{
    // LuckySpinController.php (very basic example)

    public function index()
    {
        return view('user.games.games');
    }

    public function burstNumbers()
    {
        $user = Auth::user();
        if ($user->balance < 100) {
            return redirect()->route('games')->with('error', 'You need at least Rs 100 to play Number Burst!');
        }

        return view('user.games.burst_numbers');
    }


    public function burstRecord(Request $request)
    {
        $user = Auth::user();

        // Validate incoming data
        $request->validate([
            'selected_numbers' => 'required|array',
            'selected_numbers.*' => 'integer|min:1|max:12',
            'numbers_data' => 'required|array',
            'numbers_data.*.id' => 'required|integer|min:1|max:12',
            'numbers_data.*.cost' => 'required|integer|min:1',
            'numbers_data.*.prize' => 'required|integer|min:1',
            'numbers_data.*.value' => 'required|integer',
        ]);

        $selectedNumbers = $request->selected_numbers;
        $numbersData = collect($request->numbers_data);

        // 1. Calculate total cost of selected numbers
        $totalCost = $numbersData->whereIn('id', $selectedNumbers)->sum('cost');

        // 2. Check user balance
        if ($user->balance < $totalCost) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient balance',
                'new_balance' => $user->balance,
            ], 400);
        }

        $selectedCount = count($selectedNumbers);

        // ---------- WINNER SELECTION LOGIC ----------
        if ($selectedCount == 16) {
            // All numbers selected: random 1‑5 winners from cheapest numbers
            $winnerCount = rand(1, 5); // 1 to 7 winners

            $selectedNumbersData = $numbersData->whereIn('id', $selectedNumbers)->sortBy('prize')->values();

            $winIds = [];
            foreach ($selectedNumbersData as $index => $num) {
                if ($index < $winnerCount) {
                    $winIds[] = $num['id'];
                } else {
                    break;
                }
            }

            // Random twist: 20% chance to replace the last winner with a random non‑winner
            if ($winnerCount > 0 && $winnerCount < $selectedCount && mt_rand(1, 100) <= 20) {
                $nonWinnerIds = array_diff($selectedNumbers, $winIds);
                if (!empty($nonWinnerIds)) {
                    array_pop($winIds); // remove the most expensive among winners
                    $randomNonWinner = $nonWinnerIds[array_rand($nonWinnerIds)];
                    $winIds[] = $randomNonWinner;
                }
            }
        } else {
            // General case: guarantee at least one winner that is NOT selected.
            // Each number (selected or not) wins independently with a low chance (10‑20%).
            // Winners are biased toward cheaper numbers.
            // Only selected winners contribute to the user's payout.

            $selectedSet = array_flip($selectedNumbers); // for O(1) lookup

            $allNumbers = $numbersData;
            $maxPrize = $allNumbers->max('prize');

            $winIds = [];

            // Step 1: Determine winners using independent probability
            foreach ($allNumbers as $num) {
                $isSelected = isset($selectedSet[$num['id']]);

                // Bias factor: cheaper numbers get higher chance
                $factor = min(1.8, $maxPrize / $num['prize']);

                // Base chance
                $baseChance = 0.15;

                // ❗ NEW: Penalize selected numbers
                if ($isSelected) {
                    $selectionPenalty = 0.4; // 60% reduction
                } else {
                    $selectionPenalty = 1.2; // boost non-selected
                }

                $winChance = min(0.6, $baseChance * $factor * $selectionPenalty);

                $chance = (int) round($winChance * 10000);

                if (mt_rand(1, 10000) <= $chance) {
                    $winIds[] = $num['id'];
                }
            }

            // Step 2: Ensure at least one winner is NOT selected
            $nonSelectedWinners = array_intersect($winIds, array_diff($allNumbers->pluck('id')->toArray(), $selectedNumbers));
            if (empty($nonSelectedWinners)) {
                // Force add one non‑selected winner: pick the cheapest non‑selected number (lowest prize)
                $nonSelectedNumbers = $allNumbers->whereNotIn('id', $selectedNumbers);
                if ($nonSelectedNumbers->isNotEmpty()) {
                    $cheapestNonSelected = $nonSelectedNumbers->sortBy('prize')->first();
                    $winIds[] = $cheapestNonSelected['id'];
                }
            }

            // Remove possible duplicates (just in case)
            $winIds = array_unique($winIds);
        }

        // ---------- PAYOUT CALCULATION ----------
        // Only selected winners contribute to the user's winnings
        $totalWinGain = 0;
        foreach ($numbersData as $num) {
            if (in_array($num['id'], $winIds) && in_array($num['id'], $selectedNumbers)) {
                $totalWinGain += $num['prize'];
            }
        }

        // Build win/loss map for all numbers (frontend uses this for styling)
        $winLossMap = [];
        foreach ($numbersData as $num) {
            $winLossMap[$num['id']] = in_array($num['id'], $winIds) ? 'win' : 'lose';
        }

        $winCount = count($winIds);
        $selectedWinCount = count(array_intersect($winIds, $selectedNumbers));
        $netChange = $totalWinGain - $totalCost;

        // ---------- DATABASE TRANSACTION ----------
        DB::beginTransaction();
        try {
            $user->balance += $netChange;
            $user->save();

            // Debit: record the bet
            Transaction::create([
                'user_id'  => $user->id,
                'amount'   => $totalCost,
                'trx_type' => 'burst_bet',
                'detail'   => "Number Burst: bet on " . count($selectedNumbers) . " numbers. Total cost: Rs $totalCost",
                'created_at' => now(),
            ]);

            // Credit: record winnings (if any)
            if ($totalWinGain > 0) {
                Transaction::create([
                    'user_id'  => $user->id,
                    'amount'   => $totalWinGain,
                    'trx_type' => 'burst_win',
                    'detail'   => "Number Burst: won from $selectedWinCount winning numbers (selected). Total prize: Rs $totalWinGain",
                    'created_at' => now(),
                ]);
            }

            // Prepare notification message
            if ($netChange >= 0) {
                $message = "Congratulations! You won Rs $totalWinGain. Net profit: +$netChange. New balance: Rs {$user->balance}.";
            } else {
                $message = "Unfortunately, you lost Rs $totalCost. Net loss: $netChange. New balance: Rs {$user->balance}.";
            }

            // Insert notification
            DB::table('notifications')->insert([
                'id'              => (string) Str::uuid(),
                'type'            => 'App\Notifications\BurstResult',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id'   => $user->id,
                'data'            => json_encode([
                    'message'      => $message,
                    'amount_bet'   => $totalCost,
                    'amount_won'   => $totalWinGain,
                    'net_change'   => $netChange,
                    'new_balance'  => $user->balance,
                    'win'          => $netChange > 0,
                    'icon'         => $netChange > 0 ? 'trophy' : 'dizzy',
                ], JSON_UNESCAPED_SLASHES),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: log the error
            // \Log::error('Burst transaction failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Balance update failed. Please try again.',
            ], 500);
        }

        // 6. Return result to frontend
        return response()->json([
            'success' => true,
            'new_balance' => number_format($user->balance, 2),
            'win_loss_map' => $winLossMap,
            'total_cost' => $totalCost,
            'total_win_gain' => $totalWinGain,
            'win_count' => $winCount,
            'selected_win_count' => $selectedWinCount,
            'net_change' => $netChange,
        ]);
    }


    public function profitBall()
    {
        $user = Auth::user();
        if ($user->balance < 100) {
            return redirect()->route('games')->with('error', 'You need at least Rs 100 to play Profit Ball!');
        }
        return view('user.games.profit_ball');
    }


public function profitBallsStart(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'ball_id' => 'required|integer|min:1|max:4',
        'cost'    => 'required|integer|min:1',
    ]);

    $cost = $request->cost;

    if ($user->balance < $cost) {
        return response()->json([
            'success' => false,
            'message' => 'Insufficient balance',
        ], 400);
    }

    // Deduct cost immediately (the game is a bet)
    DB::beginTransaction();
    try {
        $user->balance -= $cost;
        $user->save();

        Transaction::create([
            'user_id'   => $user->id,
            'amount'    => $cost,
            'trx_type'  => 'profit_balls_bet',
            'detail'    => "Profit Balls: bet on ball #{$request->ball_id} with cost Rs $cost",
            'created_at' => now(),
        ]);

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Transaction failed. Please try again.',
        ], 500);
    }

    // Determine the total sum of all bonuses
    $targetSum = (int) round($cost * 1.7);  // e.g. cost 100 → 170

    // Generate 4–6 bonuses (harder, fewer bonuses)
    $bonusCount = rand(8, 12);
    $bonusList = [];

    // Ensure we can achieve the target sum with the given number of bonuses
    // Each bonus must be at least 1, and we also want to avoid extreme outliers.
    // We'll generate random values within a reasonable range (1 to maxBonus) and then adjust the last one.
    $minBonus = 1;
    $maxBonus = max($minBonus, (int) ($targetSum / $bonusCount * 2)); // reasonable upper bound

    // Loop until we find a valid combination (should usually succeed in 1–2 attempts)
    $attempts = 0;
    do {
        $bonusList = [];
        $remaining = $targetSum;
        for ($i = 0; $i < $bonusCount - 1; $i++) {
            // Random value between minBonus and maxBonus, but not exceeding remaining
            $maxPossible = min($maxBonus, $remaining - ($bonusCount - $i - 1) * $minBonus);
            if ($maxPossible < $minBonus) {
                // This combination is impossible; break and retry
                $bonusList = [];
                break;
            }
            $value = rand($minBonus, $maxPossible);
            $bonusList[] = $value;
            $remaining -= $value;
        }

        // If we successfully generated the first n-1 bonuses, set the last one
        if (count($bonusList) == $bonusCount - 1 && $remaining >= $minBonus) {
            $bonusList[] = $remaining;
            // Ensure the last value is within maxBonus (optional, but we can adjust if needed)
            if ($remaining <= $maxBonus) {
                break; // valid combination found
            }
        }

        $attempts++;
        if ($attempts > 10) {
            // Fallback: distribute evenly
            $bonusList = array_fill(0, $bonusCount, (int) round($targetSum / $bonusCount));
            // Adjust the last element to hit the exact sum
            $bonusList[0] += $targetSum - array_sum($bonusList);
            break;
        }
    } while (true);

    // Shuffle the bonuses so they don't appear sorted
    shuffle($bonusList);

    // Now assign random horizontal positions (0–100%) to each bonus
    $result = [];
    foreach ($bonusList as $value) {
        $result[] = [
            'value'    => $value,
            'xPercent' => rand(0, 100),
        ];
    }

    return response()->json([
        'success'     => true,
        'new_balance' => $user->balance,
        'bonus_list'  => $result,
    ]);
}

    public function profitBallsFinish(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'ball_id'   => 'required|integer|min:1|max:4',
            'cost'      => 'required|integer|min:1',
            'collected' => 'required|integer|min:0',
        ]);

        $collected = $request->collected;

        // Add the collected amount to the user's balance (net = collected - cost, but cost already deducted)
        DB::beginTransaction();
        try {
            $user->balance += $collected;
            $user->save();

            if ($collected > 0) {
                Transaction::create([
                    'user_id'   => $user->id,
                    'amount'    => $collected,
                    'trx_type'  => 'profit_balls_win',
                    'detail'    => "Profit Balls: collected bonuses total Rs $collected",
                    'created_at' => now(),
                ]);
            }

            // Optional notification
            $net = $collected - $request->cost;
            $message = $net >= 0
                ? "Congratulations! You collected Rs $collected. Net profit: +$net. New balance: Rs {$user->balance}."
                : "You collected Rs $collected. Net loss: $net. New balance: Rs {$user->balance}.";

            DB::table('notifications')->insert([
                'id'              => (string) Str::uuid(),
                'type'            => 'App\Notifications\ProfitBallsResult',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id'   => $user->id,
                'data'            => json_encode([
                    'message'     => $message,
                    'cost'        => $request->cost,
                    'collected'   => $collected,
                    'net_change'  => $net,
                    'new_balance' => $user->balance,
                    'win'         => $net > 0,
                ]),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Transaction failed. Please try again.',
            ], 500);
        }

        return response()->json([
            'success'     => true,
            'new_balance' => $user->balance,
        ]);
    }

    public function luckySpin()
    {
        $user = Auth::user();
        if ($user->balance < 100) {
            return redirect()->route('games')->with('error', 'You need at least Rs 100 to play Lucky Spin!');
        }
        return view('user.games.lucky_spin');
    }

    public function spin(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|in:50,100,200,500,1000,2000,3000,4000,5000,8000,10000'
        ]);

        $user = auth()->user();
        $betAmount = $request->amount;           // more clear name

        if ($user->balance < $betAmount) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        // Decide outcome (~14% win chance)
        $win = fake()->boolean(14);              // ← replace in production!
        $prize = $win ? $betAmount : 0;

        $netChange = $prize - $betAmount;

        // 1. Update balance (should be wrapped in transaction in production)
        $user->balance += $netChange;
        $user->save();

        // 2. Record the bet (always)
        \App\Models\Transaction::create([
            'user_id'  => $user->id,
            'amount'   => $betAmount,                    // positive = outgoing
            'trx_type' => 'spin_bet',
            'detail'   => $win ? "Spin bet - won $prize" : 'Spin bet - lost',
            'created_at' => now(),                       // optional but explicit
        ]);

        // 3. Record the win (only if prize > 0)
        if ($prize > 0) {
            \App\Models\Transaction::create([
                'user_id'  => $user->id,
                'amount'   => $prize,                        // positive = incoming
                'trx_type' => 'spin_win',
                'detail'   => "Spin win +$prize",
                'created_at' => now(),
            ]);
        }

        // 4. Create notification (raw insert style you are using)
        $message = $win
            ? "Congratulations! You won {$prize} from your {$betAmount} spin!"
            : "You spent {$betAmount} on this spin. Better luck next time!";

        \DB::table('notifications')->insert([
            'id'              => (string) \Str::uuid(),
            'type'            => 'App\Notifications\SpinResult',
            'notifiable_type' => 'App\Models\User',
            'notifiable_id'   => $user->id,
            'data'            => json_encode([
                'message'      => $message,
                'amount_bet'   => $betAmount,
                'amount_won'   => $prize,
                'new_balance'  => $user->balance,
                'win'          => $win,
                'icon'         => $win ? 'trophy' : 'dizzy',     // optional – for frontend
            ], JSON_UNESCAPED_SLASHES),
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // 5. Response
        return response()->json([
            'success'     => true,
            'win'         => $win,
            'prize'       => $prize,
            'new_balance' => $user->balance,
            'message'     => $message,
        ]);
    }

    public function history(Request $request)
    {
        $limit = $request->query('limit', 5);
        $records = SpinHistory::where('user_id', auth()->id())
            ->latest()
            ->take($limit)
            ->get(['created_at', 'amount', 'win']);

        return response()->json($records);
    }
}
