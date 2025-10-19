<?php

namespace App\Http\Services;

use App\Models\Page;
use App\Http\Resources\V1\PageResource;
use App\Http\Helpers\Http;

use function App\Http\Helpers\responseSuccess;
use function App\Http\Helpers\responseFail;

class PageService
{
    public function getPageBySlug($slug)
    {
        try {
            $page = Page::active()->where('slug', $slug)->first();

            if (!$page) {
                return responseFail(
                    status: Http::NOT_FOUND,
                    message: __('messages.Page not found')
                );
            }

            return responseSuccess(
                message: __('messages.Page retrieved successfully'),
                data: new PageResource($page)
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve page'),
                data: $e->getMessage()
            );
        }
    }

    public function getAllPages()
    {
        try {
            $pages = Page::active()->orderBy('created_at', 'desc')->get();

            return responseSuccess(
                message: __('messages.Pages retrieved successfully'),
                data: PageResource::collection($pages)
            );
        } catch (\Exception $e) {
            return responseFail(
                status: Http::INTERNAL_SERVER_ERROR,
                message: __('messages.Failed to retrieve pages'),
                data: $e->getMessage()
            );
        }
    }
}
