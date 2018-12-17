<?php

namespace App\Repositories\Contracts;

interface TableContract {
    public function forTable(\Illuminate\Http\Request $request);
}