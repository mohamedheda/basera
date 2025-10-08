<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

if (! function_exists('paginatedJsonResponse')) {
    function paginatedJsonResponse($paginator, ?string $message = null, ?int $code = null): JsonResponse
    {
        $code ??= Response::HTTP_OK;

        return response()->json([
            'success' => true,
            'message' => $message ?? __('messages.Data fetched successfully'),
            'data' => $paginator->items(),
            'pagination' => [
                'count' => $paginator->count(),
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ],
        ], $code);
    }
}

if (! function_exists('responseSuccess')) {
    function responseSuccess($status = 200, $message = 'Success', $data = []): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

if (! function_exists('responseFail')) {
    function responseFail($status = 422, $message = 'Failed', $data = []): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}

if (! function_exists('catchError')) {
    function catchError($e)
    {
        DB::rollBack();

        return $e->getMessage();

        return responseFail(Http::BAD_REQUEST, __('messages.Something Went Wrong'));
    }
}

if (! function_exists('store_model')) {
    function store_model($repository, $data, $returnModel = false)
    {
        DB::beginTransaction();
        try {
            $model = $repository->create($data);
            DB::commit();

            return $returnModel ? $model : responseSuccess(Http::OK, __('Added Successfully'));
        } catch (\Exception $e) {
            return catchError($e);
            // return catchError($e);
        }
    }
}

if (! function_exists('update_model')) {
    function update_model($repository, $modelId, $data, $returnModel = false)
    {
        DB::beginTransaction();
        try {
            $repository->update($modelId, $data);
            DB::commit();

            return $returnModel ? $repository->getById($modelId) : responseSuccess(Http::OK, __('messages.Updated Successfully'));
        } catch (\Exception $e) {
            return catchError($e);
        }
    }
}

if (! function_exists('delete_model')) {
    function delete_model($repository, $modelId, $filesFields = [])
    {
        DB::beginTransaction();
        try {
            $model = $repository->getById($modelId);
            if (! $model) {
                return responseFail(Http::NOT_FOUND, __('messages.No data found'));
            }

            foreach ($filesFields as $fileField) {
                if (! empty($model->$fileField)) {
                    $repository->deleteFile($model->$fileField);
                }
            }

            $repository->delete($modelId);
            DB::commit();

            return responseSuccess(Http::OK, __('messages.Deleted Successfully'));
        } catch (\Exception $e) {
            DB::rollBack();

            return catchError($e);
        }
    }
}

if (! function_exists('fileFullPath')) {
    function fileFullPath(string $path): string
    {
        return asset('storage/' . $path);
    }
}
if (! function_exists('formatDate')) {
    function formatDate($date)
    {
        return $date ? Carbon::parse($date)->format('Y-m-d H:i:s') : null;
    }
}
