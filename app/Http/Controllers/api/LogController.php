<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Log;

class LogController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function count()
    {
        $this->validate(request(), [
            'service_name' => 'string|exists:logs,service_name',
            'start_date' => 'date',
            'end_date' => 'date'

        ]);
        return response()->json(
            ['count' => (new Log())->getLogCountBasedOnFilter(request())],
            200
        );
    }
}
