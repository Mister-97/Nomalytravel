<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    /**
     * Only surface major commercial airports (large + medium).
     */
    private const ALLOWED_TYPES = ['large_airport', 'medium_airport'];

    /**
     * Search airports
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'term'  => 'required|string|min:2',
            'type'  => 'sometimes|in:name,code,city',
            'limit' => 'sometimes|integer|min:1|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $term  = $request->input('term');
            $type  = $request->input('type', 'name');
            $limit = $request->input('limit', 10);

            Log::info('Airport search:', ['term' => $term, 'type' => $type, 'limit' => $limit]);

            $query = Airport::whereIn('type', self::ALLOWED_TYPES);

            switch ($type) {
                case 'code':
                    $query->where('iata_code', 'LIKE', '%' . $term . '%');
                    break;
                case 'city':
                    $query->where('city', 'LIKE', '%' . $term . '%');
                    break;
                default:
                    $query->where(function ($q) use ($term) {
                        $q->where('name', 'LIKE', '%' . $term . '%')
                          ->orWhere('city', 'LIKE', '%' . $term . '%')
                          ->orWhere('iata_code', 'LIKE', '%' . $term . '%');
                    });
                    break;
            }

            $results = $query->select('id', 'name', 'city', 'iata_code', 'country', 'type')
                             ->orderByRaw("FIELD(type, 'large_airport', 'medium_airport')")
                             ->limit($limit)
                             ->get();

            Log::info('Airport search results:', ['count' => $results->count()]);

            return response()->json([
                'success' => true,
                'data'    => $results,
                'meta'    => [
                    'total' => $results->count(),
                    'term'  => $term,
                    'type'  => $type
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Airport search error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while searching airports',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get popular airports (large airports first)
     */
    public function popular()
    {
        try {
            $popularAirports = Airport::whereIn('type', self::ALLOWED_TYPES)
                ->select('id', 'name', 'city', 'iata_code', 'country', 'type')
                ->orderByRaw("FIELD(type, 'large_airport', 'medium_airport')")
                ->limit(20)
                ->get();

            return response()->json([
                'success' => true,
                'data'    => $popularAirports
            ]);

        } catch (\Exception $e) {
            Log::error('Popular airports error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch popular airports',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get airport details
     */
    public function show($id)
    {
        try {
            $airport = Airport::findOrFail($id);

            return response()->json([
                'success' => true,
                'data'    => $airport
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Airport not found',
                'error'   => $e->getMessage()
            ], 404);
        }
    }
}
