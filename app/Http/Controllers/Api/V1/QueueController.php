<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;

class QueueController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo){
        $this->transactionRepo = $transactionRepo;
    }
    
    public function push(Request $request){
        $user = auth('api')->user();
        if(!$user) return response()->json(['status' => false, 'message' => 'Cannot find user.']);
        return $this->transactionRepo->push($request, $user);
    }
    
    public function retrieveWaitingTime($id){
        return response()->json([
            'waiting_time' => $this->transactionRepo->generateWaitingTimeFor($this->transactionRepo->findById($id)),
        ]);
    }
    
}
