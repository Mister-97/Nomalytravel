<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ModulesData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TourController extends Controller
{
    /**
     * Get all tours with translations
     */
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $perPage = $request->get('per_page', 15);
        $search = $request->get('search');
        $tripType = $request->get('trip_type');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $destination = $request->get('destination');

        $query = ModulesData::where('module_id', 3) // Tours module
            ->where('status', 'active');

        // Apply filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        if ($tripType) {
            $query->where('extra_field_2', $tripType);
        }

        if ($minPrice) {
            $query->where('extra_field_1', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('extra_field_1', '<=', $maxPrice);
        }

        if ($destination) {
            $query->where('extra_field_3', $destination);
        }

        $tours = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $tours->getCollection()->transform(function ($tour) use ($locale) {
            return [
                'id' => $tour->id,
                'title' => $tour->getTranslatedTitle($locale),
                'description' => $tour->getTranslatedDescription($locale),
                'slug' => $tour->slug,
                'image' => $tour->image,
                'price' => $tour->extra_field_1,
                'trip_type' => $tour->extra_field_2,
                'destination' => $tour->extra_field_3,
                'duration' => $tour->extra_field_4,
                'group_size' => $tour->extra_field_5,
                'difficulty' => $tour->extra_field_6,
                'included' => $tour->getTranslatedExtraField(7, $locale),
                'excluded' => $tour->getTranslatedExtraField(8, $locale),
                'itinerary' => $tour->getTranslatedExtraField(9, $locale),
                'highlights' => $tour->getTranslatedExtraField(10, $locale),
                'meta_title' => $tour->getTranslatedMetaTitle($locale),
                'meta_description' => $tour->getTranslatedMetaDescription($locale),
                'created_at' => $tour->created_at,
                'updated_at' => $tour->updated_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $tours
        ]);
    }

    /**
     * Get tour by ID with translations
     */
    public function show($id, Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        
        $tour = ModulesData::where('module_id', 3)
            ->where('status', 'active')
            ->findOrFail($id);

        $tourData = [
            'id' => $tour->id,
            'title' => $tour->getTranslatedTitle($locale),
            'description' => $tour->getTranslatedDescription($locale),
            'slug' => $tour->slug,
            'image' => $tour->image,
            'price' => $tour->extra_field_1,
            'trip_type' => $tour->extra_field_2,
            'destination' => $tour->extra_field_3,
            'duration' => $tour->extra_field_4,
            'group_size' => $tour->extra_field_5,
            'difficulty' => $tour->extra_field_6,
            'included' => $tour->getTranslatedExtraField(7, $locale),
            'excluded' => $tour->getTranslatedExtraField(8, $locale),
            'itinerary' => $tour->getTranslatedExtraField(9, $locale),
            'highlights' => $tour->getTranslatedExtraField(10, $locale),
            'additional_info' => $tour->getTranslatedExtraField(11, $locale),
            'cancellation_policy' => $tour->getTranslatedExtraField(12, $locale),
            'booking_terms' => $tour->getTranslatedExtraField(13, $locale),
            'meta_title' => $tour->getTranslatedMetaTitle($locale),
            'meta_description' => $tour->getTranslatedMetaDescription($locale),
            'meta_keywords' => $tour->getTranslatedMetaKeywords($locale),
            'created_at' => $tour->created_at,
            'updated_at' => $tour->updated_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $tourData
        ]);
    }

    /**
     * Get tour by slug with translations
     */
    public function showBySlug($slug, Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        
        $tour = ModulesData::where('module_id', 3)
            ->where('status', 'active')
            ->where('slug', $slug)
            ->firstOrFail();

        return $this->show($tour->id, $request);
    }

    /**
     * Get featured tours with translations
     */
    public function getFeatured(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $limit = $request->get('limit', 6);

        $tours = ModulesData::where('module_id', 3)
            ->where('status', 'active')
            ->where('featured', 1)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($tour) use ($locale) {
                return [
                    'id' => $tour->id,
                    'title' => $tour->getTranslatedTitle($locale),
                    'description' => $tour->getTranslatedDescription($locale),
                    'slug' => $tour->slug,
                    'image' => $tour->image,
                    'price' => $tour->extra_field_1,
                    'trip_type' => $tour->extra_field_2,
                    'destination' => $tour->extra_field_3,
                    'duration' => $tour->extra_field_4,
                    'group_size' => $tour->extra_field_5,
                    'difficulty' => $tour->extra_field_6,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $tours
        ]);
    }

    /**
     * Get tour types with translations
     */
    public function getTripTypes(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        
        $tripTypes = ModulesData::where('module_id', 4) // Trip types module
            ->where('status', 'active')
            ->get()
            ->map(function ($type) use ($locale) {
                return [
                    'id' => $type->id,
                    'name' => $type->getTranslatedTitle($locale),
                    'description' => $type->getTranslatedDescription($locale),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $tripTypes
        ]);
    }

    /**
     * Get tour transport types with translations
     */
    public function getTransportTypes(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        
        $transportTypes = ModulesData::where('module_id', 5) // Transport types module
            ->where('status', 'active')
            ->get()
            ->map(function ($type) use ($locale) {
                return [
                    'id' => $type->id,
                    'name' => $type->getTranslatedTitle($locale),
                    'description' => $type->getTranslatedDescription($locale),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $transportTypes
        ]);
    }

    /**
     * Search tours with translations
     */
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'destination' => 'sometimes|string',
            'trip_type' => 'sometimes|string',
            'min_price' => 'sometimes|numeric|min:0',
            'max_price' => 'sometimes|numeric|min:0',
            'duration' => 'sometimes|string',
            'difficulty' => 'sometimes|string',
            'group_size' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $locale = $request->get('locale', app()->getLocale());
        $perPage = $request->get('per_page', 15);

        $query = ModulesData::where('module_id', 3)
            ->where('status', 'active');

        // Apply search filters
        if ($request->has('destination')) {
            $query->where('extra_field_3', 'LIKE', '%' . $request->destination . '%');
        }

        if ($request->has('trip_type')) {
            $query->where('extra_field_2', $request->trip_type);
        }

        if ($request->has('min_price')) {
            $query->where('extra_field_1', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('extra_field_1', '<=', $request->max_price);
        }

        if ($request->has('duration')) {
            $query->where('extra_field_4', 'LIKE', '%' . $request->duration . '%');
        }

        if ($request->has('difficulty')) {
            $query->where('extra_field_6', $request->difficulty);
        }

        if ($request->has('group_size')) {
            $query->where('extra_field_5', 'LIKE', '%' . $request->group_size . '%');
        }

        $tours = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $tours->getCollection()->transform(function ($tour) use ($locale) {
            return [
                'id' => $tour->id,
                'title' => $tour->getTranslatedTitle($locale),
                'description' => $tour->getTranslatedDescription($locale),
                'slug' => $tour->slug,
                'image' => $tour->image,
                'price' => $tour->extra_field_1,
                'trip_type' => $tour->extra_field_2,
                'destination' => $tour->extra_field_3,
                'duration' => $tour->extra_field_4,
                'group_size' => $tour->extra_field_5,
                'difficulty' => $tour->extra_field_6,
                'highlights' => $tour->getTranslatedExtraField(10, $locale),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $tours,
            'filters' => $request->only(['destination', 'trip_type', 'min_price', 'max_price', 'duration', 'difficulty', 'group_size'])
        ]);
    }
}
